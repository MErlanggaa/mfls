<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;
use App\Models\Peserta;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InterviewerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapping = [
            [
                'name' => 'Muhammad Rezki Oktavianoor, S.Sos., M.Si',
                'email' => 'muhammad.rezki@mncu.ac.id',
                'candidates' => [
                    // Online
                    "Bagas Fajar sidiq", "Vina Agustina", "Muhammad Salman", "Salwa Oktarina", 
                    "DEMA EFRIYANTI", "Sifa Savitri", "Muhammad Rasid Afandi",
                    // Offline
                    "Aini salsabila", "Syifa Atikah Putri", "Muhammad Rusli Sajidan", "Mei Sheilla Azizah", 
                    "Andini Larassyati", "Siti Khaerunnisa", "Risky Aditya Saputra", "Azka Syafwa", 
                    "Keisha Aulia Putri Anggraini", "Rhezita Zahira", "Marcel Sandika", "Keysa Nazira Kaila", 
                    "Ulya Zahro Maitsa", "Elena Madinata Berlian Firdaus", "Vannisya rahma Haliza"
                ]
            ],
            [
                'name' => 'Dr. Humiras Betty M. Sihombing',
                'email' => 'humairas.betty@mncu.ac.id',
                'candidates' => [
                    // Online
                    "Sabbah Muhtarisah Al-muqtashidah", "Marsudi Sujatmiko", "Fadlun Rahlil Ibrahim", 
                    "Puja Melisa Oktapiani", "Abdul Hafiz", "RAZZY ADETYA SYAHPUTERA", "Aulia Latifatul Mutmainnah",
                    // Offline
                    "Syahna Amalia Safira", "ISNA AFIFAH WIJOYONINGRUM", "Rasya Herawan", "CINDI NUR APRILIANI", 
                    "Mas Ayu Anindya Marsha Nikita", "Hilman Ali Muchsin", "MUHAMMAD RIZIQ", "Salwa Azariah", 
                    "Muhamad Hafidz Aryadillah", "Ayu Suryaningsih", "siti nur fadillah", "regita hermayanti", 
                    "Shireen Tsamrotul Puadah", "Muhammad Alvaro", "Nahwan Afdhal Ahmad"
                ]
            ],
            [
                'name' => 'Gilang Surya Pratama, S.M., M.Ak.',
                'email' => 'gilang.surya@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "Adelia Mandasari", "SITI AISYAH FEBRIANI", "Nasywa Adelia Putri", "Rahmawati", 
                    "Shofia latifah", "Muhammad Riki Sudarman", "Tanti inda lestari",
                    // Offline
                    "Nur Tyas Putri Asep Rahmadi", "Richard Adriel Wong", "Ilham Fathan Khairul", 
                    "Muhammad Dhiyaur Ramadhan Bakhr", "Putra Izhar Gumilar", "Abyan Dzaky Haidar", 
                    "Afrizal Rizky Setiawan", "Zahro Aema shodikokh", "MUHAMMAD NAUVAL NAWARUDIN", 
                    "ANDRA RAMADHAN SAHARA", "Anindya Ratiwi", "NUR FEBBRIANIY RIVVANTI FATULAH", 
                    "Rafiqa Kaylani", "Oktavia Damayanti Manullang", "MAHALIA PUTRI APRILLI"
                ]
            ],
            [
                'name' => 'Andi Heru Susanto, S.Sos., M.Si',
                'email' => 'andi.heru@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "Nayla Salsabila Assyifa", "ARTA ULI BR MARINGGA", "Fadila Ayu Amelya", "Adlin Ni’Mah", 
                    "Natasya Ahmi Safira", "Ulya Zahro Maitsa",
                    // Offline
                    "Alya Putri Sulaiman", "Tiara Citra Dewi", "Brianya Aprilia Silitonga", "Raffa Athalariq", 
                    "SITI AISYAH FEBRIANI", "Sri Wulan", "Vivi Aulivia", "Octavia rahmadanti", "Julia Syafitri", 
                    "Rifdah Zahraani", "SYAFIRA ANGGRAENI", "Lutfi Anggraeni", "Muhammad Ghifari Radityo", 
                    "Sulthan Syauqi Azhar", "Auriel amalya"
                ]
            ],
            [
                'name' => 'Liena Prajogi, S.E., M.M',
                'email' => 'liena.prajogi@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "ADINDA SOFA SYAI'RILLAH", "Rotua Angelina", "ANGGUN ZAHRA JULINA", 
                    "Naima Aulia zahara", "MUHAMAD MISBAHUSSURUR", "Nazwa Marfa Putri",
                    // Offline
                    "Rachmat Kusworo Wibowo", "Pebrian Suhendiawan", "Diana nabilla", "Felisha Savinnatunasah", 
                    "Maria Gracia", "Ajeng prameitasari", "ALDO PRAYOGA", "Siti Nur Hasanah", "Nazwa Sheshicha", 
                    "Aisyah Ar Rasyiid Pakar", "Mahalika Amanda", "Nazma Mariyam Alawiyah", "Naura Jihada Masiyana", 
                    "Syifa Nurkamila", "Khoerunisa"
                ]
            ],
            [
                'name' => 'Noval Adi Priyatno, S. Hub. Int',
                'email' => 'noval.adi@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "Maryana Cecilia Sitorus", "Gabriel Taliak", "RADITYA", 
                    "Ester Enjelina Aritonang", "Muhammad Faisal", "Shabrina Aqilah Hanin",
                    // Offline
                    "Muhammad Triyudha Asnan", "MUHAMMAD RAIHAN NAUFAL", "Cristy Stefany Putri", 
                    "Desila Dwi Sartika", "Zesica erlinda putri", "Anayla", "Fira Gebi Monica", 
                    "KEYZIA SALVA RAJAGUKGUK", "Ariqah Fawwaz Talitha", "Nadine Raysah Syakieb", 
                    "TSABITA RAHNI SALSABILLA", "VIONA FATMA RAHAYU", "Derliano fiqry farhansyah", 
                    "SINAGA,EKA CHRSITINA OCTAVIANI SINAGA"
                ]
            ],
            [
                'name' => 'Neni Nurkhamidah, M.Pd',
                'email' => 'neni.nurkhamidah@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "Maria Magdalena Putri Do Karmo", "Intania Setia Rahayu", "Karina", "siti rohmah azzahra", 
                    "Sohibul Milah", "SYIFA AULIA MAULANA", "Davina fransisca laura",
                    // Offline
                    "CHELSI ADITIA", "Alika Yasmin Fawwaz", "Raihan Firdaus Rabbani", "DINDA NADHIRA AMALYA", 
                    "Naila Cahaya Mecca", "VIZKA RACHMANIA", "Nanda Tri Hafsyari", "Dwi Oktavia", 
                    "Nesya Laura Renata", "ISNA PUTRI ZAHROTUNNAFI'AH", "Chelsea Narciss Fissicella", 
                    "Aldo Radedo Siallagan", "Yemima Eunike Pandiangan", "Azka Azkia Abdullah", "ORIZHA SATIVA LUTHFIA ILMI"
                ]
            ],
            [
                'name' => 'Anita, S.E.,M.Ak',
                'email' => 'anita@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "KIRANA FAADHILAH HISAANAH", "Abyan Dzaky Haidar", "Zahra Awliya Ramadhani", 
                    "ULMILA SYARITA", "Andre Septyo Mardianto", "Raafi achta nadesta", "Jenaya Soiya Hulu",
                    // Offline
                    "Dea Fadilah", "Inayah Rahmaniyah", "TALITHA ADELA", "Olivia Ramadhani", "Shafiq Alief Faiz", 
                    "DIDIT MUHAMAD ILYAS", "RIKY PADRUROHMAN", "ALWAN SANDI DEVANSYAH", "REZKY ANANDA YUSUF", 
                    "Aqwam Iqomudinillah", "MUHAMMAD AULIYAA ALGOZALI", "RIZKI RAMADAN HARAHAP", "Raihan", 
                    "Zahra Nanda Calista", "Joceline Kania Manurung"
                ]
            ],
            [
                'name' => 'Dr. Nadya Syifa Utami',
                'email' => 'nadya.syifa@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "Liani", "Andra Ramadhan Sahara", "MUHAMMAD DAFAA", "Zahrah Adeha", "Melinda Kesuma Dewi", 
                    "NERA REPTIANA", "ELMEERA RADHIYA REZQYA BASARI", "Putri Wulandari",
                    // Offline
                    "Muhammad Daidan Hilmy", "Sinar Suryono", "Yuki Meiliana Farosa", "Sabrina Caltha Chairunnisa", 
                    "Galuh Chandra Kirana", "Arla Rahmania", "Atian Aprinina Banyu Asmara", "Galang A’yad Fitran Aldian", 
                    "Raditya Putra Wicaksana", "Sri Ambar Wati", "putriyani ayu kusuma", "ALEEM AHMAD IBNU SYAMS", 
                    "Nisfi Nurlaili", "Hilwah Nadzifah", "Indria Syifa Pratiwi"
                ]
            ],
            [
                'name' => 'Ahmad Fikri Alamin, S.Akun., M.Si',
                'email' => 'ahmad.fikri@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "Luzzeina Nadila Yusuf", "Raisa octavia", "Risa Aura Ramadani", "Cita Aulan Hasanah", 
                    "Desi Adelia Pratiwi", "Nadia Rahma Az Zahra", "KIARA ANAYA SYIEFANNY",
                    // Offline
                    "ALYA LATHIFA SARI", "Arka Aditya", "Putri Pebyanti", "Najwa Mecca", "REVINA DEA ARIPIANTI", 
                    "Tiara Dewi Lestari", "Keyla Aulya Rizky", "Fahira Sasti Ramadhani", "Azizah Khairunnisa", 
                    "Muhammad Ghilman Azka", "Alysa Chairani", "AMALYA RAMADHANTI", "YULIA PERMATASARI", 
                    "Wiranata", "Karina Angelica"
                ]
            ],
            [
                'name' => 'Dr. Shelly Morin, M.Pd',
                'email' => 'shelly.morin@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "Erin Afrillia", "Moch Dziqri Al Ghifari", "Nazra Latizha Maulida", "NAJLA AULIA LBS", 
                    "Andrea Puspa Ningrum", "Siti Sahila Tansa", "Aura Angelina Fasha",
                    // Offline
                    "Shafira Fatimah Nurzahrah", "Nabila Annastasya", "Fernando Kevin Pratama", "SAMUEL MARBUN", 
                    "Zeid Held Tirta Zaputra", "Muhammad Faisal", "AZRIEL AZIZ BAZLIA SUYONO", "ALFIZAHRA KEISHADI", 
                    "Muhammad Raihan Zaky", "Ruth Alinansi Marbun", "RISKA AMELIA", "Dea puspita sari", 
                    "PAIS ALIF FIRDAUS", "Tubagus Rafly Hasanudin Yusuf", "NAUFAL ABDILLAH PRATAMA"
                ]
            ],
            [
                'name' => 'Wida Nofiasari, M. Ikom',
                'email' => 'wida.nofiasari@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "Laura muthia kirana", "Annisaul Mardhiyah Octavia", "JOHANES BULLER IMANUEL SITOMPUL", 
                    "Salma Tani'ah", "Zaidan Rifki", "Nadatul munawaroh", "SALSA HUSNA LATIFA", "Kirana Gumilangsari",
                    // Offline
                    "Bagas Abie Pratama", "Gabriella Karenhapukh Andrea Sinaga", "NOVI LUBIS", "Jessi Tiara Putri", 
                    "SITI ZAHRA JAMALLULAIL", "Abimanyu Eka Prasetya", "Rafina Putri Julyanty", "Salwa Oktafiani", 
                    "Dalilah Rohmah", "Bela Safira Octavia", "Nafisah Nailal Husna", "VIOLIN AZZAHRA RIYONA", 
                    "Abadani Ahda", "nazilla aulianti", "Chiara Belva RPN"
                ]
            ],
            [
                'name' => 'Eko Amri Jaya, M.Kom',
                'email' => 'eko.amri@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "ADELIA MANDASARI", "Cahaya Eka Rahayu", "DAVID VALENTINOTODA", "Rivana Adelia", 
                    "Naila Rohimatus Sa'diyah", "ADITIA ABDUL AZIZ", "AHMAD DZAKY NASUTION",
                    // Offline
                    "Kartika Juliati Silaen", "Affan Farid Kurniawan", "RAHMI DIANY", "Rinaldi Siburian", 
                    "Arya Gustaf Virgiansyah", "SYIFA MEYLANI PUTRI", "Novrika Riona", "Suci Ramadhani Dantjie", 
                    "Aelda Nurkhaila", "Nabila Hamdi Sulaiman", "Rahmania Agustin", "Siti Kayla", 
                    "Ananda Fahri Ilham", "Wahidah Washifah Uzza Madiadipura", "Akbar Abdillah Chaidir"
                ]
            ],
            [
                'name' => 'Dr. Bernadetta Kwintiana Ane',
                'email' => 'bk.ane@mncu.ac.id',
                'candidates' => [
                    // Online (Selasa 19 Mei 2026)
                    "YOGA SAPUTRA", "Willy Alimudin", "Faiqa Hadiya", "Muhammad Farid Firdaus", "NUR FEBBRIANIY RIVVANTI FATULAH",
                    // Offline
                    "NASYIFAH NAILATUL IZZAH", "FRIZKA MAWARNI", "Nanda Gadis Supriadi", "SATRIA CAHAYA MULYA", 
                    "Khirana Try mulia", "Desi Adelia Pratiwi", "IBRAHIM MOVIC DIPONEGORO", "Ayu Wulandari", 
                    "Nurina Tarini", "Dinda Agustina Santoso", "ALFAN"
                ]
            ],
            [
                'name' => 'Dendi Pratama',
                'email' => 'dendi.pratama@mncu.ac.id',
                'candidates' => []
            ]
        ];

        DB::transaction(function () use ($mapping) {
            $mappedCount = 0;

            $roomMap = [
                'muhammad.rezki@mncu.ac.id' => 'Ruangan 1',
                'humairas.betty@mncu.ac.id' => 'Ruangan 2',
                'gilang.surya@mncu.ac.id' => 'Ruangan 3',
                'andi.heru@mncu.ac.id' => 'Ruangan 4',
                'liena.prajogi@mncu.ac.id' => 'Ruangan 5',
                'noval.adi@mncu.ac.id' => 'Ruangan 6',
                'neni.nurkhamidah@mncu.ac.id' => 'Ruangan 7',
                'anita@mncu.ac.id' => 'Ruangan 8',
                'nadya.syifa@mncu.ac.id' => 'Ruangan 9',
                'ahmad.fikri@mncu.ac.id' => 'Ruangan 10',
                'shelly.morin@mncu.ac.id' => 'Ruangan 11',
                'wida.nofiasari@mncu.ac.id' => 'Ruangan 12',
                'eko.amri@mncu.ac.id' => 'Ruangan 13',
                'bk.ane@mncu.ac.id' => 'Ruangan 14',
                'dendi.pratama@mncu.ac.id' => 'Ruangan 15',
            ];

            foreach ($mapping as $dosenData) {
                // 1. Create or Update Akun for Dosen
                $akun = Akun::updateOrCreate(
                    ['email' => strtolower(trim($dosenData['email']))],
                    [
                        'nama' => $dosenData['name'],
                        'password' => Hash::make('MFLSJAYA!'),
                        'role' => 'dosen',
                        'email_verified_at' => now(),
                    ]
                );

                $this->command->info("Seeded interviewer: {$akun->nama} ({$akun->email})");

                $cleanEmail = strtolower(trim($dosenData['email']));
                $ruangan = $roomMap[$cleanEmail] ?? 'Ruangan Wawancara';

                // 2. Map Candidates to this Interviewer
                foreach ($dosenData['candidates'] as $candidateName) {
                    $cleanedName = trim($candidateName);

                    // Exact match
                    $peserta = Peserta::whereRaw('LOWER(nama) = ?', [strtolower($cleanedName)])->first();

                    // Fuzzy match fallback
                    if (!$peserta) {
                        $peserta = Peserta::where('nama', 'LIKE', '%' . $cleanedName . '%')->first();
                    }

                    if ($peserta) {
                        $peserta->update([
                            'interviewer_id' => $akun->id,
                            'ruangan' => $ruangan
                        ]);
                        $this->command->info("  -> Mapped candidate: {$peserta->nama} to Room: {$ruangan}");
                        $mappedCount++;
                    } else {
                        $this->command->warn("  -> Candidate not found in database: '{$candidateName}'");
                    }
                }
            }

            // Fallback for local testing: if no candidate names matched, assign all existing pesertas to the first lecturer
            if (app()->environment('local') && $mappedCount === 0) {
                $firstInterviewer = Akun::where('email', 'muhammad.rezki@mncu.ac.id')->first();
                if ($firstInterviewer) {
                    $cleanEmail = strtolower(trim($firstInterviewer->email));
                    $ruangan = $roomMap[$cleanEmail] ?? 'Ruangan 1';
                    Peserta::query()->update([
                        'interviewer_id' => $firstInterviewer->id,
                        'ruangan' => $ruangan
                    ]);
                    $this->command->info("Local fallback: Mapped all existing test candidates to {$firstInterviewer->nama} in Room: {$ruangan}");
                }
            }
        });
    }
}
