<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;
        $berkas = \App\Models\Berkas::where('peserta_id', $peserta->id)->first();
        
        // --- Calculate Progress ---
        $totalPoints = 0;
        $earnedPoints = 0;

        // 1. Biodata Points (40%)
        $biodataFields = ['nama', 'nisn', 'no_whatsapp', 'tgl_lahir', 'jenis_kelamin', 'provinsi', 'kabupaten', 'nama_sekolah', 'tahun_lulus'];
        $totalPoints += count($biodataFields);
        foreach ($biodataFields as $field) {
            if (!empty($peserta->$field)) $earnedPoints++;
        }

        // 2. Berkas Points (40%)
        $berkasFields = ['foto', 'rapor1', 'rapor2', 'rapor3', 'rapor4', 'rapor5', 'ijazah', 'personal_statement'];
        $totalPoints += count($berkasFields);
        if ($berkas) {
            foreach ($berkasFields as $field) {
                if (!empty($berkas->$field)) $earnedPoints++;
            }
        }

        // 3. Twibbon & Sosmed Points (20%)
        $sosmedFields = ['link_twibbon']; // link_ig and link_tiktok are optional in calculation or make them bonus? Let's make twibbon mandatory for progress.
        $totalPoints += count($sosmedFields);
        foreach ($sosmedFields as $field) {
            if (!empty($peserta->$field)) $earnedPoints++;
        }

        $progress = ($totalPoints > 0) ? round(($earnedPoints / $totalPoints) * 100) : 0;

        // --- Fetch Real Activity Logs ---
        $logs = \App\Models\RiwayatAktivitas::where('pelaku_id', auth()->id())
                    ->latest()
                    ->take(10)
                    ->get();
        
        $history = [];
        foreach($logs as $log) {
            $icon = 'user';
            $aksi = strtolower($log->aksi);
            if(str_contains($aksi, 'update') || str_contains($aksi, 'simpan') || str_contains($aksi, 'biodata')) $icon = 'edit';
            if(str_contains($aksi, 'upload') || str_contains($aksi, 'berkas') || str_contains($aksi, 'file')) $icon = 'upload';
            if(str_contains($aksi, 'nilai') || str_contains($aksi, 'rapor')) $icon = 'chart-bar';
            if(str_contains($aksi, 'prodi')) $icon = 'graduation-cap';
            
            $history[] = [
                'title' => $log->aksi,
                'desc' => $log->deskripsi,
                'date' => $log->created_at->diffForHumans(),
                'icon' => $icon,
                'status' => 'completed'
            ];
        }

        // Seed initial history if empty
        if(count($history) == 0) {
            $history[] = [
                'title' => 'Selamat Datang!',
                'desc' => 'Akun Anda berhasil terdaftar di sistem MFLS.',
                'date' => auth()->user()->created_at->format('d M Y'),
                'icon' => 'user',
                'status' => 'completed'
            ];
        }

        return view('pendaftar.dashboard', compact('peserta', 'berkas', 'progress', 'history'));
    }

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

    public function biodata()
    {
        $peserta = Auth::user()->peserta;
        return view('pendaftar.biodata', compact('peserta'));
    }

    public function berkas()
    {
        $peserta = Auth::user()->peserta;
        $berkas = \App\Models\Berkas::where('peserta_id', $peserta->id)->first();
        $sertifikats = \App\Models\Sertifikat::where('peserta_id', $peserta->id)->get();
        return view('pendaftar.berkas', compact('peserta', 'berkas', 'sertifikats'));
    }

    public function storeBerkas(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|max:2048',
            'rapor1.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'rapor2.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'rapor3.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'rapor4.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'rapor5.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'ijazah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'personal_statement' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'motivasi_video' => 'nullable|url|max:500', // Changed to URL
            'sertifikat.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $peserta = Auth::user()->peserta;
        
        // Handle Berkas
        $berkas = \App\Models\Berkas::firstOrNew(['peserta_id' => $peserta->id]);

        $raporFields = ['rapor1', 'rapor2', 'rapor3', 'rapor4', 'rapor5'];
        $singleFields = ['foto', 'ijazah', 'personal_statement'];

        // Handle Single Files
        foreach ($singleFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('berkas/' . $peserta->id, 'public');
                $berkas->$field = $path;
            }
        }

        // Handle Array Files (Rapor)
        foreach ($raporFields as $field) {
            if ($request->hasFile($field)) {
                $files = $request->file($field);
                $paths = [];
                // Check if it's actually an array of files or just one
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $paths[] = $file->store('berkas/' . $peserta->id . '/' . $field, 'public');
                    }
                } else {
                    $paths[] = $files->store('berkas/' . $peserta->id . '/' . $field, 'public');
                }
                
                // Store as JSON
                $berkas->$field = json_encode($paths);
            }
        }

        // Handle Sertifikat (Multiple Uploads)
        $sertifikatCount = 0;
        if ($request->hasFile('sertifikat')) {
            $files = $request->file('sertifikat');
            $sertifikatFiles = is_array($files) ? $files : [$files];
            foreach ($sertifikatFiles as $file) {
                $path = $file->store('sertifikat/' . $peserta->id, 'public');
                \App\Models\Sertifikat::create([
                    'peserta_id' => $peserta->id,
                    'nama' => 'Sertifikat ' . date('Y-m-d H:i:s'), 
                    'file' => $path,
                    'tahun' => date('Y'),
                ]);
                $sertifikatCount++;
            }
        }

        // Track what was actually changed
        $uploaded = [];
        if($request->hasFile('foto')) $uploaded[] = 'Pas Foto 4x6';
        if($request->hasFile('ijazah')) $uploaded[] = 'Ijazah/SKL';
        if($request->hasFile('personal_statement')) $uploaded[] = 'Personal Statement';
        if($request->filled('motivasi_video')) $uploaded[] = 'Link Video Motivasi';
        
        for($i=1;$i<=5;$i++) {
            if($request->hasFile('rapor'.$i)) $uploaded[] = "Scan Rerata S$i";
        }
        
        if($sertifikatCount > 0) $uploaded[] = "$sertifikatCount Sertifikat Prestasi";
        
        if(count($uploaded) > 0) {
            $desc = 'Berhasil memperbarui dokumen: ' . implode(', ', $uploaded);
            $this->logAktivitas('Pembaruan Berkas', 'Berkas', $berkas->id, $desc);
        }

        return redirect()->back()->with('success', 'Berkas pendaftaran Anda berhasil disimpan dan dicatat dalam log!');
    }

    public function twibbon()
    {
        $peserta = Auth::user()->peserta;
        return view('pendaftar.twibbon', compact('peserta'));
    }

    public function storeTwibbon(Request $request)
    {
        $request->validate([
            'link_ig' => 'nullable|url|max:255',
            'link_tiktok' => 'nullable|url|max:255',
            'link_twibbon' => 'required|url|max:255',
        ]);

        $peserta = Auth::user()->peserta;
        $peserta->update([
            'link_ig' => $request->link_ig,
            'link_tiktok' => $request->link_tiktok,
            'link_twibbon' => $request->link_twibbon,
        ]);

        $this->logAktivitas('Update Media Sosial', 'Peserta', $peserta->id, 'Memperbarui link Twibbon' . ($request->filled('link_ig') || $request->filled('link_tiktok') ? ' dan Media Sosial.' : '.'));

        return back()->with('success', 'Tautan media sosial & Twibbon berhasil disimpan!');
    }

    public function nilai()
    {
        $peserta = Auth::user()->peserta;
        $matpels = \App\Models\Matpel::whereIn('nama', ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Informatika'])->get();
        // Fetch existing score
        $existingNilai = \App\Models\Nilai::where('peserta_id', $peserta->id)->get()->groupBy('matpel_id');
        
        // Also get custom matpels IDs that are NOT in the core list but have scores for this user
        $coreIds = $matpels->pluck('id')->toArray();
        $customMatpelIds = \App\Models\Nilai::where('peserta_id', $peserta->id)->whereNotIn('matpel_id', $coreIds)->pluck('matpel_id')->unique();
        $customMatpels = \App\Models\Matpel::whereIn('id', $customMatpelIds)->get();

        $berkas = \App\Models\Berkas::where('peserta_id', $peserta->id)->first();

        return view('pendaftar.nilai', compact('peserta', 'matpels', 'existingNilai', 'customMatpels', 'berkas'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'pilihan_prodi' => 'required',
            'surat_buta_warna' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'rapor1.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor2.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor3.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor4.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor5.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $peserta = Auth::user()->peserta;
        $peserta->update(['pilihan_prodi' => $request->pilihan_prodi]);
        
        $berkas = \App\Models\Berkas::firstOrNew(['peserta_id' => $peserta->id]);

        // Handle deletions of custom subjects
        if ($request->has('deleted_custom_matpels')) {
            \App\Models\Nilai::where('peserta_id', $peserta->id)
                ->whereIn('matpel_id', $request->deleted_custom_matpels)
                ->delete();
        }

        // Upload Buta Warna if DKV
        if ($request->hasFile('surat_buta_warna')) {
            $path = $request->file('surat_buta_warna')->store('berkas/' . $peserta->id, 'public');
            $berkas->surat_buta_warna = $path;
        }

        // Handle Rapor Files Scans (Semester 1-5)
        for ($i = 1; $i <= 5; $i++) {
            $field = 'rapor' . $i;
            if ($request->hasFile($field)) {
                $files = $request->file($field);
                $paths = [];
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $paths[] = $file->store('berkas/' . $peserta->id . '/' . $field, 'public');
                    }
                } else {
                    $paths[] = $files->store('berkas/' . $peserta->id . '/' . $field, 'public');
                }
                $berkas->$field = json_encode($paths);
            }
        }
        $berkas->save();

        // Save Core Subjects
        if ($request->has('nilai')) {
            foreach ($request->nilai as $matpelId => $semesters) {
                foreach ($semesters as $sem => $val) {
                    if ($val || $val === '0') { // Allow 0
                        \App\Models\Nilai::updateOrCreate(
                            ['peserta_id' => $peserta->id, 'matpel_id' => $matpelId, 'semester' => $sem],
                            ['nilai' => $val]
                        );
                    }
                }
            }
        }

        // Save Custom Subjects
        if ($request->has('custom_matpel')) {
            foreach ($request->custom_matpel as $custom) {
                if (!empty($custom['nama'])) {
                    // Create or Get Matpel
                    $matpel = \App\Models\Matpel::firstOrCreate(['nama' => $custom['nama']]);
                    if (isset($custom['nilai'])) {
                        foreach ($custom['nilai'] as $sem => $val) {
                            if ($val || $val === '0') {
                                \App\Models\Nilai::updateOrCreate(
                                    ['peserta_id' => $peserta->id, 'matpel_id' => $matpel->id, 'semester' => $sem],
                                    ['nilai' => $val]
                                );
                            }
                        }
                    }
                }
            }
        }

        $uploadedRapor = [];
        for($i=1;$i<=5;$i++) if($request->hasFile('rapor'.$i)) $uploadedRapor[] = "Scan Rerata S$i";
        
        $msg = "Input nilai akademik semester 1-5" . (count($uploadedRapor) > 0 ? " dan unggah berkas " . implode(', ', $uploadedRapor) : "") . ". Pilihan Prodi: {$request->pilihan_prodi}.";

        $this->logAktivitas('Pengisian Nilai Rapor', 'Nilai', $peserta->id, $msg);

        return back()->with('success', 'Data akademik dan pilihan program studi berhasil disimpan!');
    }
}
