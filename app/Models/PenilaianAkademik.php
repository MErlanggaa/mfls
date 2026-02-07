<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAkademik extends Model
{
    use HasFactory;

    protected $table = 'penilaian_akademiks';

    protected $fillable = [
        'peserta_id',
        'penilai_id',
        'dosen_kompetensi',
        'dosen_motivasi',
        'dosen_wawasan',
        'dosen_karir',
        'dosen_integritas',
        'total_dosen',
        'mhs_leadership',
        'mhs_organisasi',
        'mhs_etika',
        'mhs_adaptasi',
        'mhs_komitmen',
        'total_mhs',
        'total_akhir',
        'catatan',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function penilai()
    {
        return $this->belongsTo(Akun::class, 'penilai_id');
    }
}
