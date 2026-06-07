<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\SiswaService;
use App\Services\PegawaiService;
use Yajra\DataTables\Facades\DataTables;
class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = UserService::get_all_data();
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('data_pengguna', function($row){
                    return $row->pegawai->nama ?? "-";
                })
                ->addColumn('aksi', function ($row) {
                    $url = route('user.edit')."?id=".$row->id;
                return '<div class="btn-group btn-group-sm">
                    <a title="Update Data" data-bs-toggle="tooltip" class="btn btn-sm btn-primary btn-edit" href="'.$url.'"><i class="fa fa-edit"></i></a>
                    <button title="Hapus Data" data-bs-toggle="tooltip" class="btn btn-sm btn-danger btn-delete" onclick="hapusData('.$row->id.')"><i class="fa fa-trash"></i></button>
                    </div>
                    ';
            })
            
            ->rawColumns(['aksi'])
            ->make(true);
        }else{
            return view("page.user.index");
        }
    }


    public function list_data(Request $request)
    {
        $level = $request->level;
        $search = $request->q;
        if ($level == 'siswa') {
            $data = SiswaService::get_all_data()
                ->select('id', 'nama')
                ->when($search, function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                })
                ->limit(20)
                ->get();
        } elseif ($level == 'pegawai' || $level == "admin") {
            $data = PegawaiService::get_all_data()
                ->select('id', 'nama')
                ->when($search, function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                })
                ->limit(20)
                ->get();
        } else {
            $data = collect();
        }
        return response()->json($data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("page.user.tambah");
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            UserService::Validasi($request,"create");
            $result = UserService::Save($request);
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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $data = UserService::get_data_by_id($id);
        return view("page.user.edit",compact('data','id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            UserService::Validasi($request,"update");
            $result = UserService::Update($request);
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

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $result = UserService::Delete($id);
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
