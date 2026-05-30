<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$users = \App\Models\Akun::where('role', '!=', 'pendaftar')->get(['id', 'nama', 'email', 'role']);
echo $users->toJson(JSON_PRETTY_PRINT);
