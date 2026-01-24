<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiUjian extends Model
{
    use HasFactory;

    protected $table = 'nilai_ujian';

    protected $fillable = [
        'ujian_id',
        'peserta_id',
        'skor_asli',
        'skor_rata',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
