<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/', function () {
    $beritas = \App\Models\Berita::where('is_published', true)->orderBy('created_at', 'desc')->take(3)->get();
    return view('pendaftar.home', compact('beritas'));
});

// Pengumuman Route (Public)
Route::get('/pengumuman', [PengumumanController::class , 'index'])->name('pengumuman');

// Berita Route (Public)
Route::get('/berita/{slug}', function ($slug) {
    $berita = \App\Models\Berita::where('slug', $slug)->firstOrFail();
    return view('pendaftar.berita_show', compact('berita'));
})->name('berita.show');

Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::get('/maintance', [AuthController::class , 'maintance'])->name('maintance');
Route::get('/registertesting', [AuthController::class , 'showRegister'])->name('register');
Route::post('/registertesting', [AuthController::class , 'register']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

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
                    Route::post('/{id}/mentor-nilai', [App\Http\Controllers\AdminController::class , 'storePenilaianMentor'])->name('mentor_nilai');
                    Route::delete('/{id}', [App\Http\Controllers\AdminController::class , 'destroyPendaftar'])->name('destroy');
                }
                );

                // Seleksi Beasiswa (Email Restricted)
                Route::middleware(['role:email:dion@gmail.com|admin@mfls.com'])->group(function () {
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

                // Manajemen Berita (Email Restricted)
                Route::middleware(['role:email:dion@gmail.com|adminis@mfls.com|admin@mfls.com'])->group(function () {
                    Route::resource('admin/berita', \App\Http\Controllers\BeritaController::class , ['as' => 'admin']);
                }
                );

                Route::get('/admin/export', [App\Http\Controllers\AdminController::class , 'exportExcel'])->name('admin.export');
            }
            );

            // === ROLE: Pendaftar ===
            Route::middleware(['role:pendaftar'])->group(function () {
            Route::prefix('pendaftar')->group(function () {
                    Route::get('/dashboard', [PendaftarController::class , 'index'])->name('pendaftar.dashboard');
                    Route::get('/biodata', [PendaftarController::class , 'biodata'])->name('pendaftar.biodata');
                    Route::get('/berkas', [PendaftarController::class , 'berkas'])->name('pendaftar.berkas');
                    Route::post('/berkas', [PendaftarController::class , 'storeBerkas'])->name('pendaftar.berkas.store');
                    Route::get('/twibbon', [PendaftarController::class , 'twibbon'])->name('pendaftar.twibbon');
                    Route::post('/twibbon', [PendaftarController::class , 'storeTwibbon'])->name('pendaftar.twibbon.store');
                    Route::get('/nilai', [PendaftarController::class , 'nilai'])->name('pendaftar.nilai');
                    Route::post('/nilai', [PendaftarController::class , 'storeNilai'])->name('pendaftar.nilai.store');
                }
                );
            }
            );
        });
