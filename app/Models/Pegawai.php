<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $fillable = [
                            'nip',
                            'nama',
                            'jk',
                            'alamat',
                            'jabatan',
                            'no_hp',
                            'jabatan_id',
                        ];
    
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }
    
}
