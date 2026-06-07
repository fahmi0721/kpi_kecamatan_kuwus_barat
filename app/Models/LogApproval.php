<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogApproval extends Model
{
    use HasFactory;
    protected $table = 'log_approval';
    protected $fillable = [
        'tugas_id',
        'notes',
        'pegawai_id'
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
