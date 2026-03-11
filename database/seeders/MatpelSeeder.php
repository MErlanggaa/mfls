<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatpelSeeder extends Seeder
{
    public function run()
    {
        $matpels = [
            'Matematika Wajib',
            'Bahasa Indonesia',
            'Bahasa Inggris',

        ];

        foreach ($matpels as $mp) {
            \App\Models\Matpel::firstOrCreate(['nama' => $mp]);
        }
    }
}
