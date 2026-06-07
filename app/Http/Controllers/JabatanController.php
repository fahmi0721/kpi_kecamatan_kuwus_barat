<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JabatanService;
use Yajra\DataTables\Facades\DataTables;
class JabatanController extends Controller
{
    public function index(Request $request)
    {   
        // $data = JabatanService::get_all_data();
        // dd($data);exit;
        if($request->ajax()){
            
            $data = JabatanService::get_all_data();
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn("atasan",function($row){
                    return empty($row->parent_id) ? "-" : optional($row->atasan)->nama;
                })
                ->addColumn('aksi', function ($row) {
                    $html = '<div class="btn-group btn-group-sm">';
                        $url = route('jabatan.edit')."?id=".$row->id;
                        $html .= '<a title="Update Data" data-bs-toggle="tooltip" class="btn btn-sm btn-primary btn-edit" href="'.$url.'"><i class="fa fa-edit"></i></a>';
                        $url = route('jabatan.edit')."?id=".$row->id;
                        $html .= '<button title="Hapus Data" data-bs-toggle="tooltip" class="btn btn-sm btn-danger btn-delete" onclick="hapusData('.$row->id.')"><i class="fa fa-trash"></i></button>';
                    $html .= "</div>";
                return $html;
                
            })
            ->rawColumns(['aksi'])
            
            ->make(true);
        }else{
            return view("page.jabatan.index");
        }
    }

    public function list(Request $request)
    {
        $search = $request->q;
        $data = JabatanService::get_all_data()
                ->when($search, function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                })
                ->limit(20)
                ->get()
                ->map(function ($row) {
                    return [
                        'id' => $row->id,
                        'text' => $row->nama,
                    ];
                });
        return response()->json($data);
    }

    public function create()
    {
        return view("page.jabatan.tambah");
    }

    public function store(Request $request)
    {
        try {
            JabatanService::Validasi($request);
            $result = JabatanService::Save($request);
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
            JabatanService::Validasi($request);
            $result = JabatanService::Update($request);
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
        $data = JabatanService::get_data_by_id($id);
        return view("page.jabatan.edit",compact('data','id'));
    }

    public function destroy($id)
    {
        try {
            $result = JabatanService::Delete($id);
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
