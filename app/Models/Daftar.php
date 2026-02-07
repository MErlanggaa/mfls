<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daftar extends Model
{
    use HasFactory;

    protected $table = 'daftar';

    protected $fillable = [
        'peserta_id',
        'no_wa',
        'jenis_kelamin',
        'tahun_lulus',
        'ttl',
        'provinsi',
        'kabupaten',
        'asal_sekolah',
        'no_sekolah',
        'kode_referral',
        'status',
        'rata_rata_nilai',
        'avg_semester_1',
        'avg_semester_2',
        'avg_semester_3',
        'avg_semester_4',
        'avg_semester_5',
        'avg_semester_6',
        'nominal_beasiswa',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
