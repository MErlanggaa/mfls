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
        'wawancara_motivasi',
        'wawancara_prestasi',
        'wawancara_karakter',
        'wawancara_kontribusi',
        'wawancara_komunikasi',
        'wawancara_motivasi_q1',
        'wawancara_motivasi_q2',
        'wawancara_motivasi_q3',
        'wawancara_motivasi_q4',
        'wawancara_prestasi_q1',
        'wawancara_prestasi_q2',
        'wawancara_prestasi_q3',
        'wawancara_prestasi_q4',
        'wawancara_karakter_q1',
        'wawancara_karakter_q2',
        'wawancara_karakter_q3',
        'wawancara_karakter_q4',
        'wawancara_kontribusi_q1',
        'wawancara_kontribusi_q2',
        'wawancara_kontribusi_q3',
        'wawancara_kontribusi_q4',
        'wawancara_komunikasi_q1',
        'wawancara_komunikasi_q2',
        'wawancara_komunikasi_q3',
        'wawancara_komunikasi_q4',
        'wawancara_motivasi_catatan',
        'wawancara_prestasi_catatan',
        'wawancara_karakter_catatan',
        'wawancara_kontribusi_catatan',
        'wawancara_komunikasi_catatan',
        'rekomendasi_akhir',
        'rekomendasi_beasiswa',
        'catatan_rekomendasi_beasiswa',
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
