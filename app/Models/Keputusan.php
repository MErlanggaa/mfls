<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keputusan extends Model
{
    use HasFactory;

    protected $table = 'keputusan';

    protected $fillable = [
        'peserta_id',
        'akademik_id',
        'status',
        'persentase_beasiswa',
        'undangan_kampus',
        'status_pengumuman',
        'catatan',
    ];

    protected $casts = [
        'undangan_kampus' => 'boolean',
        'status_pengumuman' => 'boolean',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function akademik()
    {
        return $this->belongsTo(Akun::class, 'akademik_id');
    }
}
