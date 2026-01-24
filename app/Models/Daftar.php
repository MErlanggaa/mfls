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
        'nominal_beasiswa',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
