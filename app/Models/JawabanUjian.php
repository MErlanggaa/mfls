<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUjian extends Model
{
    use HasFactory;

    protected $table = 'jawaban_ujian';

    protected $fillable = [
        'ujian_id',
        'peserta_id',
        'jawaban',
        'nilai',
        'kesimpulan_ai',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    /**
     * Generate the narrative analysis locally in PHP, saving API quota/limits while maintaining high professional quality.
     */
    public static function generateLocalNarrative(array $pct, string $profilUtama, string $prodiRekomendasi)
    {
        // Temukan key dengan persentase tertinggi dan terendah
        arsort($pct);
        $highestKey = key($pct);
        $lowestKey = array_key_last($pct);

        $dimensionNames = [
            'SA' => 'Self Awareness (Kesadaran Diri)',
            'SC' => 'Self Confidence (Kepercayaan Diri)',
            'SS' => 'Social Skill (Kemampuan Sosial)',
            'SM' => 'Self Management (Manajemen Diri)',
            'GM' => 'Growth Mindset (Pola Pikir Berkembang)',
            'LP' => 'Leadership Potential (Potensi Kepemimpinan)',
        ];

        $highestName = $dimensionNames[$highestKey];
        $lowestName = $dimensionNames[$lowestKey];

        // 1. Profil The Strategic Leader
        if ($pct['LP'] >= 80 && $pct['SS'] >= 70) {
            $p1 = "Peserta menunjukkan profil kepemimpinan strategis yang sangat matang. Memiliki kemampuan alami untuk memimpin kelompok, mengambil inisiatif taktis di bawah tekanan, dan mengarahkan tim menuju target bersama. Karakter komunikatif dan karismatiknya membuatnya sangat dihormati oleh rekan sejawatnya.";
            $p2 = "Kekuatan utama peserta terletak pada potensi kepemimpinan (Leadership Potential) dan kecerdasan sosial (Social Skill) yang tinggi. Hal ini menjadikannya kandidat yang sangat ideal untuk program studi **$prodiRekomendasi** di MNC University, di mana ia dapat mengasah kemampuan tata kelola organisasi, negosiasi, dan komunikasi publik secara profesional.";
            $p3 = "Untuk pengembangan ke depan, peserta disarankan tetap menjaga keseimbangan emosi dan melatih kesabaran dalam mendengarkan masukan dari anggota tim (terutama pada aspek $lowestName). Sebagai Future Leader, konsistensi dalam memimpin dengan integritas akan menjadi kunci kesuksesan terbesarnya di masa depan.";
        }
        // 2. Profil The Analytical Innovator
        elseif ($pct['GM'] >= 80 && $pct['SM'] >= 70) {
            $p1 = "Peserta menunjukkan profil inovator analitis yang luar biasa. Memiliki tingkat kedisiplinan yang tinggi dalam mengelola tugas, perencanaan hidup yang matang, serta keterbukaan yang sangat besar terhadap pembelajaran dan pengetahuan baru. Kesalahan dianggap sebagai proses belajar yang bernilai tinggi.";
            $p2 = "Kekuatan terbesarnya pada aspek Growth Mindset dan Self Management menjadikannya sangat cocok untuk masuk ke program studi berorientasi teknologi atau analisis seperti **$prodiRekomendasi** di MNC University. Ia mampu memecahkan masalah kompleks secara sistematis dan adaptif terhadap teknologi baru.";
            $p3 = "Disarankan untuk lebih percaya diri dalam membagikan gagasan inovatifnya di depan umum (terutama pada aspek $lowestName). Sebagai Future Leader, kemampuan teknis yang dipadukan dengan keterampilan kolaborasi akan menjadikannya motor penggerak inovasi yang hebat.";
        }
        // 3. Profil The Collaborative Diplomat
        elseif ($pct['SS'] >= 80 && $pct['SC'] >= 70) {
            $p1 = "Peserta memiliki profil diplomat kolaboratif dengan keterampilan interpersonal yang luar biasa. Sangat pandai menjalin hubungan baru, aktif mendengarkan, serta percaya diri dalam berbicara di depan umum dan menyelesaikan konflik secara damai.";
            $p2 = "Kemampuan sosial (Social Skill) dan rasa percaya diri (Self Confidence) yang matang ini sangat selaras dengan program studi **$prodiRekomendasi** di MNC University. Peserta akan sangat bersinar dalam peran yang menuntut negosiasi, komunikasi publik, dan manajemen relasi.";
            $p3 = "Sebagai saran, peserta perlu memperkuat sisi manajemen waktu dan perencanaan tugas agar tetap fokus pada penyelesaian detail teknis (terutama pada aspek $lowestName). Sebagai Future Leader, kehangatan sosialnya adalah modal utama dalam membangun jaringan kolaboratif yang solid.";
        }
        // 4. Profil The Precision Strategist
        elseif ($pct['SM'] >= 80 && $pct['SA'] >= 70) {
            $p1 = "Peserta menunjukkan profil ahli strategi yang presisi. Sangat teratur, disiplin, bertanggung jawab penuh atas segala tindakan, memiliki kontrol emosi yang luar biasa saat berada di bawah tekanan berat, serta memiliki tingkat mawas diri yang sangat baik.";
            $p2 = "Kombinasi mawas diri (Self Awareness) dan manajemen diri (Self Management) yang tinggi membuat peserta sangat kompeten untuk mengambil peran penting di program studi **$prodiRekomendasi** di MNC University. Ia sangat unggul dalam merencanakan alur kerja dan mengeksekusinya tanpa celah.";
            $p3 = "Peserta disarankan untuk lebih terbuka terhadap kritik eksternal dan berani mencoba hal baru di luar zona nyaman (terutama pada aspek $lowestName). Sebagai Future Leader, ketelitian dan ketangguhan mentalnya adalah fondasi kokoh untuk kepemimpinan profesional.";
        }
        // 5. Fallbacks berdasarkan skor tertinggi
        else {
            switch ($highestKey) {
                case 'SA':
                    $p1 = "Peserta memiliki profil reflektif yang sangat sadar akan kelebihan dan kelemahannya. Mampu merefleksikan pengalaman hidup dengan bijaksana serta sangat memahami nilai-nilai prinsip hidup yang dianutnya.";
                    $p2 = "Kesadaran diri (Self Awareness) yang tinggi ini sangat cocok untuk bidang studi **$prodiRekomendasi** di MNC University, membantu dalam memahami dinamika psikologi manusia dan hubungan antar-organisasi secara mendalam.";
                    $p3 = "Disarankan untuk melatih keberanian dalam mengekspresikan pemikiran secara langsung di depan umum (terutama pada aspek $lowestName). Sebagai Future Leader, pemahaman diri yang kokoh adalah awal dari pengaruh kepemimpinan yang tulus.";
                    break;
                case 'SC':
                    $p1 = "Peserta menunjukkan profil yang mandiri, berani mengambil risiko besar, tidak takut gagal saat mencoba hal baru, serta memiliki rasa percaya diri yang tinggi dalam beradaptasi di lingkungan baru.";
                    $p2 = "Rasa percaya diri (Self Confidence) yang kuat ini sangat mendukung karir sebagai wirausahawan atau eksekutif tangguh di bidang **$prodiRekomendasi** di MNC University.";
                    $p3 = "Disarankan untuk memperkuat kerja sama tim dan keterbukaan dalam menerima masukan eksternal (terutama pada aspek $lowestName). Sebagai Future Leader, keberanian adalah kekuatan besar jika diimbangi dengan kebijaksanaan kolaborasi.";
                    break;
                case 'SS':
                    $p1 = "Peserta sangat pandai bersosialisasi, menghargai perbedaan pendapat dengan bijak, pendengar yang baik, serta sangat mudah bekerja sama dalam tim untuk mencapai target bersama.";
                    $p2 = "Kecerdasan sosial (Social Skill) yang menonjol ini sangat cocok untuk program studi **$prodiRekomendasi** di MNC University, mendukung kemampuan berjejaring, komunikasi publik, dan kolaborasi strategis.";
                    $p3 = "Disarankan melatih kemandirian dalam mengambil keputusan penting tanpa terlalu bergantung pada persetujuan orang lain (terutama pada aspek $lowestName). Sebagai Future Leader, kecintaan pada komunitas adalah aset kepemimpinan yang berharga.";
                    break;
                case 'SM':
                    $p1 = "Peserta adalah pribadi yang sangat disiplin, andal dalam manajemen waktu, terencana, memiliki kontrol emosi yang stabil, serta bertanggung jawab penuh terhadap tugasnya.";
                    $p2 = "Manajemen diri (Self Management) yang luar biasa ini membuatnya sangat kompeten di bidang operasional, analisis data, atau manajemen proyek seperti di program studi **$prodiRekomendasi** di MNC University.";
                    $p3 = "Disarankan untuk lebih fleksibel dan terbuka terhadap perubahan situasi secara dinamis di luar perencanaan (terutama pada aspek $lowestName). Sebagai Future Leader, konsistensi kerja peserta adalah teladan nyata bagi rekan sebayanya.";
                    break;
                case 'GM':
                    $p1 = "Peserta memiliki pola pikir berkembang (growth mindset) yang sangat kuat. Sangat terbuka terhadap kritik dan masukan, menikmati proses belajar hal-hal baru, dan menganggap kesalahan sebagai batu loncatan.";
                    $p2 = "Pola pikir adaptif (Growth Mindset) yang menonjol ini membuatnya sangat siap menghadapi dinamika industri modern, khususnya di bidang **$prodiRekomendasi** di MNC University.";
                    $p3 = "Disarankan untuk lebih melatih teknik manajemen waktu agar fokus pada target jangka pendek (terutama pada aspek $lowestName). Sebagai Future Leader, antusiasme belajarnya akan terus mendorong kemajuan dan inovasi berkelanjutan.";
                    break;
                case 'LP':
                default:
                    $p1 = "Peserta memiliki bakat kepemimpinan alami yang sangat baik, berani mengambil inisiatif dalam situasi krusial, dan siap memikul tanggung jawab sebagai role model bagi lingkungannya.";
                    $p2 = "Potensi kepemimpinan (Leadership Potential) yang matang ini sangat cocok untuk mengarahkan karir di bidang manajemen tim dan kepemimpinan korporat, selaras dengan program studi **$prodiRekomendasi** di MNC University.";
                    $p3 = "Disarankan tetap melatih empati, mawas diri, dan keseimbangan emosi (terutama pada aspek $lowestName). Sebagai Future Leader, integritas dan kepeloporan peserta akan membawa dampak perubahan positif yang nyata.";
                    break;
            }
        }

        return $p1 . "\n\n" . $p2 . "\n\n" . $p3;
    }

    /**
     * Get the premium structured report, or generate it dynamically on-the-fly for existing/past candidates.
     */
    public function getOrGeneratePemetaanReport()
    {
        $kesimpulan = $this->kesimpulan_ai;
        
        // Jika sudah dalam format baru, langsung kembalikan
        if ($kesimpulan && str_contains($kesimpulan, '📊 **HASIL ANALISIS')) {
            return $kesimpulan;
        }

        // Jika belum ada jawaban, tidak bisa dihitung
        if (!$this->jawaban) {
            return $kesimpulan ?: "Belum ada jawaban dari peserta.";
        }

        $submittedAnswers = json_decode($this->jawaban, true);
        if (!$submittedAnswers || !is_array($submittedAnswers)) {
            return $kesimpulan ?: "Format jawaban tidak valid.";
        }

        // Ambil semua soal untuk ujian ini
        $soals = Soal::where('ujian_id', $this->ujian_id)->get();
        if ($soals->isEmpty()) {
            return $kesimpulan ?: "Soal ujian tidak ditemukan.";
        }

        $dimensionScores = [
            'SA' => 0,
            'SC' => 0,
            'SS' => 0,
            'SM' => 0,
            'GM' => 0,
            'LP' => 0,
        ];
        
        $valMap = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        
        foreach ($soals as $soal) {
            $userAns = strtolower($submittedAnswers[$soal->id] ?? '');
            $val = $valMap[$userAns] ?? 0;
            
            if ($val > 0) {
                $cat = strtolower($soal->kategori ?? '');
                if (str_contains($cat, 'awareness') || str_contains($cat, 'sa')) {
                    $dimensionScores['SA'] += $val;
                } elseif (str_contains($cat, 'confidence') || str_contains($cat, 'sc')) {
                    $dimensionScores['SC'] += $val;
                } elseif (str_contains($cat, 'social') || str_contains($cat, 'ss')) {
                    $dimensionScores['SS'] += $val;
                } elseif (str_contains($cat, 'management') || str_contains($cat, 'sm')) {
                    $dimensionScores['SM'] += $val;
                } elseif (str_contains($cat, 'growth') || str_contains($cat, 'gm')) {
                    $dimensionScores['GM'] += $val;
                } elseif (str_contains($cat, 'leadership') || str_contains($cat, 'lp')) {
                    $dimensionScores['LP'] += $val;
                }
            }
        }

        // Hitung persentase tiap dimensi & kategori
        $pct = [];
        $kategoriDimensi = [];
        
        $getCategory = function($percentage) {
            if ($percentage >= 85) {
                return ['Sangat Tinggi', 'Menunjukkan potensi yang sangat matang dan siap menjadi mentor/pemimpin.'];
            } elseif ($percentage >= 70) {
                return ['Tinggi', 'Memiliki kompetensi yang kuat di atas rata-rata.'];
            } elseif ($percentage >= 55) {
                return ['Sedang', 'Kompetensi berkembang namun memerlukan bimbingan berkala.'];
            } elseif ($percentage >= 40) {
                return ['Rendah', 'Membutuhkan pengembangan intensif pada aspek terkait.'];
            } else {
                return ['Sangat Rendah', 'Memerlukan pemetaan ulang dan pendampingan khusus.'];
            }
        };

        foreach ($dimensionScores as $key => $score) {
            $pct[$key] = round(($score / 30) * 100, 2);
            $kategoriDimensi[$key] = $getCategory($pct[$key])[0];
        }

        $totalSkor = array_sum($dimensionScores);
        $totalPercentage = round(($totalSkor / 180) * 100, 2);
        $finalCategoryInfo = $getCategory($totalPercentage);
        $finalKategori = $finalCategoryInfo[0];
        $finalDeskripsi = $finalCategoryInfo[1];

        // Tentukan profil kepribadian utama secara matematis
        $profilUtama = 'The Balanced Professional';
        $karakteristik = 'Memiliki keseimbangan yang baik di seluruh aspek kompetensi diri, adaptif, dan siap berkembang di berbagai bidang.';
        $prodiRekomendasi = 'Sains Komunikasi, Sistem Informasi, Manajemen';
        $karirRekomendasi = 'General Consultant, Project Coordinator, Entrepreneur';

        if ($pct['LP'] >= 80 && $pct['SS'] >= 70) {
            $profilUtama = 'The Strategic Leader / Visionary Pioneer';
            $karakteristik = 'Sangat kuat dalam memimpin tim, mengambil keputusan taktis di bawah tekanan, memiliki pengaruh positif yang besar, dan komunikatif.';
            $prodiRekomendasi = 'Manajemen, Sains Komunikasi';
            $karirRekomendasi = 'Corporate Executive, Business Development Manager, Public Policy Specialist, Politician';
        } elseif ($pct['GM'] >= 80 && $pct['SM'] >= 70) {
            $profilUtama = 'The Analytical Innovator / High Achiever';
            $karakteristik = 'Sangat adaptif terhadap pembelajaran baru, disiplin tinggi dalam eksekusi tugas, terencana, dan selalu mencari peningkatan kualitas.';
            $prodiRekomendasi = 'Sistem Informasi, Sains Komunikasi (Digital)';
            $karirRekomendasi = 'IT Analyst, Data Scientist, Researcher, Product Manager';
        } elseif ($pct['SS'] >= 80 && $pct['SC'] >= 70) {
            $profilUtama = 'The Collaborative Diplomat / PR Specialist';
            $karakteristik = 'Sangat terampil dalam membangun relasi interpersonal, percaya diri tinggi dalam bersosialisasi dan berbicara di depan umum, serta ulung menyelesaikan konflik.';
            $prodiRekomendasi = 'Sains Komunikasi';
            $karirRekomendasi = 'Public Relations Manager, Corporate Communications, HR Specialist, Diplomat';
        } elseif ($pct['SM'] >= 80 && $pct['SA'] >= 70) {
            $profilUtama = 'The Precision Strategist / Operations Director';
            $karakteristik = 'Sangat teratur, memiliki ketahanan emosi yang prima saat tertekan, bertanggung jawab penuh, dan sadar betul akan kelebihan serta kelemahan diri.';
            $prodiRekomendasi = 'Manajemen, Sistem Informasi';
            $karirRekomendasi = 'Operations Manager, Chief Financial Officer, Strategic Planner, Risk Analyst';
        } else {
            arsort($pct);
            $highestKey = key($pct);
            
            switch ($highestKey) {
                case 'SA':
                    $profilUtama = 'The Self-Reflective Explorer';
                    $karakteristik = 'Memiliki kesadaran diri yang sangat tinggi, sangat memahami kelebihan, kelemahan, serta motivasi internal yang mendorong kesuksesan.';
                    $prodiRekomendasi = 'Sains Komunikasi, Manajemen (SDM)';
                    $karirRekomendasi = 'Human Resource Analyst, Counselor, Creative Writer, Researcher';
                    break;
                case 'SC':
                    $profilUtama = 'The Bold Entrepreneur';
                    $karakteristik = 'Memiliki kepercayaan diri yang luar biasa, berani mengambil risiko, tidak takut gagal, dan sangat mandiri dalam mengambil keputusan penting.';
                    $prodiRekomendasi = 'Manajemen (Bisnis/Pemasaran)';
                    $karirRekomendasi = 'Startup Founder, Venture Builder, Marketing Director, Investment Analyst';
                    break;
                case 'SS':
                    $profilUtama = 'The Community Connector';
                    $karakteristik = 'Memiliki kecerdasan sosial yang tinggi, pandai berkolaborasi, pendengar yang baik, serta sangat menghargai keberagaman pendapat.';
                    $prodiRekomendasi = 'Sains Komunikasi';
                    $karirRekomendasi = 'Social Media Manager, PR Consultant, Community Director, Customer Success Specialist';
                    break;
                case 'SM':
                    $profilUtama = 'The Operations Master';
                    $karakteristik = 'Sangat disiplin, andal dalam manajemen waktu, memiliki ketahanan mental yang tinggi, dan memiliki perencanaan hidup yang sangat matang.';
                    $prodiRekomendasi = 'Sistem Informasi, Manajemen';
                    $karirRekomendasi = 'Project Manager, Operations Specialist, Database Administrator, Auditor';
                    break;
                case 'GM':
                    $profilUtama = 'The Lifelong Learner';
                    $karakteristik = 'Memiliki growth mindset yang luar biasa, terbuka terhadap kritik, menikmati proses belajar, dan menganggap kesalahan sebagai batu loncatan.';
                    $prodiRekomendasi = 'Sistem Informasi, Sains Komunikasi';
                    $karirRekomendasi = 'Software Developer, UX Researcher, Business Consultant, Educator';
                    break;
                case 'LP':
                    $profilUtama = 'The Dynamic Executive';
                    $karakteristik = 'Memiliki bakat kepemimpinan alami yang sangat baik, berani berinisiatif, dan siap menjadi role model bagi rekan sebayanya.';
                    $prodiRekomendasi = 'Manajemen';
                    $karirRekomendasi = 'Management Trainee, CEO Office Associate, Operations Lead, Community Leader';
                    break;
            }
        }

        // Tentukan narasi: jika ada narasi lama di database yang bukan format baru, pakai itu. 
        // Jika tidak, gunakan sistem narasi lokal PHP yang instan & hemat token.
        $narasiAi = null;
        if ($kesimpulan && !str_contains($kesimpulan, '📊 **HASIL ANALISIS')) {
            $narasiAi = $kesimpulan;
        } else {
            $narasiAi = self::generateLocalNarrative($pct, $profilUtama, $prodiRekomendasi);
        }

        // Susun report final berformat Markdown cantik
        $newReport = "📊 **HASIL ANALISIS INSTRUMEN PEMETAAN DIRI**\n";
        $newReport .= "--------------------------------------------------\n";
        $newReport .= "👤 **Nama Peserta:** " . ($this->peserta->nama ?? 'Peserta') . "\n";
        $newReport .= "📅 **Tanggal Ujian:** " . $this->created_at->translatedFormat('d F Y') . "\n\n";
        
        $newReport .= "📈 **PENCAPAIAN SKOR DIMENSI:**\n";
        $newReport .= "1. **Self Awareness (SA):** " . $dimensionScores['SA'] . "/30 (" . $pct['SA'] . "%) - " . $kategoriDimensi['SA'] . "\n";
        $newReport .= "2. **Self Confidence (SC):** " . $dimensionScores['SC'] . "/30 (" . $pct['SC'] . "%) - " . $kategoriDimensi['SC'] . "\n";
        $newReport .= "3. **Social Skill (SS):** " . $dimensionScores['SS'] . "/30 (" . $pct['SS'] . "%) - " . $kategoriDimensi['SS'] . "\n";
        $newReport .= "4. **Self Management (SM):** " . $dimensionScores['SM'] . "/30 (" . $pct['SM'] . "%) - " . $kategoriDimensi['SM'] . "\n";
        $newReport .= "5. **Growth Mindset (GM):** " . $dimensionScores['GM'] . "/30 (" . $pct['GM'] . "%) - " . $kategoriDimensi['GM'] . "\n";
        $newReport .= "6. **Leadership Potential (LP):** " . $dimensionScores['LP'] . "/30 (" . $pct['LP'] . "%) - " . $kategoriDimensi['LP'] . "\n\n";
        
        $newReport .= "🎯 **SKOR KESELURUHAN & KESIAPAN:**\n";
        $newReport .= "* **Total Skor:** " . $totalSkor . "/180\n";
        $newReport .= "* **Persentase Akhir:** " . $totalPercentage . "%\n";
        $newReport .= "* **Kategori Kesiapan:** **" . $finalKategori . "**\n";
        $newReport .= "* *Deskripsi:* " . $finalDeskripsi . "\n\n";
        
        $newReport .= "🧠 **PROFIL KEPRIBADIAN (DOMINAN):**\n";
        $newReport .= "* **Profil Utama:** **" . $profilUtama . "**\n";
        $newReport .= "* **Karakteristik Kunci:** " . $karakteristik . "\n\n";
        
        $newReport .= "🎓 **REKOMENDASI PROGRAM STUDI & KARIR:**\n";
        $newReport .= "* **Program Studi Sangat Cocok (MNC University):** **" . $prodiRekomendasi . "**\n";
        $newReport .= "* **Rekomendasi Karir Masa Depan:** **" . $karirRekomendasi . "**\n\n";
        
        $newReport .= "--------------------------------------------------\n";
        $newReport .= "🤖 **INTERPRETASI PSIKOLOGIS (ARION AI):**\n";
        $newReport .= $narasiAi;

        // Simpan ke database agar pemanggilan berikutnya instan
        $this->update(['kesimpulan_ai' => $newReport]);

        return $newReport;
    }
}
