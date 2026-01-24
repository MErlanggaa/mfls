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
        return view('admin.dashboard', compact('riwayats'));
    }

    public function storePenilaianMentor(Request $request, $id)
    {
        if (auth()->user()->role !== 'mentor' && auth()->user()->role !== 'admin') {
            return back()->with('loginError', 'Hanya Mentor yang dapat memberikan penilaian.');
        }

        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        $peserta = \App\Models\Peserta::where('akun_id', $id)->firstOrFail();

        \App\Models\PenilaianMentor::updateOrCreate(
            ['peserta_id' => $peserta->id, 'mentor_id' => auth()->id()],
            ['nilai' => $request->nilai, 'catatan' => $request->catatan]
        );

        $this->logAktivitas('Menilai Peserta', 'Peserta', $peserta->id, "Memberikan nilai mentor kepada " . ($peserta->akun->nama ?? 'Peserta'));

        return back()->with('success', 'Penilaian mentor berhasil disimpan!');
    }

    // --- DATA PENDAFTAR: PROFIL ---
    public function indexPendaftar(Request $request)
    {
        $query = Akun::where('role', 'pendaftar')->with(['peserta.daftar', 'peserta.nilais']);
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
        $pendaftars = $query->latest()->get();

        foreach($pendaftars as $akun) {
            if($akun->peserta && $akun->peserta->daftar) {
                $realAvg = $akun->peserta->nilais->avg('nilai') ?? 0;
                if(abs($akun->peserta->daftar->rata_rata_nilai - $realAvg) > 0.01) {
                    $akun->peserta->daftar->update(['rata_rata_nilai' => $realAvg]);
                    $akun->peserta->daftar->rata_rata_nilai = $realAvg;
                }
            }
        }

        return view('admin.pendaftar.index', compact('pendaftars'));
    }

    // --- DATA PENDAFTAR: AKADEMIK (RAPORT) ---
    public function indexRaport(Request $request)
    {
        if (auth()->user()->role === 'mentor') return abort(403);

        $query = Akun::where('role', 'pendaftar')->with(['peserta.daftar', 'peserta.nilais']);
        $pendaftars = $query->latest()->get();

        foreach($pendaftars as $akun) {
            if($akun->peserta && $akun->peserta->daftar) {
                $realAvg = $akun->peserta->nilais->avg('nilai') ?? 0;
                if(abs($akun->peserta->daftar->rata_rata_nilai - $realAvg) > 0.01) {
                    $akun->peserta->daftar->update(['rata_rata_nilai' => $realAvg]);
                    $akun->peserta->daftar->rata_rata_nilai = $realAvg;
                }
            }
        }

        return view('admin.raport.index', compact('pendaftars'));
    }

    public function showRaport($id)
    {
        $user = Akun::with(['peserta.daftar', 'peserta.nilais.matpel'])->findOrFail($id);
        $rataRata = $user->peserta->nilais->avg('nilai') ?? 0;
        return view('admin.raport.show', compact('user', 'rataRata'));
    }

    // --- DATA PENDAFTAR: BERKAS ---
    public function indexBerkas()
    {
        if (auth()->user()->role === 'mentor') return abort(403);
        $pendaftars = Akun::where('role', 'pendaftar')->with(['peserta.berkas', 'peserta.daftar', 'peserta.nilais'])->get();
        
        foreach($pendaftars as $akun) {
            if($akun->peserta && $akun->peserta->daftar) {
                $realAvg = $akun->peserta->nilais->avg('nilai') ?? 0;
                if(abs($akun->peserta->daftar->rata_rata_nilai - $realAvg) > 0.01) {
                    $akun->peserta->daftar->update(['rata_rata_nilai' => $realAvg]);
                }
            }
        }

        return view('admin.berkas.index', compact('pendaftars'));
    }

    public function showBerkas($id)
    {
        $user = Akun::with(['peserta.daftar', 'peserta.berkas'])->findOrFail($id);
        return view('admin.berkas.show', compact('user'));
    }

    // --- DATA PENDAFTAR: SOSMED ---
    public function indexSosmed()
    {
        if (auth()->user()->role === 'mentor') return abort(403);
        $pendaftars = Akun::where('role', 'pendaftar')->with(['peserta.daftar', 'peserta.nilais'])->get();

        foreach($pendaftars as $akun) {
            if($akun->peserta && $akun->peserta->daftar) {
                $realAvg = $akun->peserta->nilais->avg('nilai') ?? 0;
                if(abs($akun->peserta->daftar->rata_rata_nilai - $realAvg) > 0.01) {
                    $akun->peserta->daftar->update(['rata_rata_nilai' => $realAvg]);
                }
            }
        }

        return view('admin.sosmed.index', compact('pendaftars'));
    }

    public function showSosmed($id)
    {
        $user = Akun::with(['peserta.daftar'])->findOrFail($id);
        return view('admin.sosmed.show', compact('user'));
    }

    // --- DATA PENDAFTAR: PENILAIAN MENTOR ---
    public function indexPenilaian()
    {
        if (auth()->user()->role !== 'mentor' && auth()->user()->role !== 'admin') return abort(403);
        $pendaftars = Akun::where('role', 'pendaftar')->with(['peserta.penilaianMentors'])->get();
        return view('admin.penilaian.index', compact('pendaftars'));
    }

    public function showPenilaian($id)
    {
        if (auth()->user()->role !== 'mentor' && auth()->user()->role !== 'admin') return abort(403);
        $user = Akun::with(['peserta.penilaianMentors.mentor', 'peserta.daftar'])->findOrFail($id);
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
        $user = Akun::with(['peserta.daftar'])->findOrFail($id);
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

        $akun = Akun::find($id);
        $this->logAktivitas('Verifikasi Status', 'Peserta', $akun->peserta->id, "Mengubah status {$akun->nama} menjadi " . strtoupper($request->status));

        // Logic Email Notifikasi
        if ($request->status == 'lulus') {
            $akun = Akun::find($id);
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
        $fileName = 'detail_raport_mfls_' . date('Y-m-d_H-i') . '.csv';
        // Ambil data nilai juga
        $pendaftars = Akun::where('role', 'pendaftar')
                         ->with(['peserta.daftar', 'peserta.nilais.matpel'])
                         ->get();

        // Siapkan Header Dinamis
        // 1. Header Identitas
        $columns = ['Nama Lengkap', 'Email', 'NISN', 'Asal Sekolah', 'No. WA', 'Status Kelulusan', 'Waktu Daftar'];
        
        // 2. Ambil List Matpel dari database (asumsi semua siswa mapelnya sama/variatif, kita ambil unique)
        $allMatpels = \App\Models\Matpel::pluck('nama', 'id'); // [id => nama]

        // 3. Header Matpel (Matematika Sem 1, Matematika Sem 2... Matematika Avg)
        foreach ($allMatpels as $mpName) {
            for ($i = 1; $i <= 6; $i++) {
                $columns[] = "$mpName (S$i)";
            }
            $columns[] = "Rata2 $mpName";
        }

        // 4. Header Rata-rata Semester
        for ($i = 1; $i <= 6; $i++) {
            $columns[] = "Rata2 Sem $i";
        }
        $columns[] = 'TOTAL SCORE';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($pendaftars, $columns, $allMatpels) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis Header

            foreach ($pendaftars as $user) {
                if (!$user->peserta) continue;

                // Data Dasar
                $row = [
                    $user->nama,
                    $user->email,
                    $user->peserta->nisn ?? '-',
                    $user->peserta->daftar->asal_sekolah ?? '-',
                    $user->peserta->daftar->no_wa ?? '-',
                    ucfirst($user->peserta->daftar->status ?? 'menunggu'),
                    $user->created_at->format('Y-m-d H:i'),
                ];

                // Data Nilai Logic
                $nilais = $user->peserta->nilais;
                $semesterTotals = array_fill(1, 6, 0);
                $semesterCounts = array_fill(1, 6, 0);

                // Loop per Matpel
                foreach ($allMatpels as $mpId => $mpName) {
                    $mpTotal = 0;
                    $mpCount = 0;

                    // Loop Semester 1-6 untuk Matpel ini
                    for ($sem = 1; $sem <= 6; $sem++) {
                        $val = $nilais->where('matpel_id', $mpId)->where('semester', $sem)->first()->nilai ?? 0;
                        
                        $row[] = $val > 0 ? $val : '0'; // Masukkan ke CSV

                        if ($val > 0) {
                            $mpTotal += $val;
                            $mpCount++;
                            $semesterTotals[$sem] += $val;
                            $semesterCounts[$sem]++;
                        }
                    }
                    // Rata2 Per Matpel
                    $row[] = $mpCount > 0 ? number_format($mpTotal / $mpCount, 2) : '0';
                }

                // Loop Rata-rata Per Semester
                $totalAll = 0;
                $countAll = 0;
                for ($sem = 1; $sem <= 6; $sem++) {
                    $avgSem = $semesterCounts[$sem] > 0 ? ($semesterTotals[$sem] / $semesterCounts[$sem]) : 0;
                    $row[] = number_format($avgSem, 2);
                    
                    if ($avgSem > 0) {
                        $totalAll += $avgSem;
                        $countAll++;
                    }
                }

                // Total Score (Rata-rata dari Rata-rata Semester)
                $row[] = $countAll > 0 ? number_format($totalAll / $countAll, 2) : '0';

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
