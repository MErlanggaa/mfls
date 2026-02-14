<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $table = 'berkas';

    protected $fillable = [
        'peserta_id',
        'foto',
        'rapor1',
        'rapor2',
        'rapor3',
        'rapor4',
        'rapor5',
        'rapor6',
        'ijazah',
        'surat_rekom',
        'personal_statement',
        'motivasi_video',
        'surat_buta_warna',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
