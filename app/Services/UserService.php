<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Exception;
use Validator;

class UserService
{
    public static function get_all_data(){
        $data = User::get_all_data();
        return $data;
    }

    public static function get_data_by_id($id){
        $data = User::findOrFail($id);
        return $data;
    }

    public static function Validasi($request,$aksi=null){

        $validates = [
            'nama'  => 'required',
            'username'  => 'required',
            'level'  => 'required',
            'pegawai_id'  => 'required',
        ];

        $messages = [
            'nama.required'  => 'Nama wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'level.required'  => 'Level wajib diisi.',
            'pegawai_id.required'  => 'Pegawai wajib diisi.',
        ];

        
        if($aksi === "create"){
            $validates += ['password'   => 'required|confirmed'];
            $messages += ['password.required'  => 'Password wajib dipilih.','password.confirmed' => 'Konfirmasi password tidak cocok.'];
        }

        if($aksi === "update" && !empty($request->password)){
            $validates += ['password'   => 'required|confirmed'];
            $messages += ['password.required'  => 'Password wajib dipilih.','password.confirmed' => 'Konfirmasi password tidak cocok.'];   
        }
       
        $request->validate($validates, $messages);
    }

    public static function Save($request)
    {
        return DB::transaction(function () use ($request) {
            $data = array(
                "nama" => $request->nama,
                "username" => $request->username,
                "level" => $request->level,
                "pegawai_id" => $request->pegawai_id,
                'password'   => Hash::make($request->password),
            );
            if(User::create($data)){
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
                "username" => $request->username,
                "level" => $request->level,
                "pegawai_id" => $request->pegawai_id,
            );
            if(!empty($request->password)){
                $data += ['password'   => Hash::make($request->password)];
            }

            if(User::findOrFail($request->id)->update($data)){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    public static function Delete($id)
    {
        return DB::transaction(function () use ($id) {
            if(User::findOrFail($id)->delete()){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    
}
