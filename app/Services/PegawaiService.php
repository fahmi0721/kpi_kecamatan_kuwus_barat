<?php

namespace App\Services;

use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;
use Validator;

class PegawaiService
{
    public static function get_all_data(){
        $data = Pegawai::query();
        return $data;
    }

    public static function get_data_by_id($id){
        $data = Pegawai::findOrFail($id);
        return $data;
    }
    
    public static function get_count(){
        $data = Pegawai::count();
        return $data;
    }

    public static function Validasi($request){
       
        $request->validate([
            'nip'  => 'required|max:255',
            'nama'  => 'required|max:255',
            'jk'  => 'required',
            'alamat'  => 'required',
            'jabatan_id'  => 'required',
            'no_hp'  => 'required',
        ], [
            'nip.required'  => 'NIP wajib diisi.',
            'nip.max'       => 'NIP terlalu panjang, maksimal 255 karakter.',
            'nama.required'  => 'Nama wajib diisi.',
            'nama.max'       => 'Nama terlalu panjang, maksimal 255 karakter.',
            'jk.required'     => 'Jenis Kelamin wajib diisi.',
            'alamat.required'     => 'Alamat  wajib diisi.',
            'jabatan_id.required'     => 'Jabatan wajib dipilih',
            'no_hp.required'     => 'No HP wajib diisi.',
        ]);
    }

    public static function Save($request)
    {
        return DB::transaction(function () use ($request) {
            $data = array(
                "nip" => $request->nip,
                "nama" => $request->nama,
                "jk" => $request->jk,
                "alamat" => $request->alamat,
                "jabatan_id" => $request->jabatan_id,
                "no_hp" => $request->no_hp
            );
            if(Pegawai::create($data)){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    public static function Update($request)
    {
        return DB::transaction(function () use ($request) {

            $data = array(
                "nip" => $request->nip,
                "nama" => $request->nama,
                "jk" => $request->jk,
                "alamat" => $request->alamat,
                "jabatan_id" => $request->jabatan_id,
                "no_hp" => $request->no_hp
            );
            if(Pegawai::findOrFail($request->id)->update($data)){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    public static function Delete($id)
    {
        return DB::transaction(function () use ($id) {
            if(Pegawai::findOrFail($id)->delete()){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    
}
