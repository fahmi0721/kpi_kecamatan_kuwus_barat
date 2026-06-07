<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewLogApprovalTimeline extends Model
{
    use HasFactory;
    protected $table = 'v_log_approval_timeline';
    protected $primaryKey = 'log_id';
    public $timestamps = false;
    
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
