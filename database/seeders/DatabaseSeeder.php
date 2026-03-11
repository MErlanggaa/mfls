<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin Account
        // Create Admin Account
        \App\Models\Akun::create([
            'nama' => 'Super Admin',
            'email' => 'admin@mfls.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Pendaftar Dummy Account
        $user = \App\Models\Akun::create([
            'nama' => 'Budi Santoso',
            'email' => 'pendaftar@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'pendaftar',
        ]);

        $peserta = \App\Models\Peserta::create([
            'akun_id' => $user->id,
            'nama' => 'Budi Santoso',
            'no_whatsapp' => '081298765432',
            'tgl_lahir' => '2005-05-20',
            'jenis_kelamin' => 'Laki-laki',
            'tahun_lulus' => 2024,
            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Surabaya',
            'nama_sekolah' => 'SMAN 5 Surabaya',
            'telp_sekolah' => '0315556667',
            'nisn' => '0051234567',
        ]);

        // Create Daftar
        \App\Models\Daftar::create([
            'peserta_id' => $peserta->id,
            'no_wa' => $peserta->no_whatsapp,
            'jenis_kelamin' => $peserta->jenis_kelamin,
            'tahun_lulus' => $peserta->tahun_lulus,
            'ttl' => $peserta->tgl_lahir,
            'provinsi' => $peserta->provinsi,
            'kabupaten' => $peserta->kabupaten,
            'asal_sekolah' => $peserta->nama_sekolah,
            'status' => 'menunggu',
            'rata_rata_nilai' => 88.5, // Dummy awal
        ]);

        // Seed Kategori Ujian
        $ujianTPA = \App\Models\Ujian::create(['nama' => 'Tes Potensi Akademik']);
        $ujianBing = \App\Models\Ujian::create(['nama' => 'Bahasa Inggris']);
        $ujianWawancara = \App\Models\Ujian::create(['nama' => 'Wawancara Kebangsaan']);

        // Seed Matpel & Nilai Random
        $matpels = ['Matematika Wajib', 'Bahasa Indonesia', 'Bahasa Inggris'];

        foreach ($matpels as $namaMatpel) {
            $mp = \App\Models\Matpel::create(['nama' => $namaMatpel]);

            // Isi nilai semester 1-6
            for ($sem = 1; $sem <= 6; $sem++) {
                \App\Models\Nilai::create([
                    'peserta_id' => $peserta->id,
                    'matpel_id' => $mp->id,
                    'semester' => $sem,
                    'nilai' => rand(80, 98), // Nilai random bagus
                ]);
            }
        }
    }
}
