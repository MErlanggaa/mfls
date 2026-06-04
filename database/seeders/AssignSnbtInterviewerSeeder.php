<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;
use App\Models\Peserta;
use App\Models\Daftar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AssignSnbtInterviewerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interviewerEmail = 'noval.adi@mncu.ac.id';
        $ruangan = 'Ruangan 6';

        $interviewer = Akun::where('email', $interviewerEmail)->first();
        if (!$interviewer) {
            $this->command->error("Interviewer dengan email '$interviewerEmail' tidak ditemukan.");
            return;
        }

        $participants = [
            ['email' => 'qaishadefa@gmail.com', 'nama' => 'Qaisha Defa Triadinta', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'SMAN 87 JAKARTA', 'hp' => '085776341560'],
            ['email' => 'milanefendi28@gmail.com', 'nama' => 'Baiq Milan Tifen Efendi', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMAN 7 BANDUNG', 'hp' => '085721438577'],
            ['email' => 'nggii8456@gmail.com', 'nama' => 'Anggi', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA Negeri 1 Pantai Labu', 'hp' => '083196755646'],
            ['email' => 'marcellanurgayani8@gmail.com', 'nama' => 'Marcella Nurgayani', 'prodi' => 'Manajemen', 'sekolah' => 'SMAN 15 KOTA BEKASI', 'hp' => '085894945062'],
            ['email' => 'dviaii1207@gmail.com', 'nama' => 'Deviyanti Nuraini', 'prodi' => 'Pendidikan Matematika', 'sekolah' => 'SMKN 5 KOTA BEKASI', 'hp' => '082213132055'],
            ['email' => 'naufalchaerulzaki@gmail.com', 'nama' => 'Naufal Chaerul Zaki', 'prodi' => 'Ilmu Komputer', 'sekolah' => 'SMKN 5 KOTA BEKASI', 'hp' => '085711199462'],
            ['email' => 'ayudiaannisa21@gmail.com', 'nama' => 'Ayudia Annisa Maharani Pramesty', 'prodi' => 'Manajemen', 'sekolah' => 'SMK YADIKA 11', 'hp' => '085183012167'],
            ['email' => 'elsadanatalia4@gmail.com', 'nama' => 'Elsada Natalia Christia Ningrum', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMKN 1 BOYOLALI', 'hp' => '081328615834'],
            ['email' => 'mayzahaniangelina@gmail.com', 'nama' => 'Mayzha Hani Angelina', 'prodi' => 'Manajemen', 'sekolah' => 'SMA NEGERI 2 PEMALANG', 'hp' => '085742977686'],
            ['email' => 'virlyaulia8@gmail.com', 'nama' => 'Virly Aulia Rahman', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'MAN 2 Kota Bogor', 'hp' => '083811500541'],
            ['email' => 'denayaauliarosadi@gmail.com', 'nama' => 'Denaya Aulia Rosadi', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA PGRI 4 Jakarta', 'hp' => '08986926752'],
            ['email' => 'ffitrianiindah55@gmail.com', 'nama' => 'Indah Fitriani', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'MAN 3 Bogor', 'hp' => '085330619000'],
            ['email' => 'sultanhanif949@gmail.com', 'nama' => 'Sultan Hanif Alfaruk', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMAS KARTIKA VIII-1', 'hp' => '085719101845'],
            ['email' => 'nisrinaauliakhaiiranii@gmail.com', 'nama' => 'Nisrina Aulia Khairani', 'prodi' => 'Sistem Informasi', 'sekolah' => 'MAN 3 BOGOR', 'hp' => '081387693939'],
            ['email' => 'nabila.azzahra6069@sma.belajar.id', 'nama' => 'NABILA AZ-ZAHRA', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 33 JAKARTA', 'hp' => '081291480285'],
            ['email' => 'amaliapradisti3828@gmail.com', 'nama' => 'Amalia Pradisti', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'MAN 3 BOGOR', 'hp' => '085811407945'],
            ['email' => 'yusrotulzahro6@gmail.com', 'nama' => 'yusrotul zahro', 'prodi' => 'Akuntansi', 'sekolah' => 'MAS Darunna’im', 'hp' => '085775278626'],
            ['email' => 'chintyadwihana7@gmail.com', 'nama' => 'Chintya Dwihana Nainggolan', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 3 PALANGKA RAYA', 'hp' => '085751455016'],
            ['email' => 'anisanuristiqomah10@gmail.com', 'nama' => 'Anisa Nur Istiqomah', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 112 JAKARTA', 'hp' => '0895619797171'],
            ['email' => 'syaikhahputrirosifansyah@gmail.com', 'nama' => 'Syaikhah Putri Rosifansyah', 'prodi' => 'Akuntansi', 'sekolah' => 'SMA Sejahtera 1 Depok', 'hp' => '085772653057'],
            ['email' => 'akirana683@gmail.com', 'nama' => 'KIRANA FADHILAH HISAANAH', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 1 CILIMUS', 'hp' => '081211273500'],
            ['email' => 'valeriabiqhlasabiqh08@gmail.com', 'nama' => 'VALERIA BIQHLASA', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 1 SUSUKAN', 'hp' => '081394990944'],
            ['email' => 'tiaranarait@gmail.com', 'nama' => 'Tiara Novita Wardani', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMAN 9 TANGERANG SELATAN', 'hp' => '089643455293'],
            ['email' => 'nauramaulikhai@gmail.com', 'nama' => 'Naura Mauli Khairunnisa', 'prodi' => 'Manajemen', 'sekolah' => 'SMAN 9 Kota Tangerang Selatan', 'hp' => '085882907946'],
            ['email' => 'nafishabrina27@gmail.com', 'nama' => 'Sayyidah Nafisha Shabrina', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'sman 11 tangsel', 'hp' => '0811273305'],
            ['email' => 'azaliajambi@gmail.com', 'nama' => 'AZALIA ILLONA PUTRI', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN TITIAN TERAS HAS', 'hp' => '081268709987'],
            ['email' => 'gracellamasnahanarumapea@gmail.com', 'nama' => 'Gracella Masna Hana Rumapea', 'prodi' => 'Manajemen', 'sekolah' => 'SMA Maria Mediatrix', 'hp' => '083897978572'],
            ['email' => 'reviuniaputri@gmail.com', 'nama' => 'Revi Unia Putri', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 3 PALANGKA RAYA', 'hp' => '085932640812'],
            ['email' => 'callistaaulia7@gmail.com', 'nama' => 'Callista Aulia Toti Putri', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA Negeri 1 Sragen', 'hp' => '0823-1054-7558'],
            ['email' => 'vaniarizki774@gmail.com', 'nama' => 'Vania Rizki Callysta Putri', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 51 Jakarta', 'hp' => '082150915956'],
            ['email' => 'bila.ipah01@gmail.com', 'nama' => 'Nabila Rafifah Artanti', 'prodi' => 'Sistem Informasi', 'sekolah' => 'MAN 2 Kota Madiun', 'hp' => '0851-3650-7704'],
            ['email' => 'najlaalyaasyakirah@gmail.com', 'nama' => 'Najla Alyaa Syakirah', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMAN 33 JAKARTA', 'hp' => '08981963232'],
            ['email' => 'karinaghaniyya2@gmail.com', 'nama' => 'Karina Ghaniyya Abdillah', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'MAN 5 BOGOR', 'hp' => '0895630188595'],
            ['email' => 'azahrazahwa29@gmail.com', 'nama' => 'Azahra Zahwa', 'prodi' => 'Manajemen', 'sekolah' => 'MAS DARUNNA’IM', 'hp' => '08131890491'],
            ['email' => 'meutia.ramadhanti@gmail.com', 'nama' => 'Meutia Ramadhanti', 'prodi' => 'Manajemen', 'sekolah' => 'SMAN 89 Jakarta', 'hp' => '08993280106'],
            ['email' => 'jernivetragreciah@gmail.com', 'nama' => 'Jerni Vetra Grecia Hutapea', 'prodi' => 'Manajemen', 'sekolah' => 'SMAN 1 CIBINONG', 'hp' => '0895400932342'],
            ['email' => 'celvydwi811@gmail.com', 'nama' => 'Celvy Dwi Agustin', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'SMAN 2 Cimalaka', 'hp' => '0895412969135'],
            ['email' => 'mrsyptrnrynd@gmail.com', 'nama' => 'Marsya Putri Nuriyandi', 'prodi' => 'Akuntansi', 'sekolah' => 'SMA Negeri 10 Pekanbaru', 'hp' => '083181269568'],
            ['email' => 'novitachytra@gmail.com', 'nama' => 'Novita chytra sinaga', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'SMA NEGERI 3 TAMBUN SELATAN', 'hp' => '085772178158'],
            ['email' => 'nathandion685@gmail.com', 'nama' => 'Christian Nathandion Kase', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMA Negeri 17 Kabupaten Tangeranv', 'hp' => '089697483953'],
            ['email' => 'keishanourasn@gmail.com', 'nama' => 'Keisha Noura Shazma Nadhifah', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA Negeri 1 Gunung Sindur', 'hp' => '085794629522'],
            ['email' => 'giriaditya09@gmail.com', 'nama' => 'Giri Aditya', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMKN 2 GARUT', 'hp' => '085960578014'],
            ['email' => 'kiyaanny@gmail.com', 'nama' => 'Erina Sakya Pitra', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 1 CIBITUNG', 'hp' => '085157629466'],
            ['email' => 'nasyarawp@gmail.com', 'nama' => 'Nasya Rahma Apsarini Winarno', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 1 Tuntang', 'hp' => '0895421300704'],
            ['email' => 'inayahandini07@gmail.com', 'nama' => 'Inayah Andini', 'prodi' => 'Manajemen', 'sekolah' => 'MAS Mahad Alzaytun', 'hp' => '085691683412'],
            ['email' => 'chelochel.135@gmail.com', 'nama' => 'Silalahi Rachel Agustina', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'SMAN 1 CIBITUNG', 'hp' => '085180868693'],
            ['email' => 'slwauraa@gmail.com', 'nama' => 'Salwa Meisya Aura', 'prodi' => 'Manajemen', 'sekolah' => 'MAN 8 JAKARTA', 'hp' => '085876940273'],
            ['email' => 'fatihdaf03103579@gmail.com', 'nama' => 'Daffa Fatihandra', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'Sma boash', 'hp' => '085837151797'],
            ['email' => 'feykazahrakhairinnisa@gmail.com', 'nama' => 'Feyka Zahra Khairinnisa', 'prodi' => 'Akuntansi', 'sekolah' => 'SMKN 11 KOTA BEKASI', 'hp' => '082125131321'],
            ['email' => 'ainanajwapuspa12@gmail.com', 'nama' => 'Najwa Aina Puspa', 'prodi' => 'Akuntansi', 'sekolah' => 'SMKN 11 KOTA BEKASI', 'hp' => '085971620464'],
            ['email' => 'syifanalaandjani@gmail.com', 'nama' => 'Nadjla Syifa Andjani', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMK BOASH 1', 'hp' => '081295858634'],
            ['email' => 'almoa308@gmail.com', 'nama' => 'Vicentius Salomo Manik', 'prodi' => 'Ilmu Komputer', 'sekolah' => 'SMA PAX Patriae', 'hp' => '085163041180'],
            ['email' => 'harethasidiq@gmail.com', 'nama' => 'Haretha Julian Muhammad Sidiq', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'MAN 1 Klaten', 'hp' => '085229898273'],
            ['email' => 'rinaldisiburian636@gmail.com', 'nama' => 'Rinaldi Siburian', 'prodi' => 'Manajemen', 'sekolah' => 'SMKN 53 Jakarta', 'hp' => '087880612135'],
            ['email' => 'syahira.sn2109@gmail.com', 'nama' => 'Syahira Shazia Nadhilah', 'prodi' => 'Manajemen', 'sekolah' => 'SMAN 15 KOTA BEKASI', 'hp' => '0895338087577'],
            ['email' => 'kartikaaprilianugraheni@gmail.com', 'nama' => 'Kartika Aprilia Nugraheni', 'prodi' => 'Akuntansi', 'sekolah' => 'SMKS SANDIKTA BEKASI', 'hp' => '0895406911332'],
            ['email' => 'prasetyagracia9@gmail.com', 'nama' => 'Gracia Noela Putri Prasetya', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA Negeri 3 Surakarta', 'hp' => '081325229029'],
            ['email' => 'juwitamay22@gmail.com', 'nama' => 'Juwita May Warohma', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 33 JAKARTA', 'hp' => '087772353696'],
            ['email' => 'serlianangie@gmail.com', 'nama' => 'serlian angie', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMAN 6 KABUPATEN TANGERANG', 'hp' => '081287429294'],
            ['email' => 'andiennurhanifaa2@gmail.com', 'nama' => 'Andien Nurhanifa', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA Muhammadiyah 15 Jakarta', 'hp' => '087844047217'],
            ['email' => 'nabilaanjani722@gmail.com', 'nama' => 'Kesya Nabila Anjani', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 1 SLOGOHIMO', 'hp' => '083806467984'],
            ['email' => 'nabilafadilah119@gmail.com', 'nama' => 'Nabila Nurfadilah', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'PKBM SULTAN HASANUDIN', 'hp' => '0895329509446'],
            ['email' => 'issaarianti@gmail.com', 'nama' => 'ISNA AMRIANTI NADIRA', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAS PGRI 1 JAKARTA', 'hp' => '081398554239'],
            ['email' => 'nabilahsyftri06@gmail.com', 'nama' => 'Nabilah Syafitri', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 37 JAKARTA', 'hp' => '082113265625'],
            ['email' => 'kaltsumluthfiyyah12@gmail.com', 'nama' => 'Kaltsum Luthfiyyah Sa\'adah', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 1 Cikarang Barat', 'hp' => '0895320185090'],
            ['email' => 'zahraanisa0112@gmail.com', 'nama' => 'Anisa Azzahra', 'prodi' => 'Manajemen', 'sekolah' => 'SMA NEGERI 1 PRINGSEWU', 'hp' => '088287042942'],
            ['email' => 'putridwirianti680@gmail.com', 'nama' => 'Putri Dwi Riyanti', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 1 SAMPIT', 'hp' => '089526149840'],
            ['email' => 'synuril00@gmail.com', 'nama' => 'SITI NUR LAILATUL FITHRIYYAH', 'prodi' => 'Akuntansi', 'sekolah' => 'MAN LUMAJANG', 'hp' => '085727465536'],
            ['email' => 'gystiaraahya@gmail.com', 'nama' => 'Gystiara Ahya Fajrin', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'SMK Negeri 27 Jakarta', 'hp' => '085894988712'],
            ['email' => 'amelisapasaribu972@gmail.com', 'nama' => 'Amelisa Pasaribu', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 14 KABUPATEN TANGERANG', 'hp' => '081287587861'],
            ['email' => 'giearnesya@gmail.com', 'nama' => 'Anggie Arnesya Putri Mariana', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA NEGERI 6 TAMBUN SELATAN', 'hp' => '085773039735'],
            ['email' => 'azizatulfadilah5@gmail.com', 'nama' => 'NUR AZIZATUL FADHILAH', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'SMKN 24 JAKARTA', 'hp' => '08815209403'],
            ['email' => 'indahrianita022@gmail.com', 'nama' => 'Indah Rianita Pramesti', 'prodi' => 'Akuntansi', 'sekolah' => 'Smk Putra Bangsa', 'hp' => '081770298563'],
            ['email' => 'kemilausenjasenandung@gmail.com', 'nama' => 'Kemilau Senandung Senja', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 8 Tambun Selatan', 'hp' => '085171010764'],
            ['email' => 'jasmineauracantika@gmail.com', 'nama' => 'AURA CANTIKA JASMINE', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'SMA Negeri 1 Mandirancan', 'hp' => '081222252852'],
            ['email' => 'fairuzalifiandra@gmail.com', 'nama' => 'Muhammad Fairuz Alifiandra', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'PKBM ABHOME', 'hp' => '087789191912'],
            ['email' => 'gaizkaarieframadhan@gmail.com', 'nama' => 'Gaizka Arief Ramadhan', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'PKBM ABHOME', 'hp' => '085156817128'],
            ['email' => 'mirarahmawati2511@gmail.com', 'nama' => 'MIRA RAHMA WATI', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'SMAN 1 TANJUNG JABUNG TIMUR', 'hp' => '085251044048'],
            ['email' => 'fhauzee00@gmail.com', 'nama' => 'Muhammad Faiz AF', 'prodi' => 'Sistem Informasi', 'sekolah' => 'PKBM ABhome', 'hp' => '085817351750'],
            ['email' => 'kheilaputrinawdira19@gmail.com', 'nama' => 'Kheila Putri Nawdira', 'prodi' => 'Manajemen', 'sekolah' => 'SMAS YADIKA 8 JATIMULYA', 'hp' => '088297928663'],
            ['email' => 'raizaazrianszah@gmail.com', 'nama' => 'raiza fazrianszah', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'SMA NEGERI 1 PAGADEN', 'hp' => '083161434616'],
            ['email' => 'kurniacitravadila.smk2@gmail.com', 'nama' => 'Kurnia Citra Vadila', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMK NEGERI 2 KOTA DEPOK', 'hp' => '081210028675'],
            ['email' => 'farhanfadhilahgaalibaputra@gmail.com', 'nama' => 'Farhan Fadhilah Gaaliba Putra', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 1 KLAPANUNGGAL', 'hp' => '081297228411'],
            ['email' => 'khalidaziazulfa0@gmail.com', 'nama' => 'Khalidazia Zulfa Zahrotusyita', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMA N 1 BATANG', 'hp' => '085640616304'],
            ['email' => 'icatricia10@gmail.com', 'nama' => 'Angelica Patricia Simarmata', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 6 Bekasi', 'hp' => '087875238940'],
            ['email' => 'njwaazahwa@gmail.com', 'nama' => 'Kusprinajwa Islami Zahwa', 'prodi' => 'Manajemen', 'sekolah' => 'SMAN 60 JAKARTA', 'hp' => '085771541756'],
            ['email' => 'novacaca243@gmail.com', 'nama' => 'Raysha Nova Aulia', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAS PGRI 12 JAKARTA', 'hp' => '085880279891'],
            ['email' => 'sabriaalia658@gmail.com', 'nama' => 'Sabria Alia Meidina', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA Kemala Bhayangkari 1 Jakarta', 'hp' => '083184346135'],
            ['email' => 'berryramaditya@gmail.com', 'nama' => 'Berry Ramaditya Adikara', 'prodi' => 'Manajemen', 'sekolah' => 'SMAN 2 JONGGOL', 'hp' => '085145753970'],
            ['email' => 'rizkacantika623@gmail.com', 'nama' => 'Rizka Cantika Herman', 'prodi' => 'Akuntansi', 'sekolah' => 'SMKN 1 Bogor', 'hp' => '083876358632'],
            ['email' => 'zhahiraaaliyah@gmail.com', 'nama' => 'Aaliyah Zhahira Rangkuti', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'SMKN 1 BOGOR', 'hp' => '085771007105'],
            ['email' => 'tsaqieb.sabiluna@gmail.com', 'nama' => 'Tsaqieburrahman Sabiluna', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'PKBM AbHome', 'hp' => '089601416632'],
            ['email' => 'revosastaazzaro16@gmail.com', 'nama' => 'Revo Sasta Azzaro', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMKN 5 Kabupaten Tangerang', 'hp' => '085697344233'],
            ['email' => 'bungafitriah39@gmail.com', 'nama' => 'Bunga fitriah', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMA NEGERI 24 KAB TANGERANG', 'hp' => '081299324162'],
            ['email' => 'daaniysssr@gmail.com', 'nama' => 'Daaniys Hilyatur Rahmah', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 4 Kota Jambi', 'hp' => '082179923671'],
            ['email' => 'gracesitorus24@gmail.com', 'nama' => 'Grace Sitorus', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMA Budhaya II Santo Agustinus', 'hp' => '081386637289'],
            ['email' => 'callista.fanam@gmail.com', 'nama' => 'Callista Fairuz Fanam', 'prodi' => 'Sistem Informasi', 'sekolah' => 'SMAN 55 JAKARTA', 'hp' => '082258222235'],
            ['email' => 'araemon76@gmail.com', 'nama' => 'velisah zharah', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'sman4 cirebon', 'hp' => '088706317121'],
            ['email' => 'hmdmuhasan@gmail.com', 'nama' => 'Ahmad Muhasan', 'prodi' => 'Pendidikan Bahasa Inggris', 'sekolah' => 'MAS Tahfidz Alkaukab', 'hp' => '088973370448'],
            ['email' => 'sabrinaputeri1406@gmail.com', 'nama' => 'Sabrina Puteri Amanda', 'prodi' => 'Akuntansi', 'sekolah' => 'SMAN 49 Jakarta', 'hp' => '085717301622'],
            ['email' => 'keyllafelliashalom@gmail.com', 'nama' => 'Keylla Fellia Shalom', 'prodi' => 'Sains Komunikasi', 'sekolah' => 'SMAN 6 Bekasi', 'hp' => '6281291677876'],
            ['email' => 'rainaalmi08@gmail.com', 'nama' => 'Raina almi', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'SMAN 49 JAKARTA', 'hp' => '085179550827'],
            ['email' => 'angelsinulingga08@gmail.com', 'nama' => 'Angelica Agustin Sinulingga', 'prodi' => 'Manajemen', 'sekolah' => 'SMA Methodist 1 Medan', 'hp' => '082174232030'],
            ['email' => 'chesyacla@gmail.com', 'nama' => 'Chesya Iwanka Putri', 'prodi' => 'Manajemen', 'sekolah' => 'SMA Negeri 10 Depok', 'hp' => '089509384658'],
            ['email' => 'rizkisptra25@gmail.com', 'nama' => 'Rizki Saputra', 'prodi' => 'Design Komunikasi Visual', 'sekolah' => 'SMAN 106 JAKARTA', 'hp' => '083124755891'],
            ['email' => 'djavaonedls@gmail.com', 'nama' => 'Aisyah Cahaya Pelangi', 'prodi' => 'Manajemen', 'sekolah' => 'SMAN 1Dukupuntang', 'hp' => '081221696656'],
        ];

        $createdCount = 0;
        $updatedCount = 0;

        DB::transaction(function () use ($participants, $interviewer, $ruangan, &$createdCount, &$updatedCount) {
            foreach ($participants as $p) {
                $email = strtolower(trim($p['email']));
                $nama = trim($p['nama']);
                $prodi = trim($p['prodi']);
                $sekolah = trim($p['sekolah']);
                $hp = trim($p['hp']);

                // 1. Cari atau buat Akun pendaftar
                $akun = Akun::where('email', $email)->first();
                $isNew = false;

                if (!$akun) {
                    $akun = Akun::create([
                        'nama' => $nama,
                        'email' => $email,
                        'password' => Hash::make('MFLSJAYA!'),
                        'role' => 'pendaftar',
                        'email_verified_at' => now(),
                    ]);
                    $isNew = true;
                }

                // 2. Cari atau buat Peserta
                $peserta = Peserta::where('akun_id', $akun->id)->first();
                if (!$peserta) {
                    $peserta = Peserta::create([
                        'akun_id' => $akun->id,
                        'nama' => $nama,
                        'no_whatsapp' => $hp,
                        'nama_sekolah' => $sekolah,
                        'pilihan_prodi' => $prodi,
                        'status_seleksi_ujian' => 'lulus',
                        'interviewer_id' => $interviewer->id,
                        'ruangan' => $ruangan,
                    ]);
                } else {
                    $peserta->update([
                        'interviewer_id' => $interviewer->id,
                        'ruangan' => $ruangan,
                        'pilihan_prodi' => $prodi,
                        'status_seleksi_ujian' => 'lulus',
                    ]);
                }

                // 3. Cari atau buat Daftar
                $daftar = Daftar::where('peserta_id', $peserta->id)->first();
                if (!$daftar) {
                    Daftar::create([
                        'peserta_id' => $peserta->id,
                        'no_wa' => $hp,
                        'asal_sekolah' => $sekolah,
                        'status' => 'lulus',
                        'jenis_kelamin' => $peserta->jenis_kelamin ?? 'Laki-laki',
                        'tahun_lulus' => $peserta->tahun_lulus ?? 2024,
                        'ttl' => $peserta->tgl_lahir ?? '2006-01-01',
                        'provinsi' => $peserta->provinsi ?? '-',
                        'kabupaten' => $peserta->kabupaten ?? '-',
                    ]);
                } else {
                    $daftar->update([
                        'status' => 'lulus',
                    ]);
                }

                if ($isNew) {
                    $this->command->info("DIBUAT & DI-MAP: '$nama' ke $interviewer->nama di $ruangan");
                    $createdCount++;
                } else {
                    $this->command->info("DI-UPDATE & DI-MAP: '$nama' ke $interviewer->nama di $ruangan");
                    $updatedCount++;
                }
            }
        });

        $this->command->info("=== SEEDING SELESAI ===");
        $this->command->info("Total Akun Baru Dibuat & Di-map: $createdCount");
        $this->command->info("Total Akun Lama Di-update & Di-map: $updatedCount");
    }
}
