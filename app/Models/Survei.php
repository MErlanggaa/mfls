<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;

    protected $table = 'survei';

    protected $fillable = [
        'akun_id',
        'info_sumber',
        'motivasi',
        'bersedia_informasi_lain',
        'daftar_beasiswa_lain',
        'daftar_univ_lain',
        'mengikuti_osis',
        'mengikuti_forum_osis',
        'anggota_forum_anak',
        'sudah_diterima_kampus_lain',
        'sudah_daftar_diterima_mncuniversity',
    ];

    protected $casts = [
        'bersedia_informasi_lain' => 'boolean',
        'daftar_beasiswa_lain' => 'boolean',
        'daftar_univ_lain' => 'boolean',
        'mengikuti_osis' => 'boolean',
        'mengikuti_forum_osis' => 'boolean',
        'anggota_forum_anak' => 'boolean',
        'sudah_diterima_kampus_lain' => 'boolean',
        'sudah_daftar_diterima_mncuniversity' => 'boolean',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
