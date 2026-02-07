<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'akun_id',
        'nisn',
        'nama',
        'no_whatsapp',
        'tgl_lahir',
        'jenis_kelamin',
        'tahun_lulus',
        'provinsi',
        'kabupaten',
        'nama_sekolah',
        'telp_sekolah',
        'link_ig',
        'link_tiktok',
        'link_tiktok',
        'link_twibbon',
        'pilihan_prodi',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }

    public function daftar()
    {
        return $this->hasOne(Daftar::class, 'peserta_id');
    }

    public function berkas()
    {
        return $this->hasOne(Berkas::class, 'peserta_id');
    }

    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class, 'peserta_id');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'peserta_id');
    }

    public function jawabanUjians()
    {
        return $this->hasMany(JawabanUjian::class, 'peserta_id');
    }

    public function nilaiUjians()
    {
        return $this->hasMany(NilaiUjian::class, 'peserta_id');
    }

    public function penilaianMentors()
    {
        return $this->hasMany(PenilaianMentor::class, 'peserta_id');
    }

    public function penilaianAkademiks()
    {
        return $this->hasMany(PenilaianAkademik::class, 'peserta_id');
    }

    public function keputusan()
    {
        return $this->hasOne(Keputusan::class, 'peserta_id');
    }
}
