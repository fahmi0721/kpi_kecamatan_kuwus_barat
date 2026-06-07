<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
class TaskController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = TaskService::get_all_data();
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('pegawai', function ($row) {
                    return $row->pegawai->nip . " - ".$row->pegawai->nama ?? '-';
                })
                ->filterColumn('pegawai', function ($query, $keyword) {
                    $query->whereHas('pegawai', function ($q) use ($keyword) {
                        $q->where('nip', 'like', "%{$keyword}%")
                        ->orWhere('nama', 'like', "%{$keyword}%");
                    });
                })
                ->editColumn('tanggal',function($row){
                    return Carbon::parse($row->tanggal)->locale('id')->translatedFormat('d F Y');
                })

                ->editColumn('dokumentasi',function($row){
                    $img = "-";
                    if(!empty($row->dokumentasi)){
                        $img = "<img class='img img-responsive' style='max-width:50px' src='/uploads/images/".$row->dokumentasi."'>";
                    }
                    return $img;
                })

                ->editColumn('status',function($row){
                    if($row->status == "draft"){
                        return "<span class='badge text-bg-secondary'>Draft</span>";
                    }elseif($row->status == "submit"){
                        return "<span class='badge text-bg-success'>Submit</span>";
                    }elseif($row->status == "posted"){
                        return "<span class='badge text-bg-success'>Posted</span>";
                    }else{
                        return "<span class='badge text-bg-danger'>Reject</span>";
                    }
                })
                ->addColumn('aksi', function ($row) {
                    $html = '<div class="btn-group btn-group-sm">';
                        if(Auth::user()->level === "pegawai" && $row->status === "draft"){
                            $url = route('task.edit')."?id=".$row->id;
                            $html .= '<a title="Update Data" data-bs-toggle="tooltip" class="btn btn-sm btn-primary btn-edit" href="'.$url.'"><i class="fa fa-edit"></i></a>';
                            $html .= '<button title="Hapus Data" data-bs-toggle="tooltip" class="btn btn-sm btn-danger btn-delete" onclick="hapusData('.$row->id.')"><i class="fa fa-trash"></i></button>';
                        }

                        if(Auth::user()->level === "pimpinan" && $row->status === "submit"){
                            if(TaskService::cek_bawahan_langsung($row->pegawai_id)){
                                $url = route('task.approve')."?id=".$row->id;
                                $html .= '<a title="Approve Data" data-bs-toggle="tooltip" class="btn btn-sm btn-success btn-edit" href="'.$url.'"><i class="fa fa-check-square"></i></a>';
                            }
                        }

                        if(Auth::user()->level === "admin" && $row->status === "draft"){
                            $html .= '<button title="Hapus Data" data-bs-toggle="tooltip" class="btn btn-sm btn-danger btn-delete" onclick="hapusData('.$row->id.')"><i class="fa fa-trash"></i></button>';
                        }
                        if($row->status === "posted"){
                             $url = route('task.cetak-pdf',$row->id);
                            $html .= '<a title="Cetak Laporan" data-bs-toggle="tooltip" class="btn btn-sm btn-info btn-edit" href="'.$url.'"><i class="fa fa-print"></i></a>';
                        }
                        $url = route('task.view')."?id=".$row->id;
                        $html .= '<a title="Lihat Data" data-bs-toggle="tooltip" class="btn btn-sm btn-flat btn-default btn-view" href="'.$url.'"><i class="fa fa-eye"></i></a>';
                    $html .= "</div>";
                return $html;
                
            })
            ->rawColumns(['aksi','uraian','status','dokumentasi'])
            
            ->make(true);
        }else{
            return view("page.task.index");
        }
    }


    public function create()
    {
       return view("page.task.tambah");
    }

    public function store(Request $request)
    {
        try {
            TaskService::Validasi($request,"create");
            $result = TaskService::Save($request);
            return response()->json([
                'status' => 'success',
                'messages' => 'Data berhasil disimpan.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ], 500);
        }
    }

    public function cetakPdf($id, TaskService $TaskService)
{
    $data = $TaskService->get_data_by_id($id);

    $logs = $TaskService->getTimelineByTugas($id);
    $atasan_langsung = $TaskService->getAtasanLangsing($id);

    $urlVerifikasi = route('task.verifikasi', $data->id);
    $qrcode = base64_encode(
        QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($urlVerifikasi)
    );

    $pdf = Pdf::loadView('cetak.laporan', [
        'data' => $data,
        'logs' => $logs,
        'atasan_langsung' => $atasan_langsung,
         'qrcode' => $qrcode,
        'urlVerifikasi' => $urlVerifikasi,
    ])->setPaper('A4', 'portrait');

    return $pdf->stream('laporan-harian-' . $data->id . '.pdf');
}

    public function edit(Request $request)
    {
        $id = $request->id;
        $data = TaskService::get_data_by_id($id);
        return view("page.task.edit",compact('data','id'));
    }

    public function update(Request $request)
    {
        try {
            TaskService::Validasi($request,"update");
            $result = TaskService::Update($request);
            return response()->json([
                'status' => 'success',
                'messages' => 'Data berhasil diupdate.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ], 500);
        }
    }

    public function approve(Request $request)
    {
        $id = $request->id;
        $data = TaskService::get_data_by_id($id);
        return view("page.task.approve",compact('data','id'));
    }

    public function update_approve(Request $request)
    {
        try {
            TaskService::ValidasiApprove($request);
            $result = TaskService::update_approve($request);
            return response()->json([
                'status' => 'success',
                'messages' => 'Data berhasil diupdate.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id)
    {
        try {
            $result = TaskService::Delete($id);
            return response()->json([
                'status' => 'success',
                'messages' => 'Data berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'messages' => $e->getMessage()
            ], 500);
        }
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $data = TaskService::get_data_by_id($id);
        $logs = TaskService::getTimelineByTugas($id);
        return view("page.task.view",compact('data','id','logs'));
        
    }

    

    

}
