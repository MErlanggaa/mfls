<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/', function () {
    return view('pendaftar.home');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Internal / Staff Routes
Route::get('/internal/login', [AuthController::class, 'showInternalLogin'])->name('internal.login');
Route::post('/internal/login', [AuthController::class, 'internalLogin']);

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Admin / Staff Dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    Route::prefix('admin/pendaftar')->name('admin.pendaftar.')->group(function() {
        Route::get('/', [App\Http\Controllers\AdminController::class, 'indexPendaftar'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\AdminController::class, 'detailPendaftar'])->name('show');
        Route::post('/{id}/verify', [App\Http\Controllers\AdminController::class, 'verifikasi'])->name('verify');
        Route::post('/{id}/update-nilai', [App\Http\Controllers\AdminController::class, 'updateNilaiDummy'])->name('update_nilai'); 
    });

    // Manajemen Soal
    Route::get('/admin/soal', [App\Http\Controllers\AdminController::class, 'indexSoal'])->name('admin.soal.index');
    Route::post('/admin/soal', [App\Http\Controllers\AdminController::class, 'storeSoal'])->name('admin.soal.store');
    Route::get('/admin/soal/{id}/edit', [App\Http\Controllers\AdminController::class, 'editSoal'])->name('admin.soal.edit');
    Route::put('/admin/soal/{id}', [App\Http\Controllers\AdminController::class, 'updateSoal'])->name('admin.soal.update');
    Route::delete('/admin/soal/{id}', [App\Http\Controllers\AdminController::class, 'destroySoal'])->name('admin.soal.destroy');
    Route::post('/admin/soal/import', [App\Http\Controllers\AdminController::class, 'importSoal'])->name('admin.soal.import');

    Route::get('/admin/export', [App\Http\Controllers\AdminController::class, 'exportExcel'])->name('admin.export');
    
    Route::get('/survey', [SurveyController::class, 'show']);
    Route::post('/survey', [SurveyController::class, 'store']);

    Route::prefix('pendaftar')->group(function () {
        Route::get('/dashboard', [PendaftarController::class, 'index']);
        Route::get('/biodata', [PendaftarController::class, 'biodata']);
        Route::get('/berkas', [PendaftarController::class, 'berkas']);
    });
});
