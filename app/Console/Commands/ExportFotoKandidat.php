<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peserta;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class ExportFotoKandidat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mfls:export-foto-lulus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengekspor foto kandidat yang lolos seleksi beasiswa menjadi satu file ZIP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Daftar nama berdasarkan list yang diberikan
        $names = <<<EOT
Muhammad Faisal
Raihan Firdaus Rabbani
Ilham Fathan Khairul
Siti Khaerunnisa 
Sinar Suryono
Cahaya Eka Rahayu
Zaidan Rifki
Galang A'yad Fitran Aldian
Chelsea Narciss Fissicella
Arka Aditya
Abimanyu Eka Prasetya
RAZZY ADETYA SYAHPUTERA
Aleem Ahmad Ibnu Syams
Muhammad Raihan Zaky
Samuel Marbun
Zeid Held Tirta Zaputra
Indria Syifa Pratiwi
Gabriel Taliak
Nazma Mariyam Alawiyah
Mahalia Putri Aprilli
Aldo Prayoga
Faturohman
Zahro Aema Shodikokh
Muhamad Hafidz Aryadillah
Maria Magdalena Putri Do Karmo
ELMEERA RADHIYA REZQYA BASARI
Intania Setia Rahayu
Hana Zahra
Raihan
Johanes Buller Imanuel Sitompul
Izzan Azzhilan Afhal
Cindi Nur Apriliani
Regita Hermayanti
Olivia
Puja Melisa Oktapiani
Marcel Sandika
Nur Tyas Putri Asep Rahmadi
Willy Alimudin
Risky Aditya Saputra
Shofia latifah
Hilman Ali Muchsin
Nurina Tarini
Faiqa Hadiya
Sohibul Milah
Raffa Athalariq
Alwan Sandi Devansyah
Derliano Fiqry Farhansyah
Nasya Alzeta Mulera
Abadani Ahda
Abdul Hafiz
Aelda Nurkhaila
Naura Jihada Masiyana
Aisyah Ar Rasyid Pakar
Andrea Puspa Ningrum
YOGA SAPUTRA
Muhammad Riki Sudarman
Vannisya rahma Haliza
Bela Safira Octavia
Novrika Riona 
Maryana Cecilia Sitorus
Raafi Achta Nadesta
Atian Aprinina Banyu Asmara
Ananda Fahri Ilham
Rasya Herawan
Najwa Mecca
Siti Nur Hasanah
Aisha Noormedina Wildani
Novi Lubis
Oktavia Damayanti Manullang
Muhammad Raihan Naufal
Muhammad Nauval Nawarudin
Widy Nurani Syakila
Galuh Chandra Kirana
Laura muthia kirana
Liani
Rachmat Kusworo Wibowo
Fira Gebi Monica
Azka Azkia Abdullah
EOT;

        $namesList = explode(PHP_EOL, $names);
        
        if (!class_exists('ZipArchive')) {
            $this->error('Extensi ZipArchive tidak aktif pada server PHP ini.');
            return;
        }

        $zip = new ZipArchive();
        $zipPath = public_path('foto_kandidat_lolos.zip');
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $found = 0;
            $missing = 0;
            
            $this->info("Sedang mencari dan mengumpulkan foto...");
            
            foreach ($namesList as $name) {
                $name = trim($name);
                if (empty($name)) continue;
                
                $peserta = Peserta::where('nama', $name)->first()
                        ?? Peserta::whereRaw('LOWER(TRIM(nama)) = ?', [strtolower($name)])->first()
                        ?? Peserta::where('nama', 'like', '%' . $name . '%')->first();
                        
                if ($peserta && $peserta->berkas && $peserta->berkas->foto) {
                    $fotoPath = storage_path('app/public/' . $peserta->berkas->foto);
                    if (file_exists($fotoPath)) {
                        $ext = pathinfo($fotoPath, PATHINFO_EXTENSION);
                        // Bersihkan nama agar aman untuk file
                        $safeName = preg_replace('/[^A-Za-z0-9\- \.]/', '', $peserta->nama);
                        $zip->addFile($fotoPath, $safeName . '.' . $ext);
                        $found++;
                    } else {
                        $this->warn("File foto hilang di storage: $name");
                        $missing++;
                    }
                } else {
                    $this->warn("Data/Foto tidak ditemukan: $name");
                    $missing++;
                }
            }
            
            $zip->close();
            $this->info("");
            $this->info("=== SELESAI ===");
            $this->info("Berhasil dikumpulkan: $found foto");
            $this->info("Gagal/Tidak ada foto: $missing orang");
            $this->info("File ZIP disimpan di: public/foto_kandidat_lolos.zip");
            $this->info("Anda dapat mendownloadnya di: " . url('foto_kandidat_lolos.zip'));
        } else {
            $this->error("Gagal membuat file ZIP. Pastikan folder public memiliki permission write.");
        }
    }
}
