<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewPegawaiBawahan extends Model
{
    use HasFactory;
    protected $table = 'v_pegawai_bawahan_all';
    protected $fillable = [
                            'pegawai_atasan_id',
                            'nama_atasan',
                            'jabatan_atasan_id',
                            'jabatan_atasan',
                            'jabatan_atasan',
                            'pegawai_bawahan_id',
                            'nama_bawahan',
                            'jabatan_bawahan_id',
                            'jabatan_bawahan',
                            'jabatan_bawahan',
                            'level',
                        ];
    
   
    
}
