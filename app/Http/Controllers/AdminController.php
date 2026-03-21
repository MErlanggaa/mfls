<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Daftar;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use \App\Traits\ImageCompressor;

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
        }
        elseif ($todayPendaftar > 0) {
            $growth = 100;
        }

        // Daily trend (last 7 days)
        $dailyTrend = Akun::where('role', 'pendaftar')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(6))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Website Analytics
        $totalViews = \App\Models\PageView::count();
        $todayViews = \App\Models\PageView::whereDate('viewed_at', \Carbon\Carbon::today())->count();
        $yesterdayViews = \App\Models\PageView::whereDate('viewed_at', \Carbon\Carbon::yesterday())->count();
        
        // Views growth
        $viewsGrowth = 0;
        if ($yesterdayViews > 0) {
            $viewsGrowth = (($todayViews - $yesterdayViews) / $yesterdayViews) * 100;
        } elseif ($todayViews > 0) {
            $viewsGrowth = 100;
        }
        
        // Daily views trend (last 7 days)
        $dailyViewsTrend = \App\Models\PageView::where('viewed_at', '>=', \Carbon\Carbon::now()->subDays(6))
            ->select(DB::raw('DATE(viewed_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        
        // Top pages
        $topPages = \App\Models\PageView::select('url', DB::raw('count(*) as views'))
            ->groupBy('url')
            ->orderBy('views', 'DESC')
            ->limit(5)
            ->get();
        
        // Unique visitors today
        $uniqueVisitorsToday = \App\Models\PageView::whereDate('viewed_at', \Carbon\Carbon::today())
            ->distinct('ip_address')
            ->count('ip_address');

        return view('admin.dashboard', compact(
            'riwayats', 
            'totalPendaftar', 
            'todayPendaftar', 
            'growth', 
            'dailyTrend',
            'totalViews',
            'todayViews',
            'viewsGrowth',
            'dailyViewsTrend',
            'topPages',
            'uniqueVisitorsToday'
        ));
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
        if (auth()->user()->role === 'mentor')
            return abort(403);

        $query = Akun::where('role', 'pendaftar')
            ->with(['peserta.daftar', 'peserta.nilais', 'peserta.berkas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('peserta.daftar', function ($q2) use ($search) {
                    $q2->where('asal_sekolah', 'like', "%{$search}%")
                        ->orWhere('kode_referral', 'like', "%{$search}%");
                }
                );
            });
        }

        if ($request->filled('filter_nilai')) {
            $query->whereHas('peserta.daftar', function ($q) use ($request) {
                $q->where('rata_rata_nilai', '>=', $request->filter_nilai);
            });
        }

        // Sorting Logic
        if ($request->get('sort') === 'nilai_high') {
            $query->join('peserta', 'akun.id', '=', 'peserta.akun_id')
                ->join('daftar', 'peserta.id', '=', 'daftar.peserta_id')
                ->orderBy('daftar.rata_rata_nilai', 'desc')
                ->select('akun.*');
        }
        elseif ($request->get('sort') === 'nilai_low') {
            $query->join('peserta', 'akun.id', '=', 'peserta.akun_id')
                ->join('daftar', 'peserta.id', '=', 'daftar.peserta_id')
                ->orderBy('daftar.rata_rata_nilai', 'asc')
                ->select('akun.*');
        }
        else {
            $query->latest();
        }

        $pendaftars = $query->get();

        // Auto-sync rata-rata nilai per semester dan keseluruhan
        // (Keep the sync logic but maybe limit it or optimize if needed)
        foreach ($pendaftars as $akun) {
            if ($akun->peserta && $akun->peserta->daftar) {
                $daftar = $akun->peserta->daftar;
                $nilais = $akun->peserta->nilais;

                $updateData = [];
                for ($sem = 1; $sem <= 6; $sem++) {
                    $avgSem = $nilais->where('semester', $sem)->avg('nilai') ?? 0;
                    $updateData["avg_semester_{$sem}"] = round($avgSem, 2);
                }

                $realAvg = $nilais->avg('nilai') ?? 0;
                $updateData['rata_rata_nilai'] = round($realAvg, 2);
                $daftar->update($updateData);
            }
        }

        // Urutkan berdasarkan nilai rata-rata dari tertinggi ke terendah
        $pendaftars = $pendaftars->sortByDesc(function ($akun) {
            return $akun->peserta && $akun->peserta->daftar
            ? $akun->peserta->daftar->rata_rata_nilai
            : 0;
        });

        return view('admin.pendaftar.index', compact('pendaftars'));
    }

    // --- SISTEM DATABASE TERPUSAT: BEASISWA ---
    public function indexBeasiswa(Request $request)
    {
        if (auth()->user()->role === 'mentor')
            return abort(403);

        $query = Akun::where('role', 'pendaftar')
            ->whereHas('peserta.daftar', function ($q) {
            $q->where('status', 'lulus');
        })
            ->with(['peserta.daftar', 'peserta.nilais', 'peserta.berkas', 'peserta.penilaianMentors.mentor', 'peserta.jawabanUjians.ujian']);

        // filters ...
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('peserta.daftar', function ($q2) use ($search) {
                    $q2->where('asal_sekolah', 'like', "%{$search}%")
                        ->orWhere('kode_referral', 'like', "%{$search}%");
                }
                );
            });
        }

        if ($request->filled('sekolah')) {
            $query->whereHas('peserta.daftar', function ($q) use ($request) {
                $q->where('asal_sekolah', 'like', "%{$request->sekolah}%");
            });
        }

        if ($request->filled('min_nilai')) {
            $query->whereHas('peserta.daftar', function ($q) use ($request) {
                $q->where('rata_rata_nilai', '>=', $request->min_nilai);
            });
        }

        $pendaftars = $query->get();

        // Urutkan berdasarkan nilai rata-rata dari tertinggi ke terendah
        $pendaftars = $pendaftars->sortByDesc(function ($akun) {
            return $akun->peserta && $akun->peserta->daftar
            ? $akun->peserta->daftar->rata_rata_nilai
            : 0;
        });

        return view('admin.beasiswa.index', compact('pendaftars'));
    }

    public function showBeasiswa($id)
    {
        if (auth()->user()->role === 'mentor')
            return abort(403);

        $user = Akun::with([
            'peserta.daftar',
            'peserta.berkas',
            'peserta.nilais.matpel',
            'peserta.penilaianMentors.mentor',
            'peserta.penilaianAkademiks.penilai',
            'peserta.nilaiUjians.ujian'
        ])->findOrFail($id);

        $rataRataAkademik = $user->peserta->nilais->avg('nilai') ?? 0;
        $rataRataMentor = $user->peserta->penilaianMentors->avg('nilai') ?? 0;
        $rataRataAkademikFinal = $user->peserta->penilaianAkademiks->avg('total_nilai') ?? 0;

        return view('admin.beasiswa.show', compact('user', 'rataRataAkademik', 'rataRataMentor', 'rataRataAkademikFinal'));
    }

    public function updateBeasiswa(Request $request, $id)
    {
        $request->validate([
            'nominal_beasiswa' => 'nullable|string|max:255',
            'status' => 'required|in:lulus,tidak_lulus,menunggu'
        ]);

        $daftar = Daftar::where('peserta_id', function ($query) use ($id) {
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
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'akademik')
            return abort(403);

        $hasilUjians = \App\Models\JawabanUjian::with(['peserta.akun', 'ujian'])
            ->latest()
            ->get();

        return view('admin.hasil_ujian.index', compact('hasilUjians'));
    }

    // --- DATA PENDAFTAR: PENILAIAN MENTOR ---
    public function indexPenilaian(Request $request)
    {
        if (auth()->user()->role !== 'mentor' && auth()->user()->role !== 'admin')
            return abort(403);

        $query = Akun::where('role', 'pendaftar')
            ->whereHas('peserta.daftar', function ($q) {
            $q->where('status', 'lulus');
        })
            ->with(['peserta.daftar', 'peserta.penilaianMentors']);

        return $this->processPenilaianIndex($query, $request, 'mentor');
    }

    // --- DATA PENDAFTAR: PENILAIAN AKADEMIK ---
    public function indexPenilaianAkademik(Request $request)
    {
        if (auth()->user()->role !== 'akademik' && auth()->user()->role !== 'admin' && auth()->user()->role !== 'mentor')
            return abort(403);

        $query = Akun::where('role', 'pendaftar')
            ->whereHas('peserta.daftar', function ($q) {
            $q->where('status', 'lulus');
        })
            ->with(['peserta.daftar', 'peserta.penilaianAkademiks']);

        return $this->processPenilaianIndex($query, $request, 'akademik');
    }

    private function processPenilaianIndex($query, $request, $type)
    {

        // Search logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhereHas('peserta', function ($pq) use ($search) {
                    $pq->where('nama_sekolah', 'LIKE', "%{$search}%")
                        ->orWhere('kabupaten', 'LIKE', "%{$search}%")
                        ->orWhere('provinsi', 'LIKE', "%{$search}%");
                }
                );
            });
        }

        // Sorting logic
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        if ($sort == 'nama') {
            $query->orderBy('nama', $order);
        }
        elseif (in_array($sort, ['sekolah', 'kabupaten', 'kota'])) {
            $field = [
                'sekolah' => 'nama_sekolah',
                'kabupaten' => 'kabupaten',
                'kota' => 'provinsi'
            ][$sort];

            $query->join('peserta', 'akun.id', '=', 'peserta.akun_id')
                ->orderBy('peserta.' . $field, $order)
                ->select('akun.*');
        }
        else {
            $query->latest();
        }

        $pendaftars = $query->get();

        return view('admin.penilaian.index', compact('pendaftars', 'type'));
    }

    public function showPenilaian($id, Request $request)
    {
        if (auth()->user()->role !== 'mentor' && auth()->user()->role !== 'admin' && auth()->user()->role !== 'akademik')
            return abort(403);

        $type = $request->get('type', 'mentor'); // Default to mentor if not specified
        $user = Akun::with(['peserta.daftar', 'peserta.penilaianMentors.mentor', 'peserta.penilaianAkademiks.penilai'])->findOrFail($id);

        return view('admin.penilaian.show', compact('user', 'type'));
    }

    public function storePenilaianAkademik(Request $request, $id)
    {
        if (auth()->user()->role !== 'akademik' && auth()->user()->role !== 'admin' && auth()->user()->role !== 'mentor') {
            return back()->with('loginError', 'Hanya bagian Akademik dan Mentor yang dapat memberikan penilaian ini.');
        }

        $request->validate([
            'dosen_kompetensi' => 'required|numeric|min:0|max:100',
            'dosen_motivasi' => 'required|numeric|min:0|max:100',
            'dosen_wawasan' => 'required|numeric|min:0|max:100',
            'dosen_karir' => 'required|numeric|min:0|max:100',
            'dosen_integritas' => 'required|numeric|min:0|max:100',

            'mhs_leadership' => 'required|numeric|min:0|max:100',
            'mhs_organisasi' => 'required|numeric|min:0|max:100',
            'mhs_etika' => 'required|numeric|min:0|max:100',
            'mhs_adaptasi' => 'required|numeric|min:0|max:100',
            'mhs_komitmen' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        $peserta = \App\Models\Peserta::where('akun_id', $id)->firstOrFail();

        $totalDosen = ($request->dosen_kompetensi + $request->dosen_motivasi + $request->dosen_wawasan +
            $request->dosen_karir + $request->dosen_integritas) / 5;

        $totalMhs = ($request->mhs_leadership + $request->mhs_organisasi + $request->mhs_etika +
            $request->mhs_adaptasi + $request->mhs_komitmen) / 5;

        $totalAkhir = ($totalDosen + $totalMhs) / 2;

        \App\Models\PenilaianAkademik::updateOrCreate(
        ['peserta_id' => $peserta->id, 'penilai_id' => auth()->id()],
        [
            'dosen_kompetensi' => $request->dosen_kompetensi,
            'dosen_motivasi' => $request->dosen_motivasi,
            'dosen_wawasan' => $request->dosen_wawasan,
            'dosen_karir' => $request->dosen_karir,
            'dosen_integritas' => $request->dosen_integritas,
            'total_dosen' => round($totalDosen, 2),

            'mhs_leadership' => $request->mhs_leadership,
            'mhs_organisasi' => $request->mhs_organisasi,
            'mhs_etika' => $request->mhs_etika,
            'mhs_adaptasi' => $request->mhs_adaptasi,
            'mhs_komitmen' => $request->mhs_komitmen,
            'total_mhs' => round($totalMhs, 2),

            'total_akhir' => round($totalAkhir, 2),
            'catatan' => $request->catatan,
        ]
        );

        $this->logAktivitas('Input Penilaian Akademik', 'Peserta', $peserta->id, "Memberikan penilaian akademik untuk {$peserta->nama}");

        return back()->with('success', 'Penilaian akademik berhasil disimpan!');
    }

    // --- PENGATURAN: MANAJEMEN USER ---
    public function indexUser()
    {
        if (auth()->user()->role !== 'admin')
            return abort(403);
        $users = Akun::where('role', '!=', 'pendaftar')->withCount('peserta')->get();
        return view('admin.user.index', compact('users'));
    }

    public function destroyPendaftar($id)
    {
        $user = auth()->user();
        if ($user->role !== 'admin' && !in_array($user->email, ['dept.adminis@mfls.com', 'info@beasiswamncu.com']))
            return abort(403);

        $akun = Akun::with('peserta.berkas')->findOrFail($id);

        // Pastikan yang dihapus hanya pendaftar
        if ($akun->role !== 'pendaftar') {
            return back()->with('error', 'Hanya akun pendaftar yang dapat dihapus melalui fitur ini.');
        }

        // Hapus file-file berkas fisik jika ada
        if ($akun->peserta && $akun->peserta->berkas) {
            $berkas = $akun->peserta->berkas;
            $filesToDelete = [
                $berkas->foto,
                $berkas->ijazah,
                $berkas->surat_buta_warna,
                $berkas->surat_rekomendasi_sekolah,
                $berkas->motivasi_video, // asumsikan video ada yang diupload juga walau db bilang text URL
                $berkas->personal_statement,
                $berkas->study_plan
            ];

            // Hapus rapor JSON
            for ($i = 1; $i <= 5; $i++) {
                $field = "rapor$i";
                if ($berkas->$field) {
                    $raporFiles = json_decode($berkas->$field, true);
                    if (is_array($raporFiles)) {
                        $filesToDelete = array_merge($filesToDelete, $raporFiles);
                    }
                    else {
                        $filesToDelete[] = $berkas->$field;
                    }
                }
            }

            foreach ($filesToDelete as $file) {
                if ($file && \Illuminate\Support\Facades\Storage::disk('public')->exists($file)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($file);
                }
            }
        }

        $this->logAktivitas('Hapus Pendaftar', 'Akun', $id, "Menghapus akun pendaftar beserta data dan berkasnya: " . $akun->nama);

        // Data peserta, berkas, daftar, nilai, dll otomatis terhapus jika di migration ada implementasi onDelete('cascade')
        // Kalau tidak, delete instancenya terlebih dahulu via Eloquent dipastikan berjalan saat akun dihapus berantai.
        // Kita paksa hapus manual jika tidak cascade
        if ($akun->peserta) {
            $akun->peserta->delete();
        }
        $akun->delete();

        return back()->with('success', 'Akun pendaftar beserta data dan berkas berhasil dihapus!');
    }

    public function storeUser(Request $request)
    {
        if (auth()->user()->role !== 'admin')
            return abort(403);
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:akun,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,panitia,akademik,mentor'
        ]);

        Akun::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin')
            return abort(403);
        $user = Akun::findOrFail($id);

        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:akun,email,' . $id,
            'role' => 'required|in:admin,panitia,akademik,mentor'
        ];

        if ($request->password) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        if (auth()->user()->role !== 'admin')
            return abort(403);
        $user = Akun::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    public function resetPassword(Request $request, $id)
    {
        $authUser = auth()->user();
        if ($authUser->role !== 'admin' && !in_array($authUser->email, ['dept.adminis@mfls.com', 'info@beasiswamncu.com']))
            return abort(403);
        $user = Akun::findOrFail($id);

        $request->validate([
            'password' => 'required|min:6'
        ]);

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password user ' . $user->nama . ' berhasil direset!');
    }

    public function detailPendaftar($id)
    {
        $user = Akun::with(['peserta.daftar', 'peserta.berkas', 'peserta.nilais.matpel'])->findOrFail($id);
        return view('admin.pendaftar.show', compact('user'));
    }


    public function indexSoal(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'akademik'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke Bank Soal.');
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
        if (!in_array(auth()->user()->role, ['admin', 'akademik']))
            return abort(403);
        $request->validate([
            'ujian_id' => 'required|exists:ujian,id',
            'pertanyaan' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'opsi_a' => 'required',
            'opsi_a_image' => 'nullable|image|max:2048',
            'opsi_b' => 'required',
            'opsi_b_image' => 'nullable|image|max:2048',
            'opsi_c' => 'required',
            'opsi_c_image' => 'nullable|image|max:2048',
            'opsi_d' => 'required',
            'opsi_d_image' => 'nullable|image|max:2048',
            'kunci_jawaban' => 'required|in:a,b,c,d',
            'bobot' => 'required|integer'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('soal_images', 'public');
            $data['gambar'] = $path;
            $this->compressImage($path);
        }

        // Handle option images
        foreach (['a', 'b', 'c', 'd'] as $option) {
            $fieldName = "opsi_{$option}_image";
            if ($request->hasFile($fieldName)) {
                $path = $request->file($fieldName)->store('soal_images', 'public');
                $data[$fieldName] = $path;
                $this->compressImage($path);
            }
        }

        \App\Models\Soal::create($data);
        $this->logAktivitas('Tambah Soal', 'Soal', null, "Menambahkan soal baru ke kategori ID: " . $data['ujian_id']);

        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function editSoal($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'akademik']))
            return abort(403);
        $soal = \App\Models\Soal::findOrFail($id);
        $ujians = \App\Models\Ujian::all();
        return view('admin.soal.edit', compact('soal', 'ujians'));
    }

    public function updateSoal(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'akademik']))
            return abort(403);
        $request->validate([
            'ujian_id' => 'required|exists:ujian,id',
            'pertanyaan' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'opsi_a' => 'required',
            'opsi_a_image' => 'nullable|image|max:2048',
            'opsi_b' => 'required',
            'opsi_b_image' => 'nullable|image|max:2048',
            'opsi_c' => 'required',
            'opsi_c_image' => 'nullable|image|max:2048',
            'opsi_d' => 'required',
            'opsi_d_image' => 'nullable|image|max:2048',
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
            $path = $request->file('gambar')->store('soal_images', 'public');
            $data['gambar'] = $path;
            $this->compressImage($path);
        }

        // Handle option images
        foreach (['a', 'b', 'c', 'd'] as $option) {
            $fieldName = "opsi_{$option}_image";
            if ($request->hasFile($fieldName)) {
                // Delete old image if exists
                if ($soal->$fieldName) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($soal->$fieldName);
                }
                $path = $request->file($fieldName)->store('soal_images', 'public');
                $data[$fieldName] = $path;
                $this->compressImage($path);
            }
        }

        $soal->update($data);

        return redirect()->route('admin.soal.index', ['ujian_id' => $soal->ujian_id])->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroySoal($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'akademik']))
            return abort(403);
        $soal = \App\Models\Soal::findOrFail($id);

        // Delete main question image
        if ($soal->gambar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($soal->gambar);
        }

        // Delete option images
        foreach (['a', 'b', 'c', 'd'] as $option) {
            $fieldName = "opsi_{$option}_image";
            if ($soal->$fieldName) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($soal->$fieldName);
            }
        }

        $this->logAktivitas('Hapus Soal', 'Soal', $id, "Menghapus soal: " . substr($soal->pertanyaan, 0, 30));
        $soal->delete();

        return back()->with('success', 'Soal berhasil dihapus!');
    }

    public function importSoal(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'akademik']))
            return abort(403);
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
            if (count($row) >= 7) {
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
        }
        else {
            return back()->with('error', 'Gagal membaca file Word.');
        }

        // Parsing XML sederhana
        $dom = new \DOMDocument();
        $dom->loadXML($xmlContent);
        $paragraphs = $dom->getElementsByTagName('p'); // Paragraph tag in Word XML

        $currentSoal = [];

        foreach ($paragraphs as $p) {
            $text = $p->textContent;
            $text = trim($text);
            if (empty($text))
                continue;

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
            return back()->with('error', 'Mentor tidak memiliki izin verifikasi kelulusan.');
        }

        $daftar = Daftar::where('peserta_id', function ($query) use ($id) {
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
            }
            catch (\Exception $e) {
                // Log error email tapi jangan hentikan proses
                \Illuminate\Support\Facades\Log::error("Gagal kirim email ujian: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Status kelulusan berhasil diperbarui!');
    }

    public function updateNilaiDummy(Request $request, $id)
    {
        // Ini method helper untuk testing update nilai rata-rata
        $daftar = Daftar::where('peserta_id', function ($query) use ($id) {
            $query->select('id')->from('peserta')->where('akun_id', $id);
        })->firstOrFail();

        $daftar->update(['rata_rata_nilai' => $request->nilai]);
        return back();
    }

    public function downloadZip($id)
    {
        $user = Akun::with(['peserta.berkas', 'peserta.sertifikats'])->findOrFail($id);
        $peserta = $user->peserta;

        if (!$peserta) {
            return back()->with('error', 'Data peserta tidak ditemukan.');
        }

        $berkas = $peserta->berkas;

        $zipName = 'Dokumen_' . str_replace(' ', '_', $user->nama) . '.zip';
        $zipPath = storage_path('app/public/temp/' . $zipName);

        // Ensure temp directory exists
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

            // Add Main Berkas
            if ($berkas) {
                $fields = [
                    'foto' => 'Pas_Foto',
                    'rapor1' => 'Rapor_S1',
                    'rapor2' => 'Rapor_S2',
                    'rapor3' => 'Rapor_S3',
                    'rapor4' => 'Rapor_S4',
                    'rapor5' => 'Rapor_S5',
                    'ijazah' => 'Ijazah',
                    'personal_statement' => 'Essay_Motivasi',
                    'study_plan' => 'Study_Plan',
                    'surat_rekomendasi_sekolah' => 'Surat_Rekomendasi_Sekolah'
                ];

                foreach ($fields as $field => $name) {
                    if ($berkas->$field) {
                        $val = $berkas->$field;
                        $decoded = json_decode($val, true);

                        if (is_array($decoded)) {
                            foreach ($decoded as $idx => $path) {
                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                                    $zip->addFile(storage_path('app/public/' . $path), $name . '_' . ($idx + 1) . '.' . $ext);
                                }
                            }
                        }
                        else {
                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($val)) {
                                $ext = pathinfo($val, PATHINFO_EXTENSION);
                                $zip->addFile(storage_path('app/public/' . $val), $name . '.' . $ext);
                            }
                        }
                    }
                }
            }

            // Add Sertifikats
            if ($peserta->sertifikats) {
                foreach ($peserta->sertifikats as $index => $sertifikat) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($sertifikat->file)) {
                        $ext = pathinfo($sertifikat->file, PATHINFO_EXTENSION);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $sertifikat->nama);
                        $zip->addFile(storage_path('app/public/' . $sertifikat->file), 'Sertifikat_' . $safeName . '_' . ($index + 1) . '.' . $ext);
                    }
                }
            }

            $zip->close();

            if (file_exists($zipPath)) {
                return response()->download($zipPath)->deleteFileAfterSend(true);
            }
            else {
                return back()->with('error', 'Gagal membuat file ZIP (File kosong).');
            }
        }
        else {
            return back()->with('error', 'Gagal membuka file ZIP.');
        }
    }

    public function exportExcel()
    {
        $fileName = 'Database_Seleksi_Administrasi_' . date('Y-m-d_H-i') . '.csv';
        $pendaftars = Akun::where('role', 'pendaftar')
            ->with(['peserta.daftar', 'peserta.nilais.matpel', 'peserta.berkas'])
            ->get();

        // 1. Definisikan Mapel Core & Cari Mapel Tambahan yang ada nilainya
        $coreNames = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Informatika'];
        $coreMatpels = \App\Models\Matpel::whereIn('nama', $coreNames)->get()->sortBy(function ($m) use ($coreNames) {
            return array_search($m->nama, $coreNames);
        });

        $allUsedMatpelIds = \App\Models\Nilai::whereIn('peserta_id', $pendaftars->pluck('peserta.id'))->pluck('matpel_id')->unique();
        $additionalMatpels = \App\Models\Matpel::whereIn('id', $allUsedMatpelIds)
            ->whereNotIn('nama', $coreNames)
            ->get();

        $orderedMatpels = $coreMatpels->concat($additionalMatpels);

        // 2. Definisikan Column Headers
        $columns = [
            'Nama Lengkap', 'Email', 'Nomor HP', 'NISN', 'Asal Sekolah', 'Prodi Minat',
            'Kode Referral'
        ];

        // Detail Semester 1-5 sesuai request "nilai S1 apa aja terus ada avgnya"
        for ($sem = 1; $sem <= 5; $sem++) {
            foreach ($orderedMatpels as $mp) {
                $columns[] = "S{$sem} - {$mp->nama}";
            }
            $columns[] = "Rata Rata S{$sem}";
        }

        $columns[] = "TOTAL NILAI (S1-S5)";
        $columns[] = "RATA RATA AKADEMIK (S1-S5)";

        // Data Berkas & Links
        $columns = array_merge($columns, [
            'FOTO', 'RAPOR S1', 'RAPOR S2', 'RAPOR S3', 'RAPOR S4', 'RAPOR S5',
            'IJAZAH', 'PERSONAL STATEMENT', 'SURAT BUTA WARNA (DKV)',
            'LINK VIDEO', 'LINK TWIBBON', 'LINK IG', 'LINK TIKTOK'
        ]);

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($pendaftars, $columns, $orderedMatpels) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($pendaftars as $user) {
                if (!$user->peserta)
                    continue;

                $peserta = $user->peserta;
                $daftar = $peserta->daftar;
                $berkas = $peserta->berkas;
                $nilais = $peserta->nilais;

                // A. Data Identitas
                $row = [
                    $user->nama,
                    $user->email,
                    $peserta->no_whatsapp ?: ($daftar->no_wa ?: '-'),
                    $peserta->nisn ?? '-',
                    $daftar->asal_sekolah ?? '-',
                    $peserta->pilihan_prodi ?? '-',
                    $daftar->kode_referral ?? '-',
                ];

                // B. Data Akademik Rinci (S1-S5)
                $grandTotalAcademic = 0;
                $totalMatpelCount = 0;

                for ($sem = 1; $sem <= 5; $sem++) {
                    $semSum = 0;
                    $semCount = 0;

                    foreach ($orderedMatpels as $mp) {
                        $nilaiObj = $nilais->where('semester', $sem)->where('matpel_id', $mp->id)->first();
                        $val = $nilaiObj ? $nilaiObj->nilai : 0;

                        $row[] = $val > 0 ? $val : '-';

                        if ($val > 0) {
                            $semSum += $val;
                            $semCount++;
                            $grandTotalAcademic += $val;
                            $totalMatpelCount++;
                        }
                    }
                    // AVG Per Semester (Sesuai perhitungan di Web Dashboard)
                    $row[] = $semCount > 0 ? number_format($semSum / $semCount, 2) : '0';
                }

                // C. Summary Akhir S1-S5
                $row[] = number_format($grandTotalAcademic, 2);
                $row[] = $totalMatpelCount > 0 ? number_format($grandTotalAcademic / $totalMatpelCount, 2) : '0';

                // D. Link Berkas
                $row[] = ($berkas && $berkas->foto) ? url('storage/' . $berkas->foto) : '-';
                for ($s = 1; $s <= 5; $s++) {
                    $field = "rapor{$s}";
                    $row[] = ($berkas && $berkas->$field) ? url('storage/' . $berkas->$field) : '-';
                }
                $row[] = ($berkas && $berkas->ijazah) ? url('storage/' . $berkas->ijazah) : '-';
                $row[] = ($berkas && $berkas->personal_statement) ? url('storage/' . $berkas->personal_statement) : '-';

                // Khusus DKV: Surat Buta Warna
                if (($peserta->pilihan_prodi ?? '') == 'Desain Komunikasi Visual') {
                    $row[] = ($berkas && $berkas->surat_buta_warna) ? url('storage/' . $berkas->surat_buta_warna) : 'BELUM UNGGAH';
                }
                else {
                    $row[] = 'N/A';
                }

                // E. Media Links
                $row[] = ($berkas && $berkas->motivasi_video) ? $berkas->motivasi_video : '-';
                $row[] = $peserta->link_twibbon ?? '-';
                $row[] = $peserta->link_ig ?? '-';
                $row[] = $peserta->link_tiktok ?? '-';

                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
