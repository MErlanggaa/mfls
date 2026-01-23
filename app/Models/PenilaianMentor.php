<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianMentor extends Model
{
    use HasFactory;

    protected $table = 'penilaian_mentor';

    protected $fillable = [
        'peserta_id',
        'mentor_id',
        'nilai',
        'catatan',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function mentor()
    {
        return $this->belongsTo(Akun::class, 'mentor_id');
    }
}
