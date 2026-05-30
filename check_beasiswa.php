<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$daftars = \App\Models\Daftar::select('nominal_beasiswa')->distinct()->get();
echo "Distinct nominal_beasiswa:\n";
foreach($daftars as $d) {
    echo "- " . $d->nominal_beasiswa . "\n";
}

$count100 = \App\Models\Daftar::where('nominal_beasiswa', '100%')->count();
echo "Count for '100%': " . $count100 . "\n";

$countB100 = \App\Models\Daftar::where('nominal_beasiswa', 'Beasiswa 100%')->count();
echo "Count for 'Beasiswa 100%': " . $countB100 . "\n";
