<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PegawaiService;
use Yajra\DataTables\Facades\DataTables;
class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            
            $data = PegawaiService::get_all_data();
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn("jabatan", function($row){
                    return $row->jabatan->nama;
                })
                ->editColumn('jk', function ($row) {
                    return $row->jk == 'L' ? 'Laki-Laki' : 'Perempuan';
                })
                ->addColumn('aksi', function ($row) {
                    $html = '<div class="btn-group btn-group-sm">';
                        $url = route('pegawai.edit')."?id=".$row->id;
                        $html .= '<a title="Update Data" data-bs-toggle="tooltip" class="btn btn-sm btn-primary btn-edit" href="'.$url.'"><i class="fa fa-edit"></i></a>';
                        $url = route('pegawai.edit')."?id=".$row->id;
                        $html .= '<button title="Hapus Data" data-bs-toggle="tooltip" class="btn btn-sm btn-danger btn-delete" onclick="hapusData('.$row->id.')"><i class="fa fa-trash"></i></button>';
                    $html .= "</div>";
                return $html;
                
            })
            ->rawColumns(['aksi'])
            
            ->make(true);
        }else{
            return view("page.pegawai.index");
        }
    }

    public function list(Request $request)
    {
        $search = $request->q;
        $data = PegawaiService::get_all_data()
                ->when($search, function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                })
                ->limit(20)
                ->get()
                ->map(function ($row) {
                    return [
                        'id' => $row->id,
                        'text' => $row->nip ." - " .$row->nama,
                    ];
                });
        return response()->json($data);
    }

    public function create()
    {
        return view("page.pegawai.tambah");
    }

    public function store(Request $request)
    {
        try {
            PegawaiService::Validasi($request);
            $result = PegawaiService::Save($request);
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

    public function update(Request $request)
    {
        try {
            PegawaiService::Validasi($request);
            $result = PegawaiService::Update($request);
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

    public function edit(Request $request)
    {
        $id = $request->id;
        $data = PegawaiService::get_data_by_id($id);
        return view("page.pegawai.edit",compact('data','id'));
    }

    public function destroy($id)
    {
        try {
            $result = PegawaiService::Delete($id);
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

    

}
