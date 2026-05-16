<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUjian extends Model
{
    use HasFactory;

    protected $table = 'jawaban_ujian';

    protected $fillable = [
        'ujian_id',
        'peserta_id',
        'jawaban',
        'nilai',
        'kesimpulan_ai',
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
