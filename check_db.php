<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$out = "";

// Total penilaian akademik
$totalPA = \App\Models\PenilaianAkademik::count();
$out .= "Total penilaian_akademiks: $totalPA\n";

// Yang punya rekomendasi_beasiswa berisi 100
$pa100 = \App\Models\PenilaianAkademik::where('rekomendasi_beasiswa', 'like', '%100%')->count();
$out .= "Penilaian akademik dengan rekomendasi 100%: $pa100\n\n";

// Distinct values of rekomendasi_beasiswa
$distinctRek = \App\Models\PenilaianAkademik::whereNotNull('rekomendasi_beasiswa')
    ->select('rekomendasi_beasiswa')->distinct()->pluck('rekomendasi_beasiswa');
$out .= "Distinct rekomendasi_beasiswa:\n";
foreach ($distinctRek as $r) {
    $out .= "  - $r\n";
}
$out .= "\n";

// Total daftar dengan nominal_beasiswa
$totalDaftar100 = \App\Models\Daftar::where('nominal_beasiswa', 'like', '%100%')->count();
$out .= "Total daftar dengan nominal_beasiswa 100%: $totalDaftar100\n\n";

// Distinct nominal_beasiswa values
$distinctNominal = \App\Models\Daftar::whereNotNull('nominal_beasiswa')
    ->select('nominal_beasiswa')->distinct()->pluck('nominal_beasiswa');
$out .= "Distinct nominal_beasiswa:\n";
foreach ($distinctNominal as $n) {
    $out .= "  - $n\n";
}

file_put_contents('check_out.txt', $out);
echo "Done\n";
