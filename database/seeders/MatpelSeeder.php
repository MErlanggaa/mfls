<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatpelSeeder extends Seeder
{
    public function run()
    {
        $matpels = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Informatika'
        ];

        foreach ($matpels as $mp) {
            \App\Models\Matpel::firstOrCreate(['nama' => $mp]);
        }
    }
}
