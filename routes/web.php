<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/', function () {
    $beritas = \App\Models\Berita::where('is_published', true)->orderBy('created_at', 'desc')->take(3)->get();
    
    // Live Counter Data
    $totalPendaftar = \App\Models\Akun::where('role', 'pendaftar')->count();
    
    // Asumsi ingin menambahkan efek 100 base data agar terlihat ramai di awal
    // $totalPendaftar += 100; // Un-comment jika ingin tambah data dummy
    
    // Dapatkan data agregat pendaftar berdasarkan kabupaten/kota
    $locationStats = \App\Models\Peserta::select('kabupaten', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                        ->whereNotNull('kabupaten')
                        ->groupBy('kabupaten')
                        ->orderByDesc('total')
                        ->take(5)
                        ->get()
                        ->map(function($p) {
                            return [
                                'total' => $p->total,
                                'lokasi' => $p->kabupaten,
                            ];
                        });

    return view('pendaftar.home', compact('beritas', 'totalPendaftar', 'locationStats'));
});

// Pengumuman Route (Public)
Route::get('/pengumuman', [PengumumanController::class , 'index'])->name('pengumuman');

// Rekomendasi Prodi (Quiz Matching)
Route::get('/rekomendasi-prodi', [\App\Http\Controllers\MatchingController::class, 'showQuiz'])->name('quiz.show');
Route::post('/rekomendasi-prodi', [\App\Http\Controllers\MatchingController::class, 'submit'])->name('quiz.submit');

