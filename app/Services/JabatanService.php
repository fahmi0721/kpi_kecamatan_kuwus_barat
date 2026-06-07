<?php

namespace App\Services;

use App\Models\Jabatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;
use Validator;

class JabatanService
{
    public static function get_all_data(){
        $data = Jabatan::query();
        return $data;
    }

    public static function get_data_by_id($id){
        $data = Jabatan::findOrFail($id);
        return $data;
    }

    public static function Validasi($request){
       
        $request->validate([
            'nama'  => 'required|max:255',
            'deskripsi'  => 'required|max:255',
        ], [
            'nama.required'  => 'Nama Jabatan wajib diisi.',
            'nama.max'       => 'Nama Jabatan terlalu panjang, maksimal 255 karakter.',
            'deskripsi.required'  => 'Deskripsi wajib diisi.',
            'deskripsi.max'       => 'Deskripsi terlalu panjang, maksimal 255 karakter.',
        ]);
    }

    public static function Save($request)
    {
        return DB::transaction(function () use ($request) {
            $data = array(
                "nama" => $request->nama,
                "deskripsi" => $request->deskripsi,
                "parent_id" => $request->parent_id,
            );
            if(Jabatan::create($data)){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    public static function Update($request)
    {
        return DB::transaction(function () use ($request) {

            $data = array(
                "nama" => $request->nama,
                "deskripsi" => $request->deskripsi,
                "parent_id" => $request->parent_id,
            );
            if(Jabatan::findOrFail($request->id)->update($data)){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    public static function Delete($id)
    {
        return DB::transaction(function () use ($id) {
            if(Jabatan::findOrFail($id)->delete()){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    
}
