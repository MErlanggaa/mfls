<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Daftar;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function logAktivitas($aksi, $targetTipe = null, $targetId = null, $deskripsi = null)
    {
        \App\Models\RiwayatAktivitas::create([
            'pelaku_id' => auth()->id(),
            'aksi' => $aksi,
            'target_tipe' => $targetTipe,
            'target_id' => $targetId,
            'deskripsi' => $deskripsi
        ]);
    }

    public function dashboard()
    {
        $riwayats = \App\Models\RiwayatAktivitas::with('pelaku')->latest()->take(10)->get();
        
        // Stats untuk Dashboard Real-time
        $totalPendaftar = Akun::where('role', 'pendaftar')->count();
        $todayPendaftar = Akun::where('role', 'pendaftar')->whereDate('created_at', \Carbon\Carbon::today())->count();
        $yesterdayPendaftar = Akun::where('role', 'pendaftar')->whereDate('created_at', \Carbon\Carbon::yesterday())->count();
        
        // Hitung kenaikan (growth)
        $growth = 0;
        if ($yesterdayPendaftar > 0) {
            $growth = (($todayPendaftar - $yesterdayPendaftar) / $yesterdayPendaftar) * 100;
        } elseif ($todayPendaftar > 0) {
            $growth = 100;
        }

        // Daily trend (last 7 days)
        $dailyTrend = Akun::where('role', 'pendaftar')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(6))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return view('admin.dashboard', compact('riwayats', 'totalPendaftar', 'todayPendaftar', 'growth', 'dailyTrend'));
    }

    public function storePenilaianMentor(Request $request, $id)
    {
        if (auth()->user()->role !== 'mentor' && auth()->user()->role !== 'admin') {
            return back()->with('loginError', 'Hanya Mentor yang dapat memberikan penilaian.');
        }

        $request->validate([
            'nilai_kepemimpinan' => 'required|numeric|min:0|max:100',
            'nilai_kepribadian' => 'required|numeric|min:0|max:100',
            'nilai_keaktifan' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        $peserta = \App\Models\Peserta::where('akun_id', $id)->firstOrFail();

        // Cek apakah sudah lulus administrasi
        if ($peserta->daftar->status !== 'lulus') {
            return back()->with('loginError', 'Peserta ini belum lulus tahap administrasi.');
        }

        // Kalkulasi nilai berbobot
        // 1. Kepemimpinan - 35%
        // 2. Kepribadian - 35%
        // 3. Keaktifan - 30%
        $totalNilai = ($request->nilai_kepemimpinan * 0.35) + 
                      ($request->nilai_kepribadian * 0.35) + 
                      ($request->nilai_keaktifan * 0.30);

        \App\Models\PenilaianMentor::updateOrCreate(
            ['peserta_id' => $peserta->id, 'mentor_id' => auth()->id()],
            [
                'nilai' => $totalNilai,
                'nilai_kepemimpinan' => $request->nilai_kepemimpinan,
                'nilai_kepribadian' => $request->nilai_kepribadian,
                'nilai_keaktifan' => $request->nilai_keaktifan,
                'catatan' => $request->catatan
            ]
        );

        $this->logAktivitas('Menilai Peserta', 'Peserta', $peserta->id, "Memberikan nilai mentor (" . number_format($totalNilai, 2) . ") kepada " . ($peserta->akun->nama ?? 'Peserta'));

        return back()->with('success', 'Penilaian mentor berhasil disimpan!');
    }

    // --- DATA PENDAFTAR: UNIFIED SELEKSI ADMINISTRASI (PROFIL, RAPORT, BERKAS) ---
    public function indexPendaftar(Request $request)
    {
        if (auth()->user()->role === 'mentor') return abort(403);

        $query = Akun::where('role', 'pendaftar')->with(['peserta.daftar', 'peserta.nilais', 'peserta.berkas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('peserta.daftar', function($q2) use ($search) {
                      $q2->where('asal_sekolah', 'like', "%{$search}%")
                         ->orWhere('kode_referral', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('filter_nilai')) {
            $query->whereHas('peserta.daftar', function($q) use ($request) {
                $q->where('rata_rata_nilai', '>=', $request->filter_nilai);
            });
        }

        $pendaftars = $query->latest()->get();

        // Auto-sync rata-rata nilai if needed
        foreach($pendaftars as $akun) {
            if($akun->peserta && $akun->peserta->daftar) {
                $realAvg = $akun->peserta->nilais->avg('nilai') ?? 0;
                if(abs(($akun->peserta->daftar->rata_rata_nilai ?? 0) - $realAvg) > 0.01) {
                    $akun->peserta->daftar->update(['rata_rata_nilai' => $realAvg]);
                }
            }
        }

        return view('admin.pendaftar.index', compact('pendaftars'));
    }

    // --- SISTEM DATABASE TERPUSAT: BEASISWA ---
    public function indexBeasiswa(Request $request)
    {
        if (auth()->user()->role === 'mentor') return abort(403);

        $query = Akun::where('role', 'pendaftar')
            ->with(['peserta.daftar', 'peserta.nilais', 'peserta.berkas', 'peserta.penilaianMentors.mentor', 'peserta.jawabanUjians.ujian']);

        // filters ...
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('peserta.daftar', function($q2) use ($search) {
                      $q2->where('asal_sekolah', 'like', "%{$search}%")
                         ->orWhere('kode_referral', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('sekolah')) {
            $query->whereHas('peserta.daftar', function($q) use ($request) {
                $q->where('asal_sekolah', 'like', "%{$request->sekolah}%");
            });
        }

        if ($request->filled('min_nilai')) {
            $query->whereHas('peserta.daftar', function($q) use ($request) {
                $q->where('rata_rata_nilai', '>=', $request->min_nilai);
            });
        }

        $pendaftars = $query->latest()->get();

        return view('admin.beasiswa.index', compact('pendaftars'));
    }

    public function showBeasiswa($id)
    {
        if (auth()->user()->role === 'mentor') return abort(403);
        
        $user = Akun::with([
            'peserta.daftar', 
            'peserta.berkas', 
            'peserta.nilais.matpel', 
            'peserta.penilaianMentors.mentor',
            'peserta.nilaiUjians.ujian'
        ])->findOrFail($id);

        $rataRataAkademik = $user->peserta->nilais->avg('nilai') ?? 0;
        $rataRataMentor = $user->peserta->penilaianMentors->avg('nilai') ?? 0;

        return view('admin.beasiswa.show', compact('user', 'rataRataAkademik', 'rataRataMentor'));
    }

    public function updateBeasiswa(Request $request, $id)
    {
        $request->validate([
            'nominal_beasiswa' => 'nullable|string|max:255',
            'status' => 'required|in:lulus,tidak_lulus,menunggu'
        ]);

        $daftar = Daftar::where('peserta_id', function($query) use ($id) {
            $query->select('id')->from('peserta')->where('akun_id', $id);
        })->firstOrFail();

        $daftar->update([
            'status' => $request->status,
            'nominal_beasiswa' => $request->nominal_beasiswa
        ]);

        $akun = Akun::with('peserta')->findOrFail($id);
        $this->logAktivitas('Update Beasiswa', 'Peserta', $akun->peserta->id, "Menetapkan beasiswa {$request->nominal_beasiswa} untuk {$akun->nama}");

        return back()->with('success', 'Keputusan beasiswa berhasil disimpan!');
    }

    public function indexHasilUjian()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'akademik') return abort(403);

        $hasilUjians = \App\Models\JawabanUjian::with(['peserta.akun', 'ujian'])
            ->latest()
            ->get();

        return view('admin.hasil_ujian.index', compact('hasilUjians'));
    }

    // --- DATA PENDAFTAR: PENILAIAN MENTOR ---
    public function indexPenilaian()
    {
        if (auth()->user()->role !== 'mentor' && auth()->user()->role !== 'admin') return abort(403);
        
        // Hanya tampilkan peserta yang sudah LULUS tahap administrasi
        $pendaftars = Akun::where('role', 'pendaftar')
            ->whereHas('peserta.daftar', function($q) {
                $q->where('status', 'lulus');
            })
            ->with(['peserta.daftar', 'peserta.penilaianMentors'])
            ->latest()
            ->get();
            
        return view('admin.penilaian.index', compact('pendaftars'));
    }

    public function showPenilaian($id)
    {
        if (auth()->user()->role !== 'mentor' && auth()->user()->role !== 'admin') return abort(403);
        $user = Akun::with(['peserta.daftar', 'peserta.penilaianMentors.mentor'])->findOrFail($id);
        return view('admin.penilaian.show', compact('user'));
    }

    // --- PENGATURAN: MANAJEMEN MENTOR ---
    public function indexMentor()
    {
        if (auth()->user()->role !== 'admin') return abort(403);
        $mentors = Akun::where('role', 'mentor')->withCount('peserta')->get();
        return view('admin.mentor.index', compact('mentors'));
    }

    public function detailPendaftar($id)
    {
        $user = Akun::with(['peserta.daftar', 'peserta.berkas', 'peserta.nilais.matpel'])->findOrFail($id);
        return view('admin.pendaftar.show', compact('user'));
    }


    public function indexSoal(Request $request)
    {
        if (auth()->user()->role === 'mentor') {
            return redirect()->route('admin.dashboard')->with('loginError', 'Mentor tidak memiliki akses ke Bank Soal.');
        }

        $query = \App\Models\Soal::with('ujian')->latest();

        // Fitur Filter by Kategori Ujian
        if ($request->filled('ujian_id')) {
            $query->where('ujian_id', $request->ujian_id);
        }

        $soals = $query->get();
        $ujians = \App\Models\Ujian::all();
        
        return view('admin.soal.index', compact('soals', 'ujians'));
    }

    public function storeSoal(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required|exists:ujian,id',
            'pertanyaan' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'kunci_jawaban' => 'required|in:a,b,c,d',
            'bobot' => 'required|integer'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('soal_images', 'public');
            $data['gambar'] = $path;
        }

        \App\Models\Soal::create($data);
        $this->logAktivitas('Tambah Soal', 'Soal', null, "Menambahkan soal baru ke kategori ID: " . $data['ujian_id']);

        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function editSoal($id)
    {
        if (auth()->user()->role === 'mentor') return abort(403);
        $soal = \App\Models\Soal::findOrFail($id);
        $ujians = \App\Models\Ujian::all();
        return view('admin.soal.edit', compact('soal', 'ujians'));
    }

    public function updateSoal(Request $request, $id)
    {
        if (auth()->user()->role === 'mentor') return abort(403);
        $request->validate([
            'ujian_id' => 'required|exists:ujian,id',
            'pertanyaan' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'kunci_jawaban' => 'required|in:a,b,c,d',
            'bobot' => 'required|integer'
        ]);

        $soal = \App\Models\Soal::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($soal->gambar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($soal->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('soal_images', 'public');
        }

        $soal->update($data);

        return redirect()->route('admin.soal.index', ['ujian_id' => $soal->ujian_id])->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroySoal($id)
    {
        if (auth()->user()->role === 'mentor') return abort(403);
        $soal = \App\Models\Soal::findOrFail($id);
        if ($soal->gambar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($soal->gambar);
        }
        $this->logAktivitas('Hapus Soal', 'Soal', $id, "Menghapus soal: " . substr($soal->pertanyaan, 0, 30));
        $soal->delete();

        return back()->with('success', 'Soal berhasil dihapus!');
    }

    public function importSoal(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required|exists:ujian,id',
            'file_soal' => 'required|mimes:csv,txt,docx'
        ]);

        $ujianId = $request->ujian_id;
        $file = $request->file('file_soal');
        $ext = $file->getClientOriginalExtension();

        if ($ext === 'docx') {
            return $this->importWord($file, $ujianId);
        }

        // ... Logic CSV lama ...
        $handle = fopen($file->getRealPath(), "r");
        fgetcsv($handle); // Skip header
        
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if(count($row) >= 7) {
                \App\Models\Soal::create([
                    'ujian_id' => $ujianId,
                    'pertanyaan' => $row[0],
                    'gambar' => null,
                    'opsi_a' => $row[1],
                    'opsi_b' => $row[2],
                    'opsi_c' => $row[3],
                    'opsi_d' => $row[4],
                    'kunci_jawaban' => strtolower($row[5]),
                    'bobot' => (int)$row[6]
                ]);
            }
        }
        fclose($handle);

        return back()->with('success', 'Import soal berhasil!');
    }

    private function importWord($file, $ujianId)
    {
        $zip = new \ZipArchive;
        $xmlContent = '';

        if ($zip->open($file->getRealPath()) === TRUE) {
            $xmlContent = $zip->getFromName('word/document.xml');
            $zip->close();
        } else {
            return back()->with('loginError', 'Gagal membaca file Word.');
        }

        // Parsing XML sederhana
        $dom = new \DOMDocument();
        $dom->loadXML($xmlContent);
        $paragraphs = $dom->getElementsByTagName('p'); // Paragraph tag in Word XML

        $currentSoal = [];

        foreach ($paragraphs as $p) {
            $text = $p->textContent;
            $text = trim($text);
            if (empty($text)) continue;
            
            // Deteksi Opsi (A., B., C., D.)
            if (preg_match('/^([A-D])\.\s*(.*)/i', $text, $matches)) {
                $optKey = strtolower($matches[1]); // a, b, c, d
                $currentSoal['opsi_' . $optKey] = $matches[2];
            }
            // Deteksi Kunci Jawaban (Kunci: A)
            elseif (preg_match('/^Kunci\s*:\s*([A-D])/i', $text, $matches)) {
                $currentSoal['kunci_jawaban'] = strtolower($matches[1]);
                
                // Kunci biasanya baris terakhir per soal, jadi simpan
                if (isset($currentSoal['pertanyaan'])) {
                    $currentSoal['ujian_id'] = $ujianId; // Set Ujian ID
                    $currentSoal['bobot'] = 5;
                    \App\Models\Soal::create($currentSoal);
                    $currentSoal = []; // Reset
                }
            }
            // Deteksi Soal Baru (1. Pertanyaan...)
            elseif (preg_match('/^\d+\.\s*(.*)/', $text, $matches)) {
                $currentSoal = [];
                $currentSoal['pertanyaan'] = $matches[1];
            }
            else {
                if (isset($currentSoal['pertanyaan']) && !isset($currentSoal['opsi_a'])) {
                    $currentSoal['pertanyaan'] .= " " . $text;
                }
            }
        }

        return back()->with('success', 'Import Word berhasil!');
    }



    public function verifikasi(Request $request, $id)
    {
        if (auth()->user()->role === 'mentor') {
             return back()->with('loginError', 'Mentor tidak memiliki izin verifikasi kelulusan.');
        }

        $daftar = Daftar::where('peserta_id', function($query) use ($id) {
            $query->select('id')->from('peserta')->where('akun_id', $id);
        })->firstOrFail();

        $daftar->update([
            'status' => $request->status
        ]);

        $akun = Akun::with('peserta')->findOrFail($id);
        $this->logAktivitas('Verifikasi Status', 'Peserta', $akun->peserta->id, "Mengubah status {$akun->nama} menjadi " . strtoupper($request->status));

        // Logic Email Notifikasi
        if ($request->status == 'lulus') {

            // Ganti link ini dengan link React App Anda yang sebenarnya
            $linkUjian = "https://ujian-react.mfls.com/start?token=" . base64_encode($akun->email); 
            
            try {
                \Illuminate\Support\Facades\Mail::to($akun->email)->send(
                    new \App\Mail\UjianLinkMail($akun->nama, $linkUjian)
                );
            } catch (\Exception $e) {
                // Log error email tapi jangan hentikan proses
                \Illuminate\Support\Facades\Log::error("Gagal kirim email ujian: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Status kelulusan berhasil diperbarui!');
    }

    public function updateNilaiDummy(Request $request, $id) {
         // Ini method helper untuk testing update nilai rata-rata
         $daftar = Daftar::where('peserta_id', function($query) use ($id) {
            $query->select('id')->from('peserta')->where('akun_id', $id);
        })->firstOrFail();

        $daftar->update(['rata_rata_nilai' => $request->nilai]);
        return back();
    }

    public function exportExcel()
    {
        $fileName = 'Master_Database_MFLS_' . date('Y-m-d_H-i') . '.csv';
        $pendaftars = Akun::where('role', 'pendaftar')
                         ->with(['peserta.daftar', 'peserta.nilais.matpel', 'peserta.berkas', 'peserta.penilaianMentors.mentor'])
                         ->get();

        $columns = [
            'Nama Lengkap', 'Email', 'NISN', 'Asal Sekolah', 'Kode Referral', 'Status Akhir', 'Nominal Beasiswa',
            'S1 (AVG)', 'S2 (AVG)', 'S3 (AVG)', 'S4 (AVG)', 'S5 (AVG)', 'S6 (AVG)', 'TOTAL AKADEMIK',
            'SKOR MENTOR', 'CATATAN MENTOR',
            'FOTO', 'RAPOR S1', 'RAPOR S2', 'RAPOR S3', 'RAPOR S4', 'RAPOR S5', 'IJAZAH', 'VIDEO MOTIVASI'
        ];

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($pendaftars, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($pendaftars as $user) {
                if (!$user->peserta) continue;

                $peserta = $user->peserta;
                $daftar = $peserta->daftar;
                $berkas = $peserta->berkas;
                $penilaians = $peserta->penilaianMentors;

                // 1. Identitas
                $row = [
                    $user->nama,
                    $user->email,
                    $peserta->nisn ?? '-',
                    $daftar->asal_sekolah ?? '-',
                    $daftar->kode_referral ?? '-',
                    strtoupper($daftar->status ?? 'menunggu'),
                    $daftar->nominal_beasiswa ?? '-',
                ];

                // 2. Akademik
                $nilais = $peserta->nilais;
                $totalAll = 0;
                $countAll = 0;
                for ($sem = 1; $sem <= 6; $sem++) {
                    $avgSem = $nilais->where('semester', $sem)->avg('nilai') ?? 0;
                    $row[] = number_format($avgSem, 2);
                    if($avgSem > 0) { $totalAll += $avgSem; $countAll++; }
                }
                $row[] = $countAll > 0 ? number_format($totalAll / $countAll, 2) : '0';

                // 3. Mentor
                $row[] = number_format($penilaians->avg('nilai') ?? 0, 2);
                $catatanMentor = [];
                foreach($penilaians as $p) {
                    $catatanMentor[] = "[{$p->mentor->nama}]: {$p->catatan}";
                }
                $row[] = implode(' | ', $catatanMentor);

                // 4. Berkas (8 separate columns with Links for clicking)
                $row[] = ($berkas && $berkas->foto) ? url('storage/'.$berkas->foto) : '-';
                $row[] = ($berkas && $berkas->rapor1) ? url('storage/'.$berkas->rapor1) : '-';
                $row[] = ($berkas && $berkas->rapor2) ? url('storage/'.$berkas->rapor2) : '-';
                $row[] = ($berkas && $berkas->rapor3) ? url('storage/'.$berkas->rapor3) : '-';
                $row[] = ($berkas && $berkas->rapor4) ? url('storage/'.$berkas->rapor4) : '-';
                $row[] = ($berkas && $berkas->rapor5) ? url('storage/'.$berkas->rapor5) : '-';
                $row[] = ($berkas && $berkas->ijazah) ? url('storage/'.$berkas->ijazah) : '-';
                $row[] = ($berkas && $berkas->motivasi_video) ? url('storage/'.$berkas->motivasi_video) : '-';

                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
