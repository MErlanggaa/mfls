<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujian';

    protected $fillable = [
        'nama',
        'durasi',
        'is_active',
    ];

    public function soals()
    {
        return $this->hasMany(Soal::class, 'ujian_id');
    }

    public function jawabanUjians()
    {
        return $this->hasMany(JawabanUjian::class, 'ujian_id');
    }
}