// Berita Route (Public)
Route::get('/berita/{slug}', function ($slug) {
    $berita = \App\Models\Berita::where('slug', $slug)->firstOrFail();
    return view('pendaftar.berita_show', compact('berita'));
})->name('berita.show');

Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::get('/maintance', [AuthController::class , 'maintance'])->name('maintance');
Route::get('/register', [AuthController::class , 'showRegister'])->name('register');
Route::post('/register', [AuthController::class , 'register']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// OTP Verification Routes
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.post');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Internal / Staff Routes    
Route::get('/internal/login', [AuthController::class , 'showInternalLogin'])->name('internal.login');
Route::post('/internal/login', [AuthController::class , 'internalLogin']);

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // === ROLE: Admin, Panitia, Akademik, Mentor ===
    Route::middleware(['role:admin,panitia,akademik,mentor'])->group(function () {
            // Admin / Staff Dashboard
            Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class , 'dashboard'])->name('admin.dashboard');

            // Unified Seleksi Administrasi (Profil, Raport, Berkas)
            Route::prefix('admin/pendaftar')->name('admin.pendaftar.')->group(function () {
                    Route::get('/', [App\Http\Controllers\AdminController::class , 'indexPendaftar'])->name('index');
                    Route::get('/{id}', [App\Http\Controllers\AdminController::class , 'detailPendaftar'])->name('show');
                    Route::post('/{id}/verify', [App\Http\Controllers\AdminController::class , 'verifikasi'])->name('verify');
                    Route::get('/{id}/download-zip', [App\Http\Controllers\AdminController::class , 'downloadZip'])->name('download_zip');
                    Route::post('/{id}/upload-berkas', [App\Http\Controllers\AdminController::class , 'uploadBerkas'])->name('upload_berkas');
                    Route::post('/{id}/delete-berkas', [App\Http\Controllers\AdminController::class , 'deleteBerkas'])->name('delete_berkas');
                    Route::post('/{id}/mentor-nilai', [App\Http\Controllers\AdminController::class , 'storePenilaianMentor'])->name('mentor_nilai');
                    Route::delete('/{id}', [App\Http\Controllers\AdminController::class , 'destroyPendaftar'])->name('destroy');
                }
                );

                // Seleksi Beasiswa (Email Restricted)
                Route::middleware(['role:akademik,email:dion@gmail.com|info@beasiswamncu.com'])->group(function () {
                    Route::get('/admin/beasiswa', [App\Http\Controllers\AdminController::class , 'indexBeasiswa'])->name('admin.beasiswa.index');
                    Route::get('/admin/beasiswa/{id}', [App\Http\Controllers\AdminController::class , 'showBeasiswa'])->name('admin.beasiswa.show');
                    Route::post('/admin/beasiswa/{id}/update', [App\Http\Controllers\AdminController::class , 'updateBeasiswa'])->name('admin.beasiswa.update');
                }
                );

                Route::get('/admin/hasil-ujian', [App\Http\Controllers\AdminController::class , 'indexHasilUjian'])->name('admin.hasil_ujian.index');

                Route::get('/admin/penilaian-mentor', [App\Http\Controllers\AdminController::class , 'indexPenilaian'])->name('admin.penilaian.index');
                Route::get('/admin/penilaian-akademik', [App\Http\Controllers\AdminController::class , 'indexPenilaianAkademik'])->name('admin.penilaian.akademik.index');
                Route::get('/admin/penilaian-detail/{id}', [App\Http\Controllers\AdminController::class , 'showPenilaian'])->name('admin.penilaian.show');
                Route::post('/admin/penilaian-akademik/{id}', [App\Http\Controllers\AdminController::class , 'storePenilaianAkademik'])->name('admin.penilaian.akademik.store');

                Route::get('/admin/user', [App\Http\Controllers\AdminController::class , 'indexUser'])->name('admin.user.index');
                Route::post('/admin/user', [App\Http\Controllers\AdminController::class , 'storeUser'])->name('admin.user.store');
                Route::put('/admin/user/{id}', [App\Http\Controllers\AdminController::class , 'updateUser'])->name('admin.user.update');
                Route::put('/admin/user/{id}/reset-password', [App\Http\Controllers\AdminController::class , 'resetPassword'])->name('admin.user.reset_password');
                Route::delete('/admin/user/{id}', [App\Http\Controllers\AdminController::class , 'destroyUser'])->name('admin.user.destroy');

                // Manajemen Soal
                Route::get('/admin/soal', [App\Http\Controllers\AdminController::class , 'indexSoal'])->name('admin.soal.index');
                Route::post('/admin/soal', [App\Http\Controllers\AdminController::class , 'storeSoal'])->name('admin.soal.store');
                Route::get('/admin/soal/{id}/edit', [App\Http\Controllers\AdminController::class , 'editSoal'])->name('admin.soal.edit');
                Route::put('/admin/soal/{id}', [App\Http\Controllers\AdminController::class , 'updateSoal'])->name('admin.soal.update');
                Route::delete('/admin/soal/{id}', [App\Http\Controllers\AdminController::class , 'destroySoal'])->name('admin.soal.destroy');
                Route::post('/admin/soal/import', [App\Http\Controllers\AdminController::class , 'importSoal'])->name('admin.soal.import');

                // Manajemen Berita
                Route::middleware(['role:admin,panitia'])->group(function () {
                    Route::resource('admin/berita', \App\Http\Controllers\BeritaController::class , ['as' => 'admin']);
                }
                );

                Route::get('/admin/export', [App\Http\Controllers\AdminController::class , 'exportExcel'])->name('admin.export');
                
                // Certificate Generation Route
                Route::get('/admin/pendaftar/{id}/certificate', [App\Http\Controllers\AdminController::class, 'generateCertificate'])->name('admin.pendaftar.certificate');
                Route::post('/admin/pendaftar/{id}/send-certificate', [App\Http\Controllers\AdminController::class, 'sendCertificateEmail'])->name('admin.pendaftar.send_certificate');
            }
            );

            // === ROLE: Pendaftar ===
            Route::middleware(['role:pendaftar'])->group(function () {
            Route::prefix('pendaftar')->group(function () {
                    Route::get('/dashboard', [PendaftarController::class , 'index'])->name('pendaftar.dashboard');
                    Route::get('/biodata', [PendaftarController::class , 'biodata'])->name('pendaftar.biodata');
                    Route::post('/biodata', [PendaftarController::class , 'storeBiodata'])->name('pendaftar.biodata.store');
                    Route::get('/berkas', [PendaftarController::class , 'berkas'])->name('pendaftar.berkas');
                    Route::post('/berkas', [PendaftarController::class , 'storeBerkas'])->name('pendaftar.berkas.store');
                    Route::get('/twibbon', [PendaftarController::class , 'twibbon'])->name('pendaftar.twibbon');
                    Route::post('/twibbon', [PendaftarController::class , 'storeTwibbon'])->name('pendaftar.twibbon.store');
                    Route::get('/nilai', [PendaftarController::class , 'nilai'])->name('pendaftar.nilai');
                    Route::post('/nilai', [PendaftarController::class , 'storeNilai'])->name('pendaftar.nilai.store');
                    
                    // File Deletion Routes
                    Route::post('/berkas/delete-file', [PendaftarController::class, 'deleteFile'])->name('pendaftar.berkas.delete_file');
                    Route::post('/berkas/delete-sertifikat/{id}', [PendaftarController::class, 'destroySertifikat'])->name('pendaftar.sertifikat.destroy');

                    // Email Change Routes
                    Route::get('/change-email', [PendaftarController::class, 'showChangeEmail'])->name('pendaftar.email.change');
                    Route::post('/change-email/request', [PendaftarController::class, 'requestEmailChange'])->name('pendaftar.email.request');
                    Route::get('/change-email/verify', [PendaftarController::class, 'showVerifyEmailChange'])->name('pendaftar.email.verify');
                    Route::post('/change-email/verify', [PendaftarController::class, 'verifyEmailChange'])->name('pendaftar.email.verify.post');
                }
                );
            }
            );
        });
