<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispensasiUjian extends Model
{
    use HasFactory;

    protected $table = 'dispensasi_ujians';

    protected $fillable = [
        'ujian_id',
        'peserta_id',
        'tambahan_menit',
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
