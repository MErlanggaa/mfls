<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
    use HasFactory;

    protected $table = 'riwayat_aktivitas';

    protected $fillable = [
        'pelaku_id',
        'aksi',
        'target_tipe',
        'target_id',
        'deskripsi',
    ];

    public function pelaku()
    {
        return $this->belongsTo(Akun::class, 'pelaku_id');
    }
}
