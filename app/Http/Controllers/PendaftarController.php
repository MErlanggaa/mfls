<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarController extends Controller
{
    use \App\Traits\ImageCompressor;

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
            if (!empty($peserta->$field))
                $earnedPoints++;
        }

        // 2. Berkas Points (40%)
        $tahunLulus = (int) ($peserta->tahun_lulus ?? 2026);
        $berkasFields = ['foto', 'rapor1', 'rapor2', 'rapor3', 'rapor4', 'rapor5', 'ijazah', 'personal_statement', 'study_plan'];
        
        if ($tahunLulus >= 2026) {
            $berkasFields[] = 'surat_rekomendasi_sekolah';
        }

        $totalPoints += count($berkasFields);
        if ($berkas) {
            foreach ($berkasFields as $field) {
                if (!empty($berkas->$field))
                    $earnedPoints++;
            }
        }

        // 3. Twibbon & Sosmed Points (20%)
        $sosmedFields = ['link_twibbon']; // link_ig and link_tiktok are optional in calculation or make them bonus? Let's make twibbon mandatory for progress.
        $totalPoints += count($sosmedFields);
        foreach ($sosmedFields as $field) {
            if (!empty($peserta->$field))
                $earnedPoints++;
        }

        $progress = ($totalPoints > 0) ? round(($earnedPoints / $totalPoints) * 100) : 0;

        // --- Fetch Real Activity Logs ---
        $logs = \App\Models\RiwayatAktivitas::where('pelaku_id', auth()->id())
            ->latest()
            ->take(10)
            ->get();

        $history = [];
        foreach ($logs as $log) {
            $icon = 'user';
            $aksi = strtolower($log->aksi);
            if (str_contains($aksi, 'update') || str_contains($aksi, 'simpan') || str_contains($aksi, 'biodata'))
                $icon = 'edit';
            if (str_contains($aksi, 'upload') || str_contains($aksi, 'berkas') || str_contains($aksi, 'file'))
                $icon = 'upload';
            if (str_contains($aksi, 'nilai') || str_contains($aksi, 'rapor'))
                $icon = 'chart-bar';
            if (str_contains($aksi, 'prodi'))
                $icon = 'graduation-cap';

            $history[] = [
                'title' => $log->aksi,
                'desc' => $log->deskripsi,
                'date' => $log->created_at->diffForHumans(),
                'icon' => $icon,
                'status' => 'completed'
            ];
        }

        // Seed initial history if empty
        if (count($history) == 0) {
            $history[] = [
                'title' => 'Selamat Datang!',
                'desc' => 'Akun Anda berhasil terdaftar di sistem MFLS.',
                'date' => auth()->user()->created_at->format('d M Y'),
                'icon' => 'user',
                'status' => 'completed'
            ];
        }

        // Check if the user has added supporting subjects (at least 2 custom matpels)
        $coreMatpelIds = \App\Models\Matpel::whereIn('nama', ['Bahasa Indonesia', 'Matematika Wajib', 'Bahasa Inggris'])->pluck('id');
        $supportingCount = \App\Models\Nilai::where('peserta_id', $peserta->id)
            ->whereNotIn('matpel_id', $coreMatpelIds)
            ->distinct('matpel_id')
            ->count('matpel_id');
        $hasSupportingSubject = $supportingCount >= 2;

        return view('pendaftar.dashboard', compact('peserta', 'berkas', 'progress', 'history', 'hasSupportingSubject'));
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

    public function storeBiodata(Request $request)
    {
        $peserta = Auth::user()->peserta;
        
        $request->validate([
            'nisn' => 'required|string|max:20|unique:peserta,nisn,' . $peserta->id,
            'no_whatsapp' => 'required|string|max:20|unique:peserta,no_whatsapp,' . $peserta->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan,L,P',
            'tgl_lahir' => 'required|date',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'nama_sekolah' => 'required|string|max:255',
            'tahun_lulus' => 'required|integer',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar dalam sistem.',
            'no_whatsapp.unique' => 'Nomor WhatsApp ini sudah digunakan oleh pendaftar lain.',
        ]);

        $peserta->update($request->only([
            'nisn', 'no_whatsapp', 'jenis_kelamin', 'tgl_lahir', 'provinsi', 'kabupaten', 'nama_sekolah', 'tahun_lulus'
        ]));

        $this->logAktivitas('Update Biodata', 'Peserta', $peserta->id, 'Memperbarui data profil dan biodata diri.');

        return back()->with('success', 'Biodata berhasil disimpan!');
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
            'foto' => 'nullable|image|max:5120',
            'rapor1.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor2.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor3.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor4.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor5.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor6.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'ijazah' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'personal_statement' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'study_plan' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'surat_rekomendasi_sekolah' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'motivasi_video' => 'nullable|url|max:500',
            'motivasi_video_tiktok' => 'nullable|url|max:500',
            'sertifikat.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'bukti_follow_ig_beasiswamncu' => 'nullable|image|max:5120',
            'bukti_follow_ig_mncu' => 'nullable|image|max:5120',
            'bukti_follow_tiktok_beasiswamncu' => 'nullable|image|max:5120',
            'bukti_follow_tiktok_mncu' => 'nullable|image|max:5120',
        ]);

        $peserta = Auth::user()->peserta;
        $berkas = \App\Models\Berkas::firstOrNew(['peserta_id' => $peserta->id]);

        // Field yang di-submit oleh form (dikirim sebagai hidden input "upload_field")
        // Jika tidak ada (backward-compat), proses semua.
        $uploadField = $request->input('upload_field');
        $raporFields = ['rapor1', 'rapor2', 'rapor3', 'rapor4', 'rapor5', 'rapor6'];
        $singleFields = [
            'foto', 'ijazah', 'personal_statement', 'study_plan', 'surat_rekomendasi_sekolah',
            'bukti_follow_ig_beasiswamncu', 'bukti_follow_ig_mncu', 'bukti_follow_tiktok_beasiswamncu', 'bukti_follow_tiktok_mncu'
        ];

        // --- Handle Link Video Motivasi ---
        if (!$uploadField || $uploadField === 'motivasi_video') {
            if ($request->filled('motivasi_video')) {
                $berkas->motivasi_video = $request->motivasi_video;
            }
            if ($request->filled('motivasi_video_tiktok')) {
                $berkas->motivasi_video_tiktok = $request->motivasi_video_tiktok;
            }
        }

        // --- Handle Single File Fields ---
        foreach ($singleFields as $field) {
            // Hanya proses jika tidak ada filter field ATAU field ini yang dipilih
            if ((!$uploadField || $uploadField === $field) && $request->hasFile($field)) {
                $path = $request->file($field)->store('berkas/' . $peserta->id, 'public');
                $berkas->$field = $path;
                $this->compressImage($path);
            }
        }

        // --- Handle Rapor (Array) ---
        foreach ($raporFields as $field) {
            if ((!$uploadField || $uploadField === $field) && $request->hasFile($field)) {
                $files = $request->file($field);
                $paths = [];
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $p = $file->store('berkas/' . $peserta->id . '/' . $field, 'public');
                        $paths[] = $p;
                        $this->compressImage($p);
                    }
                }
                else {
                    $p = $files->store('berkas/' . $peserta->id . '/' . $field, 'public');
                    $paths[] = $p;
                    $this->compressImage($p);
                }
                $berkas->$field = json_encode($paths);
            }
        }

        $berkas->save();

        // --- Handle Sertifikat ---
        $sertifikatCount = 0;
        if ((!$uploadField || $uploadField === 'sertifikat') && $request->hasFile('sertifikat')) {
            $files = $request->file('sertifikat');
            $sertifikatFiles = is_array($files) ? $files : [$files];
            foreach ($sertifikatFiles as $file) {
                $path = $file->store('sertifikat/' . $peserta->id, 'public');
                $this->compressImage($path);
                \App\Models\Sertifikat::create([
                    'peserta_id' => $peserta->id,
                    'nama' => 'Sertifikat ' . date('Y-m-d H:i:s'),
                    'file' => $path,
                    'tahun' => date('Y'),
                ]);
                $sertifikatCount++;
            }
        }

        // --- Log Aktivitas ---
        $uploaded = [];
        if ($request->hasFile('foto'))
            $uploaded[] = 'Pas Foto 4x6';
        if ($request->hasFile('ijazah'))
            $uploaded[] = 'Ijazah/SKL';
        if ($request->hasFile('personal_statement'))
            $uploaded[] = 'Personal Statement';
        if ($request->hasFile('study_plan'))
            $uploaded[] = 'Study Plan';
        if ($request->hasFile('surat_rekomendasi_sekolah'))
            $uploaded[] = 'Surat Rekomendasi Sekolah';
        if ($request->filled('motivasi_video'))
            $uploaded[] = 'Link Video Motivasi IG';
        if ($request->filled('motivasi_video_tiktok'))
            $uploaded[] = 'Link Video Motivasi TikTok';
        if ($request->hasFile('bukti_follow_ig_beasiswamncu'))
            $uploaded[] = 'Bukti Follow IG Beasiswa MNCU';
        if ($request->hasFile('bukti_follow_ig_mncu'))
            $uploaded[] = 'Bukti Follow IG MNC University';
        if ($request->hasFile('bukti_follow_tiktok_beasiswamncu'))
            $uploaded[] = 'Bukti Follow TikTok Beasiswa MNCU';
        if ($request->hasFile('bukti_follow_tiktok_mncu'))
            $uploaded[] = 'Bukti Follow TikTok MNC University';
        for ($i = 1; $i <= 6; $i++) {
            if ($request->hasFile('rapor' . $i))
                $uploaded[] = "Scan Rapor S$i";
        }
        if ($sertifikatCount > 0)
            $uploaded[] = "$sertifikatCount Sertifikat Prestasi";

        if (count($uploaded) > 0) {
            $desc = 'Berhasil memperbarui dokumen: ' . implode(', ', $uploaded);
            $this->logAktivitas('Pembaruan Berkas', 'Berkas', $berkas->id, $desc);
        }

        return redirect()->back()->with('success', 'Berkas berhasil disimpan!');
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
        
        // Ensure core subjects exist before querying them
        $coreSubjects = ['Bahasa Indonesia', 'Matematika Wajib', 'Bahasa Inggris'];
        foreach ($coreSubjects as $subjectName) {
            \App\Models\Matpel::firstOrCreate(['nama' => $subjectName]);
        }

        $matpels = \App\Models\Matpel::whereIn('nama', $coreSubjects)->get();
        // Fetch existing score
        $existingNilai = \App\Models\Nilai::where('peserta_id', $peserta->id)->get()->groupBy('matpel_id');

        // Also get custom matpels IDs that are NOT in the core list but have scores for this user
        $coreIds = $matpels->pluck('id')->toArray();
        $customNilaiBySemester = \App\Models\Nilai::with('matpel')
            ->where('peserta_id', $peserta->id)
            ->whereNotIn('matpel_id', $coreIds)
            ->get()
            ->groupBy('semester');

        $berkas = \App\Models\Berkas::where('peserta_id', $peserta->id)->first();

        return view('pendaftar.nilai', compact('peserta', 'matpels', 'existingNilai', 'customNilaiBySemester', 'berkas'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'pilihan_prodi' => 'required',
            'surat_buta_warna' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor1.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor2.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor3.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor4.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'rapor5.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $peserta = Auth::user()->peserta;
        $peserta->update(['pilihan_prodi' => $request->pilihan_prodi]);

        // Server-side validation for mandatory supporting subjects
        // Validasi: harus ada minimal 2 matpel pendukung yang diisi (nama & nilai) di seluruh semester
        $customCount = 0;
        if ($request->has('custom_matpel')) {
            foreach ($request->custom_matpel as $sem => $slots) {
                foreach ($slots as $slot) {
                    if (!empty($slot['nama']) && ($slot['nilai'] || $slot['nilai'] === '0')) {
                        $customCount++;
                    }
                }
            }
        }

        if ($customCount < 2) {
            return back()->withInput()->with('error', 'Anda wajib menambahkan minimal 2 Mata Pelajaran Pendukung.');
        }

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
            $this->compressImage($path);
        }

        // Handle Rapor Files Scans (Semester 1-5)
        for ($i = 1; $i <= 5; $i++) {
            $field = 'rapor' . $i;
            if ($request->hasFile($field)) {
                $files = $request->file($field);
                $paths = [];
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $p = $file->store('berkas/' . $peserta->id . '/' . $field, 'public');
                        $paths[] = $p;
                        $this->compressImage($p);
                    }
                }
                else {
                    $p = $files->store('berkas/' . $peserta->id . '/' . $field, 'public');
                    $paths[] = $p;
                    $this->compressImage($p);
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

        // Save Custom Subjects (2 per semester)
        if ($request->has('custom_matpel')) {
            $coreSubjects = ['Bahasa Indonesia', 'Matematika Wajib', 'Bahasa Inggris'];
            $coreIds = \App\Models\Matpel::whereIn('nama', $coreSubjects)->pluck('id')->toArray();
            
            // First, delete current custom scores to handle "overwriting" or clearing slots
            // Actually, better to only delete scores for custom matpels for THIS user
            \App\Models\Nilai::where('peserta_id', $peserta->id)
                ->whereNotIn('matpel_id', $coreIds)
                ->delete();

            foreach ($request->custom_matpel as $sem => $slots) {
                foreach ($slots as $slot) {
                    if (!empty($slot['nama']) && ($slot['nilai'] || $slot['nilai'] === '0')) {
                        // Create or Get Matpel
                        $matpel = \App\Models\Matpel::firstOrCreate(['nama' => $slot['nama']]);
                        \App\Models\Nilai::updateOrCreate(
                            ['peserta_id' => $peserta->id, 'matpel_id' => $matpel->id, 'semester' => $sem],
                            ['nilai' => $slot['nilai']]
                        );
                    }
                }
            }
        }

        $uploadedRapor = [];
        for ($i = 1; $i <= 5; $i++)
            if ($request->hasFile('rapor' . $i))
                $uploadedRapor[] = "Scan Rerata S$i";

        $msg = "Input nilai akademik semester 1-5" . (count($uploadedRapor) > 0 ? " dan unggah berkas " . implode(', ', $uploadedRapor) : "") . ". Pilihan Prodi: {$request->pilihan_prodi}.";

        $this->logAktivitas('Pengisian Nilai Rapor', 'Nilai', $peserta->id, $msg);

        return back()->with('success', 'Data akademik dan pilihan program studi berhasil disimpan!');
    }
}
