<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SoalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoint Soal Ujian (Tanpa Auth dulu agar React bisa akses mudah saat dev)
Route::get('/soal', [SoalController::class, 'index']);
