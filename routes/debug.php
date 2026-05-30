<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// DEBUG ROUTE - HAPUS SETELAH SELESAI
Route::get('/debug-beasiswa-100', function () {
    $totalPA = \App\Models\PenilaianAkademik::count();
    $pa100 = \App\Models\PenilaianAkademik::where('rekomendasi_beasiswa', 'like', '%100%')->count();
    $distinctRek = \App\Models\PenilaianAkademik::whereNotNull('rekomendasi_beasiswa')
        ->select('rekomendasi_beasiswa')->distinct()->pluck('rekomendasi_beasiswa');
    $totalDaftar100 = \App\Models\Daftar::where('nominal_beasiswa', 'like', '%100%')->count();
    $distinctNominal = \App\Models\Daftar::whereNotNull('nominal_beasiswa')
        ->select('nominal_beasiswa')->distinct()->pluck('nominal_beasiswa');

    // Sample penilaian akademik data
    $samplePA = \App\Models\PenilaianAkademik::with('peserta.akun')
        ->take(5)->get()->map(function($pa) {
            return [
                'peserta' => $pa->peserta?->akun?->nama ?? '-',
                'rekomendasi_beasiswa' => $pa->rekomendasi_beasiswa,
                'total_akhir' => $pa->total_akhir,
            ];
        });

    return response()->json([
        'total_penilaian_akademiks' => $totalPA,
        'penilaian_rekomendasi_100' => $pa100,
        'distinct_rekomendasi_beasiswa' => $distinctRek,
        'total_daftar_nominal_100' => $totalDaftar100,
        'distinct_nominal_beasiswa' => $distinctNominal,
        'sample_penilaian_akademik' => $samplePA,
    ]);
})->middleware('auth');
