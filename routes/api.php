<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SoalController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PengumumanController;

// Public Routes
Route::options('{any}', function() {
    return response()->json([], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin, Referer');
})->where('any', '.*');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/cek-pengumuman', [PengumumanController::class, 'cekHasil']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);

    // Endpoint Soal Ujian
    Route::get('/ujians', [SoalController::class, 'getUjians']);
    Route::get('/soal', [SoalController::class, 'index']);
    Route::post('/soal/submit', [SoalController::class, 'submit']);
});

