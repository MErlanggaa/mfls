<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MatchingController extends Controller
{
    private $questions = [
        ['question' => 'Kamu lebih tertarik pada:', 'options' => ['Manajemen' => 'Bisnis', 'Akuntansi' => 'Angka', 'Sains Komunikasi' => 'Komunikasi', 'Pendidikan Matematika' => 'Logika', 'Pendidikan Bahasa Inggris' => 'Bahasa', 'Sistem Informasi' => 'Sistem', 'DKV' => 'Visual', 'Ilmu Komputer' => 'Teknologi']],
        ['question' => 'Aktivitas favorit kamu:', 'options' => ['Manajemen' => 'Mengatur', 'Akuntansi' => 'Menghitung', 'Sains Komunikasi' => 'Berbicara', 'Pendidikan Matematika' => 'Menganalisis', 'Pendidikan Bahasa Inggris' => 'Membaca bahasa', 'Sistem Informasi' => 'Mengelola sistem', 'DKV' => 'Mendesain', 'Ilmu Komputer' => 'Membuat sesuatu']],
        ['question' => 'Kamu lebih suka:', 'options' => ['Manajemen' => 'Memimpin', 'Akuntansi' => 'Mengolah data', 'Sains Komunikasi' => 'Interaksi sosial', 'Pendidikan Matematika' => 'Berpikir logis', 'Pendidikan Bahasa Inggris' => 'Bahasa', 'Sistem Informasi' => 'Sistem kerja', 'DKV' => 'Kreativitas', 'Ilmu Komputer' => 'Teknologi']],
        ['question' => 'Kamu nyaman dengan:', 'options' => ['Manajemen' => 'Target', 'Akuntansi' => 'Detail', 'Sains Komunikasi' => 'Orang', 'Pendidikan Matematika' => 'Rumus', 'Pendidikan Bahasa Inggris' => 'Kata-kata', 'Sistem Informasi' => 'Alur sistem', 'DKV' => 'Visual', 'Ilmu Komputer' => 'Coding']],
        ['question' => 'Hal yang paling menarik buat kamu:', 'options' => ['Manajemen' => 'Strategi', 'Akuntansi' => 'Angka', 'Sains Komunikasi' => 'Komunikasi', 'Pendidikan Matematika' => 'Perhitungan', 'Pendidikan Bahasa Inggris' => 'Bahasa', 'Sistem Informasi' => 'Teknologi', 'DKV' => 'Desain', 'Ilmu Komputer' => 'Inovasi']],
        ['question' => 'Kamu lebih suka kerja:', 'options' => ['Manajemen' => 'Memimpin tim', 'Akuntansi' => 'Dengan data', 'Sains Komunikasi' => 'Bersama banyak orang', 'Pendidikan Matematika' => 'Sendiri dengan logika', 'Pendidikan Bahasa Inggris' => 'Dengan bahasa', 'Sistem Informasi' => 'Dengan sistem', 'DKV' => 'Secara kreatif', 'Ilmu Komputer' => 'Secara teknis']],
        ['question' => 'Kamu tipe yang:', 'options' => ['Manajemen' => 'Terorganisir', 'Akuntansi' => 'Teliti', 'Sains Komunikasi' => 'Ekspresif', 'Pendidikan Matematika' => 'Analitis', 'Pendidikan Bahasa Inggris' => 'Adaptif bahasa', 'Sistem Informasi' => 'Sistematis', 'DKV' => 'Imajinatif', 'Ilmu Komputer' => 'Problem solver']],
        ['question' => 'Saat ada masalah kamu:', 'options' => ['Manajemen' => 'Cari strategi', 'Akuntansi' => 'Hitung', 'Sains Komunikasi' => 'Diskusi', 'Pendidikan Matematika' => 'Analisis', 'Pendidikan Bahasa Inggris' => 'Komunikasikan', 'Sistem Informasi' => 'Buat sistem', 'DKV' => 'Cari ide', 'Ilmu Komputer' => 'Coding solusi']],
        ['question' => 'Kamu lebih suka tugas yang:', 'options' => ['Manajemen' => 'Terarah', 'Akuntansi' => 'Detail', 'Sains Komunikasi' => 'Interaktif', 'Pendidikan Matematika' => 'Logis', 'Pendidikan Bahasa Inggris' => 'Bahasa', 'Sistem Informasi' => 'Sistematis', 'DKV' => 'Kreatif', 'Ilmu Komputer' => 'Teknis']],
        ['question' => 'Kamu lebih nyaman:', 'options' => ['Manajemen' => 'Mengatur', 'Akuntansi' => 'Menghitung', 'Sains Komunikasi' => 'Berbicara', 'Pendidikan Matematika' => 'Berpikir', 'Pendidikan Bahasa Inggris' => 'Berbahasa', 'Sistem Informasi' => 'Mengelola', 'DKV' => 'Mendesain', 'Ilmu Komputer' => 'Membangun']],
        ['question' => 'Kamu lebih tertarik pada (Peminatan Dasar):', 'options' => ['Manajemen' => 'Bisnis', 'Akuntansi' => 'Keuangan', 'Sains Komunikasi' => 'Media', 'Pendidikan Matematika' => 'Matematika', 'Pendidikan Bahasa Inggris' => 'Bahasa asing', 'Sistem Informasi' => 'IT', 'DKV' => 'Seni', 'Ilmu Komputer' => 'Software']],
        ['question' => 'Kamu suka hal yang:', 'options' => ['Manajemen' => 'Menghasilkan', 'Akuntansi' => 'Akurat', 'Sains Komunikasi' => 'Interaktif', 'Pendidikan Matematika' => 'Logis', 'Pendidikan Bahasa Inggris' => 'Global', 'Sistem Informasi' => 'Terstruktur', 'DKV' => 'Menarik', 'Ilmu Komputer' => 'Berfungsi']],
        ['question' => 'Kamu lebih suka belajar:', 'options' => ['Manajemen' => 'Strategi', 'Akuntansi' => 'Angka', 'Sains Komunikasi' => 'Komunikasi', 'Pendidikan Matematika' => 'Rumus', 'Pendidikan Bahasa Inggris' => 'Bahasa', 'Sistem Informasi' => 'Sistem', 'DKV' => 'Visual', 'Ilmu Komputer' => 'Teknologi']],
        ['question' => 'Kamu lebih tertarik pada:', 'options' => ['Manajemen' => 'Organisasi', 'Akuntansi' => 'Data', 'Sains Komunikasi' => 'Publik', 'Pendidikan Matematika' => 'Logika', 'Pendidikan Bahasa Inggris' => 'Bahasa', 'Sistem Informasi' => 'Sistem', 'DKV' => 'Desain', 'Ilmu Komputer' => 'Coding']],
        ['question' => 'Kamu menikmati:', 'options' => ['Manajemen' => 'Mengatur', 'Akuntansi' => 'Menghitung', 'Sains Komunikasi' => 'Berinteraksi', 'Pendidikan Matematika' => 'Menganalisis', 'Pendidikan Bahasa Inggris' => 'Mempelajari bahasa', 'Sistem Informasi' => 'Mengelola sistem', 'DKV' => 'Mendesain', 'Ilmu Komputer' => 'Membuat program']],
        ['question' => 'Kamu orang yang:', 'options' => ['Manajemen' => 'Leadership', 'Akuntansi' => 'Detail', 'Sains Komunikasi' => 'Sosial', 'Pendidikan Matematika' => 'Logis', 'Pendidikan Bahasa Inggris' => 'Linguistik', 'Sistem Informasi' => 'Sistematis', 'DKV' => 'Kreatif', 'Ilmu Komputer' => 'Teknis']],
        ['question' => 'Kamu lebih suka:', 'options' => ['Manajemen' => 'Mengambil keputusan', 'Akuntansi' => 'Memastikan akurasi', 'Sains Komunikasi' => 'Berbicara', 'Pendidikan Matematika' => 'Berpikir', 'Pendidikan Bahasa Inggris' => 'Berbahasa', 'Sistem Informasi' => 'Mengatur sistem', 'DKV' => 'Berkarya', 'Ilmu Komputer' => 'Membangun teknologi']],
        ['question' => 'Kamu lebih tertarik:', 'options' => ['Manajemen' => 'Target', 'Akuntansi' => 'Data', 'Sains Komunikasi' => 'Interaksi', 'Pendidikan Matematika' => 'Analisis', 'Pendidikan Bahasa Inggris' => 'Bahasa', 'Sistem Informasi' => 'Sistem', 'DKV' => 'Visual', 'Ilmu Komputer' => 'Teknologi']],
        ['question' => 'Kamu lebih suka hasil kerja yang:', 'options' => ['Manajemen' => 'Efektif', 'Akuntansi' => 'Tepat', 'Sains Komunikasi' => 'Berdampak', 'Pendidikan Matematika' => 'Logis', 'Pendidikan Bahasa Inggris' => 'Dipahami', 'Sistem Informasi' => 'Berjalan', 'DKV' => 'Menarik', 'Ilmu Komputer' => 'Berfungsi']],
        ['question' => 'Kamu cenderung:', 'options' => ['Manajemen' => 'Mengatur', 'Akuntansi' => 'Menghitung', 'Sains Komunikasi' => 'Berkomunikasi', 'Pendidikan Matematika' => 'Menganalisis', 'Pendidikan Bahasa Inggris' => 'Belajar bahasa', 'Sistem Informasi' => 'Mengelola', 'DKV' => 'Mendesain', 'Ilmu Komputer' => 'Coding']],
        ['question' => 'Waktu luang kamu biasanya diisi dengan:', 'options' => ['Manajemen' => 'Belajar bisnis', 'Akuntansi' => 'Menghitung / game angka', 'Sains Komunikasi' => 'Sosial media / ngobrol', 'Pendidikan Matematika' => 'Puzzle / logika', 'Pendidikan Bahasa Inggris' => 'Nonton film bahasa Inggris', 'Sistem Informasi' => 'Eksplor sistem terbaru', 'DKV' => 'Mendesain', 'Ilmu Komputer' => 'Coding']],
        ['question' => 'Kamu lebih gampang memahami:', 'options' => ['Manajemen' => 'Strategi', 'Akuntansi' => 'Perhitungan', 'Sains Komunikasi' => 'Komunikasi', 'Pendidikan Matematika' => 'Logika', 'Pendidikan Bahasa Inggris' => 'Bahasa asing', 'Sistem Informasi' => 'Sistem', 'DKV' => 'Visual', 'Ilmu Komputer' => 'Teknologi']],
        ['question' => 'Kamu paling menonjol pada mata pelajaran/bidang:', 'options' => ['Manajemen' => 'Bisnis/Ekonomi', 'Akuntansi' => 'Akuntansi', 'Sains Komunikasi' => 'Media Sosial', 'Pendidikan Matematika' => 'Matematika', 'Pendidikan Bahasa Inggris' => 'Bahasa Inggris', 'Sistem Informasi' => 'Sistem informasi', 'DKV' => 'Desain/Seni Rupa', 'Ilmu Komputer' => 'Ilmu Komputer']],
        ['question' => 'Peran yang paling kamu nikmati di kelompok:', 'options' => ['Manajemen' => 'Memimpin', 'Akuntansi' => 'Menghitung anggaran', 'Sains Komunikasi' => 'Berbicara / presentasi', 'Pendidikan Matematika' => 'Menganalisis data', 'Pendidikan Bahasa Inggris' => 'Berbahasa asing', 'Sistem Informasi' => 'Mengatur alur kerja sistem', 'DKV' => 'Mendesain layout', 'Ilmu Komputer' => 'Programming / Teknis IT']],
        ['question' => 'Fokus utama pikiranmu biasanya pada:', 'options' => ['Manajemen' => 'Target bisnis', 'Akuntansi' => 'Keakuratan angka', 'Sains Komunikasi' => 'Interaksi audiens', 'Pendidikan Matematika' => 'Kebenaran logika', 'Pendidikan Bahasa Inggris' => 'Pemahaman budaya/bahasa', 'Sistem Informasi' => 'Struktur sistem', 'DKV' => 'Estetika & kreativitas', 'Ilmu Komputer' => 'Kemajuan teknologi']],
        ['question' => 'Kamu tertarik bekerja di bidang:', 'options' => ['Manajemen' => 'Perusahaan Korporat', 'Akuntansi' => 'Lembaga Keuangan', 'Sains Komunikasi' => 'Agensi Media', 'Pendidikan Matematika' => 'Institusi Pendidikan/Riset', 'Pendidikan Bahasa Inggris' => 'Pendidik / Penerjemah', 'Sistem Informasi' => 'Perusahaan IT Consultan', 'DKV' => 'Studio Kreatif', 'Ilmu Komputer' => 'Tech Startup']],
        ['question' => 'Kamu paling nyaman bekerja dengan menggunakan:', 'options' => ['Manajemen' => 'Strategi', 'Akuntansi' => 'Data Keuangan', 'Sains Komunikasi' => 'Kerumunan Orang', 'Pendidikan Matematika' => 'Logika Terapan', 'Pendidikan Bahasa Inggris' => 'Literatur Bahasa', 'Sistem Informasi' => 'Data Sistem', 'DKV' => 'Visual Art', 'Ilmu Komputer' => 'Software & Coding']],
        ['question' => 'Output yang paling membuatmu puas:', 'options' => ['Manajemen' => 'Kinerja terarah', 'Akuntansi' => 'Laporan terukur', 'Sains Komunikasi' => 'Audiens interaktif', 'Pendidikan Matematika' => 'Jawaban rasional', 'Pendidikan Bahasa Inggris' => 'Terhubung secara global', 'Sistem Informasi' => 'Alur terstruktur', 'DKV' => 'Tampilan estetis', 'Ilmu Komputer' => 'Aplikasi fungsional']],
        ['question' => 'Kamu selalu ingin lebih ahli dalam aspek:', 'options' => ['Manajemen' => 'Leadership', 'Akuntansi' => 'Ketelitian Angka', 'Sains Komunikasi' => 'Seni Komunikasi', 'Pendidikan Matematika' => 'Analisis Kompleks', 'Pendidikan Bahasa Inggris' => 'Penguasaan Bahasa', 'Sistem Informasi' => 'Manajemen Sistem', 'DKV' => 'Desain Modern', 'Ilmu Komputer' => 'Deep Teknologi']],
        ['question' => 'Kamu paling berhasrat dan ingin berkembang di program:', 'options' => ['Manajemen' => 'Manajemen Perusahaan', 'Akuntansi' => 'Keuangan/Akuntansi', 'Sains Komunikasi' => 'Ilmu Komunikasi', 'Pendidikan Matematika' => 'Matematika Terapan', 'Pendidikan Bahasa Inggris' => 'Sastra/Bahasa Inggris', 'Sistem Informasi' => 'Sistem Informasi Modern', 'DKV' => 'Desain Komunikasi Visual', 'Ilmu Komputer' => 'Ilmu Komputer Terapan']],
    ];

    public function showQuiz()
    {
        return view('pendaftar.quiz', ['questions' => $this->questions]);
    }

    public function submit(Request $request)
    {
        $answers = $request->answers;
        if (!$answers || !is_array($answers) || count($answers) < count($this->questions)) {
            return back()->with('error', 'Mohon jawab semua ' . count($this->questions) . ' pertanyaan.');
        }

        // 1. INIT SCORE
        $score = [
            "Ilmu Komputer" => 0,
            "Sains Komunikasi" => 0,
            "Sistem Informasi" => 0,
            "Pendidikan Matematika" => 0,
            "Pendidikan Bahasa Inggris" => 0,
            "Manajemen" => 0,
            "DKV" => 0,
            "Akuntansi" => 0,
        ];

        // 2. HITUNG
        foreach ($answers as $answer) {
            if (isset($score[$answer])) {
                $score[$answer]++;
            }
        }

        // 3. SORT
        arsort($score);
        $keys = array_keys($score);

        $top1 = $keys[0];
        $top2 = $keys[1];

        // 4. HITUNG PERSEN (Skala Rekomendasi 30 Pertanyaan)
        // Jika 30 pertanyaan berarti user yg stabil akan mendapat poin sekitar 15-30 di prodi utama.
        $score1 = $score[$top1];
        $score2 = $score[$top2];

        // Base matching rate 65%. Setiap poin menambah 1.5%. Max 98%.
        // Jika pilih DKV 20 kali = 65 + 30 = 95%.
        $percent1 = min(98, round(65 + ($score1 * 1.5)));
        
        // Base matching rate 55%. Setiap poin menambah 1.5%. Max 89%.
        $percent2 = min(89, round(55 + ($score2 * 1.5)));

        // 5. GEMINI
        $ai = $this->gemini($top1, $top2, $percent1, $percent2);

        return view('pendaftar.quiz_result', compact(
            'top1',
            'top2',
            'percent1',
            'percent2',
            'ai'
        ));
    }

    private function gemini($top1, $top2, $percent1, $percent2)
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return "Sistem kami mendeteksi Anda cocok di prodi $top1 dan $top2. Namun fungsi AI Analisis dari Arion sedang tidak tersedia karena API Key belum diatur.";
        }

        $prompt = "
        Tugasmu adalah bertindak sebagai 'Arion', maskot AI yang cerdas, ramah, dan memotivasi dari MNC University.
        Hasil kuis minat bakat calon mahasiswa:
        1. $top1 ($percent1%)
        2. $top2 ($percent2%)

        Tolong jelaskan secara singkat:
        - Gunakan sudut pandang Arion, nyapa dengan gaya bahasa santai, memotivasi, dan khas anak muda Indonesia.
        - Maksimal 120 kata.
        - Sebutkan kenapa jurusan tersebut cocok dengan kepribadiannya berdasarkan hasil tesnya.
        - Berikan saran karir singkat.
        - Gunakan paragraf yang enak dibaca.
        ";

        try {
            $res = Http::timeout(10)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=$apiKey",
                [
                    "contents" => [
                        [
                            "parts" => [
                                ["text" => $prompt]
                            ]
                        ]
                    ]
                ]
            );

            if ($res->successful()) {
                return $res['candidates'][0]['content']['parts'][0]['text'] ?? "Halo dari Arion! Berdasarkan hasilmu, kamu memiliki kecocokan yang kuat pada prodi **$top1** dan **$top2**.";
            }

            // Jika API error
            // \Log::error('Gemini API Error: ' . $res->body());
            return "Halo Future Leader! Aku Arion. Berdasarkan hasil tes minatmu, kamu sangat cocok berada di prodi **$top1** ($percent1%) atau **$top2** ($percent2%). Persiapkan dirimu untuk karir yang cemerlang di bidang ini!";

        } catch (\Exception $e) {
            return "Halo calon jenius! Aku Arion, maskot MNC University. Berdasarkan tes, kamu cocok banget di prodi **$top1** atau alternatifnya **$top2**. Sukses selalu!";
        }
    }
}