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

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/survey', [SurveyController::class, 'show']);
    Route::post('/survey', [SurveyController::class, 'store']);

    Route::prefix('pendaftar')->group(function () {
        Route::get('/dashboard', [PendaftarController::class, 'index']);
        Route::get('/biodata', [PendaftarController::class, 'biodata']);
        Route::get('/berkas', [PendaftarController::class, 'berkas']);
    });
});
