<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';

    protected $fillable = [
        'ujian_id',
        'pertanyaan',
        'gambar',
        'opsi_a',
        'opsi_a_image',
        'opsi_b',
        'opsi_b_image',
        'opsi_c',
        'opsi_c_image',
        'opsi_d',
        'opsi_d_image',
        'opsi_e',
        'opsi_e_image',
        'kategori',
        'kunci_jawaban',
        'bobot',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }
}
