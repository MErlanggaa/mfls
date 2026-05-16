<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Ujian;

class PemetaanDiriSoalSeeder extends Seeder
{
    public function run()
    {
        $ujian = Ujian::where('nama', 'Pemetaan Diri')->first();
        if (!$ujian) return;

        $dimensions = [
            'A. Self Awareness' => [
                'Saya memahami kelebihan utama dalam diri saya.',
                'Saya menyadari kelemahan yang perlu diperbaiki.',
                'Saya mampu merefleksikan tindakan yang telah saya lakukan.',
                'Saya mengenali emosi yang saya rasakan saat ini.',
                'Saya tahu apa yang memotivasi saya untuk maju.',
                'Saya memahami nilai-nilai yang menjadi prinsip hidup saya.'
            ],
            'B. Self Confidence' => [
                'Saya yakin dengan kemampuan yang saya miliki.',
                'Saya berani mengambil keputusan penting.',
                'Saya tidak takut gagal saat mencoba hal baru.',
                'Saya mampu berbicara di depan umum.',
                'Saya percaya diri dalam lingkungan baru.',
                'Saya tidak mudah terpengaruh penilaian negatif.'
            ],
            'C. Social Skill' => [
                'Saya mudah menjalin hubungan dengan orang lain.',
                'Saya mampu bekerja sama dalam tim.',
                'Saya mendengarkan orang lain dengan baik.',
                'Saya menghargai perbedaan pendapat.',
                'Saya mampu menyelesaikan konflik dengan baik.',
                'Saya mampu berkomunikasi secara efektif.'
            ],
            'D. Self Management' => [
                'Saya mampu mengatur waktu dengan baik.',
                'Saya memiliki perencanaan dalam hidup.',
                'Saya disiplin dalam menjalankan tugas.',
                'Saya mampu mengontrol emosi saat tertekan.',
                'Saya tetap fokus dalam mencapai tujuan.',
                'Saya bertanggung jawab atas keputusan saya.'
            ],
            'E. Growth Mindset' => [
                'Saya percaya bahwa kemampuan dapat dikembangkan.',
                'Saya terbuka terhadap kritik dan masukan.',
                'Saya belajar dari kesalahan yang saya alami.',
                'Saya terus mencari cara untuk berkembang.',
                'Saya menikmati proses belajar.',
                'Saya tidak mudah puas dengan pencapaian saat ini.'
            ]
        ];

        foreach ($dimensions as $kategori => $qs) {
            foreach ($qs as $q) {
                Soal::create([
                    'ujian_id' => $ujian->id,
                    'pertanyaan' => $q,
                    'kategori' => $kategori,
                    'opsi_a' => 'Sangat Tidak Sesuai',
                    'opsi_b' => 'Tidak Sesuai',
                    'opsi_c' => 'Netral',
                    'opsi_d' => 'Sesuai',
                    'opsi_e' => 'Sangat Sesuai',
                    'kunci_jawaban' => null,
                    'bobot' => 1
                ]);
            }
        }
    }
}
