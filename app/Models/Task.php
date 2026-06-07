<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $fillable = [
        'judul',
        'tanggal',
        'uraian',
        'dokumentasi',
        'status',
        'pegawai_id',
    ];
    
   
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }

    public static function get_all_data()
    {
        return self::with([
            'pegawai',
            'pegawai.jabatan',
        ]);
    }
}
