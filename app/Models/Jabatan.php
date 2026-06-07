<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'm_jabatan';
    protected $fillable = [
        'nama',
        'deskripsi',
        'parent_id',
    ];    
    public function atasan()
    {
        return $this->belongsTo(Jabatan::class, 'parent_id', 'id');
    }

    public function bawahan()
    {
        return $this->hasMany(Jabatan::class, 'parent_id', 'id');
    }

    public static function get_all_data()
    {
        return self::with([
            'atasan',
            'bawahan',
        ]);
    }
}
