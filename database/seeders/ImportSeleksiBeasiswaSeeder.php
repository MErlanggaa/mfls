<?php

namespace Database\Seeders;

use App\Models\Daftar;
use App\Models\Peserta;
use App\Models\PenilaianAkademik;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportSeleksiBeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Data Input yang di-paste (digabungkan menjadi satu array besar)
        $rawText = "No.	Nama Lengkap	Asal Sekolah	Program Studi	Jenis Kelas	Skema Beasiswa
1	Raafi Achta Nadesta	SMAN 1 Klapanunggal	Sains Komunikasi	Exellent	75%
2	Atian Aprinina Banyu Asmara	SMK Avicenna Cileungsi	Sains Komunikasi	Exellent	75%
3	Ananda Fahri Ilham	SMKS 1 Barunawati	Sains Komunikasi	Exellent	75%
4	Rasya Herawan	MAN 5 Bogor	Sains Komunikasi	Exellent	75%
5	Najwa Mecca	SMK Muhammadiyah 1 Kota Tanggerang	Sains Komunikasi	Exellent	75%
6	Siti Nur Hasanah	SMA Yadika 3	Sains Komunikasi	Exellent	75%
7	Aisha Noormedina Wildani	SMA Pribadi 2	Sains Komunikasi	Exellent	75%
8	Novi Lubis	SMK YMIK	Sains Komunikasi	Exellent	75%
9	Oktavia Damayanti Manullang	SMAN 1 Klapanunggal	Sains Komunikasi	Exellent	75%
10	Muhammad Raihan Naufal	SMAN 1 Leuwisadeng	Sains Komunikasi	Exellent	75%
11	Muhammad Nauval Nawarudin	SMA Cenderawasih 1 Jakarta	Sains Komunikasi	Exellent	75%
12	Widy Nurani Syakila	SMAN 1 CIPEUNDEUY	Sains Komunikasi	Exellent	75%
13	Galuh Chandra Kirana	SMK AN-NUR KLAPANUNGGAL	Sains Komunikasi	Exellent	75%
14	Laura muthia kirana	SMAS SUGAR GROUP B MATARAM	Sains Komunikasi	Exellent	75%
15	Liani	SMAN 1 Leuwimunding	Sains Komunikasi	Exellent	75%
16	Rachmat Kusworo Wibowo	SMA PGRI 3 Jakarta	Sains Komunikasi	Exellent	75%
17	Fira Gebi Monica	SMAN 112 Jakarta	Sains Komunikasi	Exellent	75%
18	Azka Azkia Abdullah	SMAN 98 JAKARTA	Sains Komunikasi	Exellent	75%
1	Aelda Nurkhaila	SMKN 66 Jakarta	Manajemen	Exellent	75%
2	Naura Jihada Masiyana	SMAN 1 Cibinong	Manajemen	Exellent	75%
3	Aisyah Ar Rasyid Pakar	SMAIT Nurul Fikri Boarding School Bogor	Manajemen	Exellent	75%
4	Andrea Puspa Ningrum	SMAN 3 PADANG PANJANG	Manajemen	Exellent	75%
5	YOGA SAPUTRA	SMA PERMATA MANDIRI	Manajemen	Exellent	75%
6	Muhammad Riki Sudarman	SMA GLOBAL SOLUSI INDONESIA	Manajemen	Exellent	75%
7	Vannisya rahma Haliza	MAN 5 BOGOR	Manajemen	Exellent	75%
8	Bela Safira Octavia	SMKN 24 JAKARTA	Manajemen	Exellent	75%
9	Novrika Riona 	SMKN 65 Jakarta	Manajemen	Exellent	75%
10	Maryana Cecilia Sitorus	SMA Negeri 4 Ogan Komering Ulu	Manajemen	Exellent	75%
1	Ruth Alinansi Marbun	SMK TEKNOMEDIKA PLUS	Sains Komunikasi	50%
2	Nisfi Nurlaili	SMK BOASH 1	Sains Komunikasi	50%
3	Kirana Gumilangsari	SMK NEGERI 1 TASIKMALAYA	Desain Komunikasi Visual (DKV)	50%
4	Zahrah adeha	SMAN 1 PONTANG	Sains Komunikasi	50%
5	YULIA PERMATASARI	SMK NUSANTARA 1	Manajemen	50%
6	Nadatul munawaroh	SMK NEGERI 1 PETARUKAN	Manajemen	50%
7	Sabrina Caltha Chairunnisa	SMK ANNUR KLAPANUNGGAL	Desain Komunikasi Visual (DKV)	50%
8	SITI SOPIA	SMA NEGERI 2 PANDEGLANG	Manajemen	50%
9	Annisaul Mardhiyah Octavia	SMAS WACHID HASYIM 5 SURABAYA	Sistem Informasi	50%
10	Zahra Nanda Calista	SMAS TUNAS HARAPAN	Sains Komunikasi	50%
11	Muhammad Ghilman Azka	SMK NEGERI 3 BOGOR	Sains Komunikasi	50%
12	ARTA ULI BR MARINGGA	SMKS 1 YAPIM SIMPANG KAWAT	Manajemen	50%
13	Hilwah Nadzifah	SMK ERA PEMBANGUNAN	Akuntansi	50%
14	Zesica erlinda putri	SMAN 102 JAKARTA	Manajemen	50%
15	Ulya Zahro Maitsa	MAN 3 BOGOR	Manajemen	50%
16	Mahalika Amanda	SMAN 1 CARIU	Sains Komunikasi	50%
17	Octavia Rahmadanti	SMA NEGERI 33 JAKARTA	Manajemen	50%
18	TALITHA ADELA	SMAS AL-HUDA	Manajemen	50%
19	Adi Naufal Pratama	BAITUL HIDAYAH BOARDING SCHOOL	Sistem Informasi	50%
20	IBRAHIM MOVIC DIPONEGORO	SMKS YADIKA 2	Desain Komunikasi Visual (DKV)	50%
21	Dinda Agustina Santoso	SMKS YP KARYA BANGSA	Akuntansi	50%
22	RIKY PADRUROHMAN	SMAS PGRI 109 TANGERANG	Sains Komunikasi	50%
23	ULMILA SYARITA	SMAN 1 KABANDUNGAN	Sains Komunikasi	50%
24	Khoerunisa	SMAN 1 CIGUDEG	Desain Komunikasi Visual (DKV)	50%
25	Tubagus Rafly Hasanudin Yusuf	SMK YADIKA 2	Manajemen	50%
26	siti rohmah azzahra	SMAN 1 BATURRADEN	Manajemen	50%
27	Muhammad Ghifari Radityo	SMA NEGERI 78 JAKARTA	Sistem Informasi	50%
28	MUHAMMAD DAFAA	SMAN 1 PLOSOKLATEN	Sistem Informasi	50%
29	Salma Tani'ah	SMK MUHAMMADIYAH 2 CIKAMPEK	Sistem Informasi	50%
30	SITI AISYAH FEBRIANI	SMA NEGERI 2 SETU	Manajemen	50%
31	Nesya Laura Renata	SMAN 8 KOTA TANGERANG SELATAN	Sains Komunikasi	50%
32	Nazra Latizha Maulida	SMAN 3 KOTA SUKABUMI	Sains Komunikasi	50%
33	Julia Syafitri	SMA NEGERI 5 BEKASI	Sains Komunikasi	50%
34	SALSA HUSNA LATIFA	SMK NEGERI 1 PUNGGELAN	Sistem Informasi	50%
35	Muhammad Triyudha Asnan	SMAN 1 CIKARANG BARAT	Sains Komunikasi	50%
36	DIDIT MUHAMAD ILYAS	SMAS IT-TQ IHYA AS SUNNAH	Sains Komunikasi	50%
37	Bgas Fajar Sidiq	Ma al fadlilah	Manajemen	50%
38	Anayla	SMAN 112 JAKARTA	Manajemen	50%
39	Rivana Adelia	SMK SINAR HUSNI 1 BM L DELI DELISERDANG	Sains Komunikasi	50%
40	Muhammad Daidan Hilmy	SMAS YAPIDA	Desain Komunikasi Visual (DKV)	50%
41	CHELSI ADITIA	SMAN 19 JAKARTA	Manajemen	50%
42	Suci Ramadhani Dantjie	SMKN 65 JAKARTA	Manajemen	50%
43	nadine raysah syakieb	SMAN 14 KABUPATEN TANGERANG	Ilmu Komputer	50%
44	Nafisah Nailal Husna	SMKN 26 JKT	Manajemen	50%
45	Ariqah Fawwaz Talitha	SMAN 14 DEPOK	Sains Komunikasi	50%
46	Dea Fadilah	SMAS AL HUDA	Sains Komunikasi	50%
47	Shafiq Alief Faiz	SMAS IT YAPIDH	Sains Komunikasi	50%
48	Salwa Oktafiani	SMKN 24 JAKARTA	Manajemen	50%
49	Raditya Putra Wicaksana	SMK BINA NUSA MANDIRI	Pendidikan Bahasa Inggris	50%
50	Gabriella Karenhapukh Andrea Sinaga	SMK YADIKA 9 BINTARA	Sistem Informasi	50%
51	Inayah Rahmaniyah	SMAS AL HUDA CENGKARENG	Sains Komunikasi	50%
52	Karina Angelica	SMK NUSANTARA 1 JAKARTA	Akuntansi	50%
53	Raisa Octavia	SMAN 13 KOTA TANGERANG	Sains Komunikasi	50%
54	Karina	SMAN 1 BANYUASIN II	Manajemen	50%
55	Jenaya Soiya Hulu	SMAN 1 LAHEWA	Sains Komunikasi	50%
56	SYAFIRA ANGGRAENI	SMA NEGERI 57 JAKARTA	Pendidikan Matematika	50%
57	AHMAD DZAKY NASUTION	SMKN 2 BINJAI	Sistem Informasi	50%
58	Muhammad Rasid Afandi	MAN 2 AGAM	Sains Komunikasi	50%
59	MUHAMAD MISBAHUSSURUR	SMA NEGERI 3 KUNINGAN	Akuntansi	50%
60	Lutfi Anggraeni	SMA NEGERI 7 BEKASI	Sains Komunikasi	50%
61	Auriel amalya	Sma pgri 3 bogor	Sains Komunikasi	50%
62	Fadila Ayu Amelya	SMA NEGERI 1 GOMBONG	Manajemen	50%
63	Arya Gustaf Virgiansyah	SMKN 58	Sains Komunikasi	50%
64	Vina Agustina	MA DARUL HUDA	Akuntansi	50%
65	ISYCHA EMMARIEL RINGU LANGU	SMAS ST THOMAS AQUINAS	Akuntansi	50%
66	REZKY ANANDA YUSUF	SMAS SYARIF HIDAYATULLAH	Sains Komunikasi	50%
67	Andini Larassyati	MA KHAIRUL BARIYYAH	Akuntansi	50%
68	Kezia Jessica Christiani Simbolon	SMA SUTOMO 1 Medan	Pendidikan Bahasa Inggris	50%
69	KIARA ANAYA SYIEFANNY	SMAN 2 SEKAYU	Desain Komunikasi Visual (DKV)	50%
70	Aldo Radedo Siallagan	SMAN 84 JAKARTA	Sains Komunikasi	50%
71	Nayla Salsabila Assyifa	SMA NEGERI 1 BANYUMAS	Akuntansi	50%
72	NERA REPTIANA	SMAN 1 SINDANGBARANG	Manajemen	50%
73	Azizah Khairunnisa	SMK NEGERI 14 KOTA BEKASI	Manajemen	50%
74	Nabila Hamdi Sulaiman	SMKN 7 JAKARTA	Manajemen	50%
75	Yuki Meiliana Farosa	SMK AL-MAKMUR	Manajemen	50%
76	Richard Adriel Wong	MUADALAH RAFAH	Manajemen	50%
77	Anindya Ratiwi	SMA KARTIKA X-1	Akuntansi	50%
78	Tiara Citra Dewi	SMA NEGERI 109 JAKARTA	Manajemen	50%
79	Melinda Kesuma Dewi	SMAN 1 RANGKASBITUNG	Manajemen	50%
80	MUHAMMAD AULIYAA ALGOZALI	Smas Taman Islam	Sains Komunikasi	50%
81	Sensrifilka Faana	SMA NEGERI 1 SUNGAI AUR	Manajemen	50%
82	Wahidah Washifah Uzza Madiadipura	SMKS AL-MUHTADIN DEPOK	Manajemen	50%
83	ANDRA RAMADHAN SAHARA	SMA ISLAM AN NUQTHAH	Sains Komunikasi	50%
84	Nahwan Afdhal Ahmad	MAS DARUNNAIM	Sains Komunikasi	50%
85	Rafina Putri Julyanty	SMKN 24 JAKARTA	Manajemen	50%
86	Syifa Nurkamila	SMAN 1CIGOMBONG	Sistem Informasi	50%
87	Natasya Ahmi Safira	SMAN 15 BEKASI	Sains Komunikasi	50%
88	Aura Angelina Fasha	SMAN SITURAJA	Manajemen	50%
89	Bagas Abie Pratama	SMK YADIKA 2 JAKARTA	Manajemen	50%
90	DAVID VALENTINOTODA	SMK PRESTASI PRIMA	Sistem Informasi	50%
91	Ghina Khoirulmuna Az-zahra	SMKS BROSSA BROADCAST	Manajemen	50%
92	Brianya Aprilia Silitonga	SMA Negeri 2 Gunung Putri	Akuntansi	50%
93	SYIFA AULIA MAULANA	SMAN 1 CIKEMBAR	Sains Komunikasi	50%
94	ADITIA ABDUL AZIZ	SMKN 1 SUKABUMI	Sains Komunikasi	50%
95	NUR FEBBRIANIY RIVVANTI FATULAH	SMA KEBANGSAAN	Sains Komunikasi	50%
96	Ajeng prameitasari	SMA SULUH	Manajemen	50%
97	Suci Ramadhani	SMA NEGRI 1 SURADE	Sistem Informasi	50%
98	Rahmawati	SMA AZ ZAINIYYAH	Manajemen	50%
99	RAHMI DIANY	SMKN 5 TANGSEL	Sains Komunikasi	50%
100	PAIS ALIF FIRDAUS	Smk Yadika 2	Manajemen	50%
1	ALFIZAHRA KEISHADI	SMK TAMANSISWA 1 JAKARTA	Akuntansi	Reguler	75%
2	ISNA PUTRI ZAHROTUNNAFI'AH	SMAN 8 TAMBUN SELATAN	Akuntansi	Reguler	75%
3	ALYA LATHIFA SARI	SMK JAKARTA BARAT 1	Akuntansi	Reguler	75%
4	SITI ZAHRA JAMALLULAIL	SMKN 12 JAKARTA	Akuntansi	Reguler	75%
5	RISKA AMELIA	SMK TUNAS HARAPAN	Akuntansi	Reguler	75%
6	Arla Rahmania	SMK ASSADAH	Akuntansi	Reguler	75%
7	Nadia Rahma Az Zahra	SMAN 2 Purwakarta	Akuntansi	Reguler	75%
8	Ester Enjelina Aritonang	SMA RK Bintang Timur Rantauprapat	Akuntansi	Reguler	75%
9	ALFAN	SMKS YP KARYA BANGSA	Akuntansi	Reguler	75%
10	Dimaz Sugiactiranado Utomo	Pondok Pesantren Modern Al Ikhlash	Akuntansi	Reguler	75%
11	Yemima Eunike Pandiangan	SMAN 96 JAKARTA	Akuntansi	Reguler	75%
12	NASYIFAH NAILATUL IZZAH	SMKS BINA INSAN MANDIRI	Akuntansi	Reguler	75%
13	Fahira Sasti Ramadhani	SMK Negeri 12 Jakarta	Akuntansi	Reguler	75%
14	Khirana Try mulia	SMKS KARYA WIJAYA KUSUMA	Akuntansi	Reguler	75%
15	Shafira Fatimah Nurzahrah	SMK PKP 1 JAKARTA	Akuntansi	Reguler	75%
16	Fadlun Rahlil Ibrahim	MAN 2 CILACAP	Akuntansi	Reguler	75%
17	MUHAMMAD RIZIQ	MAN 5 BOGOR	Desain Komunikasi Visual (DKV)	Reguler	75%
18	Akbar Abdillah Chaidir	SMKS Bakti Idhata	Desain Komunikasi Visual (DKV)	Reguler	75%
19	Elena Madinata Berlian Firdaus	MAN 5 Bogor	Desain Komunikasi Visual (DKV)	Reguler	75%
20	SYIFA MEYLANI PUTRI	SMKN 64 JAKARTA	Desain Komunikasi Visual (DKV)	Reguler	75%
21	Dwi Oktavia	SMAN 8 Kota Bekasi	Manajemen	Reguler	75%
22	Naila Cahaya Mecca	SMAN 6 BEKASI	Manajemen	Reguler	75%
23	ORIZHA SATIVA LUTHFIA ILMI	SMAS ADI LUHUR JAKARTA	Manajemen	Reguler	75%
24	NAUFAL ABDILLAH PRATAMA	SMK YADIKA 2	Manajemen	Reguler	75%
25	Wiranata	SMK Nusantara 1	Manajemen	Reguler	75%
26	Putri Pebyanti	SMK Madya Depok	Manajemen	Reguler	75%
27	Afrizal Rizky Setiawan	SMA AL-HUDA	Manajemen	Reguler	75%
28	Sekar puji lestari	SMAN 1 MANDIRANCAN	Manajemen	Reguler	75%
29	Abyan Dzaky Haidar	SMA ADI LUHUR JAKARTA	Manajemen	Reguler	75%
30	FRIZKA MAWARNI	SMKS BINA INSANI	Manajemen	Reguler	75%
31	Tiara Dewi Lestari	SMK NEGERI 1	Manajemen	Reguler	75%
32	Andre Septyo Mardianto	SMAN 1 KENDAL	Manajemen	Reguler	75%
33	Rotua Angelina	SMA NEGERI 2 MANDAU	Manajemen	Reguler	75%
34	Salwa Oktarina	MAN 1 KOTA BENGKULU	Manajemen	Reguler	75%
35	Sifa Savitri	MAN 1 SUKABUMI	Manajemen	Reguler	75%
36	Aqwam Iqomudinillah	SMAS TAMAN ISLAM	Manajemen	Reguler	75%
37	AMALYA RAMADHANTI	SMKN 6 Kab. Tangerang	Manajemen	Reguler	75%
38	Diana Nabilla 	SMA Plus Cendikia Cikeas	Manajemen	Reguler	75%
39	Mas Ayu Anindya Marsha Nikita	MAN 5 Bogor	Manajemen	Reguler	75%
40	Ayu Wulandari	SMKS YMIK 	Manajemen	Reguler	75%
41	Naila Rohimatus Sa'diyah	SMKN 1 KERSANA	Manajemen	Reguler	75%
42	Sri Wulan	SMA NEGERI 20 JAKARTA	Pendidikan Bahasa Inggris	Reguler	75%
43	Keysa Nazira Kaila	MAN 20 Jakarta	Pendidikan Bahasa Inggris	Reguler	75%
44	Luzzeina Nadila Yusuf	SMAN 10 GARUT	Pendidikan Matematika	Reguler	75%
45	Nanda Gadis Supriadi	SMKS Bina Putra Mandiri	Sains Komunikasi	Reguler	75%
46	Nabila Annastasya	SMK PLUIT RAYA	Sains Komunikasi	Reguler	75%
47	Syahna Amalia Safira	MAN 5 Bogor	Sains Komunikasi	Reguler	75%
48	Isna Afifah Wijoyoningrum	MAN 5 Bogor	Sains Komunikasi	Reguler	75%
49	Kartika Juliati Silaen	SMKN 49 Jakarta	Sains Komunikasi	Reguler	75%
50	Nazwa Sheshicha	SMA Yadika 8	Sains Komunikasi	Reguler	75%
51	Joceline Kania Manurung	SMAS YADIKA 13 TAMBUN	Sains Komunikasi	Reguler	75%
52	Maria Gracia	SMA Strada Bhakti Wiyata	Sains Komunikasi	Reguler	75%
53	Pebrian Suhendiawan	SMA PGRI 4	Sains Komunikasi	Reguler	75%
54	Keisha Aulia Putri Anggraini	MAN 1 KOTA BOGOR	Sains Komunikasi	Reguler	75%
55	Alika Yasmin Fawwaz	Sman 2 Babelan	Sains Komunikasi	Reguler	75%
56	KIRANA FAADHILAH HISAANAH	SMAN 1 CILIMUS	Sains Komunikasi	Reguler	75%
57	VIONA FATMA RAHAYU	SMAN 17 Jakarta	Sains Komunikasi	Reguler	75%
58	TSABITA RAHNI SALSABILLA	SMAN 15 BEKASI	Sains Komunikasi	Reguler	75%
59	Muhammad Dhiyaur Ramadhan Bakhr	Pondok Pesantren Rafah	Sains Komunikasi	Reguler	75%
60	ADELIA MANDASARI	SMK NEGERI 4 BANDAR LAMPUNG	Sains Komunikasi	Reguler	75%
61	Siti Sahila Tansa	SMKN 3 BUNGO	Sains Komunikasi	Reguler	75%
62	Risa Aura Ramadani	SMAN 2 MANDAU	Sains Komunikasi	Reguler	75%
63	Davina fransisca laura	SMAN 1 CILIMUS	Sains Komunikasi	Reguler	75%
64	Siti Kayla	SMKN 8 JAKARTA	Sains Komunikasi	Reguler	75%
65	Nazwa Marfa Putri	SMA Negeri 4 Kepahiang	Sains Komunikasi	Reguler	75%
66	Naima Aulia zahara	SMA NEGERI 3 KUNINGAN	Sains Komunikasi	Reguler	75%
67	Putri Wulandari	SMAN 1 Wonosobo	Sains Komunikasi	Reguler	75%
68	Marsudi Sujatmiko	MAN 2 CILACAP	Sains Komunikasi	Reguler	75%
69	DEMA EFRIYANTI	MAN 1 OKU	Sains Komunikasi	Reguler	75%
70	Tanti inda lestari	SMA Negeri 1 Abung Kunang	Sains Komunikasi	Reguler	75%
71	Zahra Awliya Ramadhani	SMAN 1 CIRUAS	Sains Komunikasi	Reguler	75%
72	REVINA DEA ARIPIANTI	SMK N 1 CILEUNGSI	Sains Komunikasi	Reguler	75%
73	Shabrina Aqilah Hanin	SMA Sugar Group	Sains Komunikasi	Reguler	75%
74	Sabbah Muhtarisah Al-muqtashidah	MAN 2 CILACAP	Sains Komunikasi	Reguler	75%
75	PUTRIYANI AYU KUSUMA	SMK BINA PUTRA MANDIRI	Sistem Informasi	Reguler	75%
76	Nasywa Adelia Putri	Pondok Pesantren Modern Darussalam Gontor Putri 1	Sistem Informasi	Reguler	75%
77	SATRIA CAHAYA MULYA	SMKS BINA PUTRA MANDIRI	Sistem Informasi	Reguler	75%
78	Dalilah Rohmah	SMKN 24 Jakarta	Sistem Informasi	Reguler	75%
79	Rhezita Zahira	MAN 1 Kota Tangerang	Sistem Informasi	Reguler	75%
80	AZRIEL AZIZ BAZLIA SUYONO	SMK SEJAHTERA JAKARTA	Sistem Informasi	Reguler	75%
81	DINDA NADHIRA AMALYA	SMAN 3 TAMBUN SELATAN	Sistem Informasi	Reguler	75%
82	NAZILLA AULIANTI	SMKN 45 JAKARTA	Sistem Informasi	Reguler	75%
83	Muhammad Salman	Madrasah Aliyah Ar Rahmat	Sistem Informasi	Reguler	75%
84	Eka Fitria Nurrohmah	SMA NEGRI 1 MAGETAN	Sistem Informasi	Reguler	75%
85	Erin Afrillia	SMAN 2 SUNGAI KERUH	Sistem Informasi	Reguler	75%
86	Moch Dziqri Al Ghifari	SMAN 25 GARUT	Sistem Informasi	Reguler	75%
87	Aulia Latifatul Mutmainnah	MAN 2 Kota Madiun	Sistem Informasi	Reguler	75%
88	Cita Aulan Hasanah	SMAN 2 Mandau	Sistem Informasi	Reguler	75%
89	Rinaldi Siburian	SMKN 53 Jakarta	Sistem Informasi	Reguler	75%
1	Muhammad Faisal	SMK Prima Unggul	Akuntansi	Reguler	100%
2	Raihan Firdaus Rabbani	SMAN 20 Jakarta	Akuntansi	Reguler	100%
3	Ilham Fathan Khairul	PKBM Semesta Ilmu	Akuntansi	Reguler	100%
4	Siti Khaerunnisa 	MA Khairul Ummah	Akuntansi	Reguler	100%
5	Sinar Suryono	SMAS Yupentek 1 Tanggerang	Akuntansi	Reguler	100%
6	Cahaya Eka Rahayu	SMK NEGERI KARANGPUCUNG	Akuntansi	Reguler	100%
7	Zaidan Rifki	SMK Negeri 1 Kersana	Akuntansi	Reguler	100%
8	Galang A'yad Fitran Aldian	SMK Bakti 17	Desain Komunikasi Visual (DKV)	Reguler	100%
9	Chelsea Narciss Fissicella	SMAN 80 Jakarta	Desain Komunikasi Visual (DKV)	Reguler	100%
10	Arka Aditya	SMK Kusuma Bangsa Bogor	Desain Komunikasi Visual (DKV)	Reguler	100%
11	Abimanyu Eka Prasetya	SMKN 2 Depok	Desain Komunikasi Visual (DKV)	Reguler	100%
12	RAZZY ADETYA SYAHPUTERA	MAN 2 Kota Batam	Desain Komunikasi Visual (DKV)	Reguler	100%
13	Aleem Ahmad Ibnu Syams	SMK Boash 1	Desain Komunikasi Visual (DKV)	Reguler	100%
14	Muhammad Raihan Zaky	SMK Tamansiswa 1 Jakarta	Desain Komunikasi Visual (DKV)	Reguler	100%
15	Samuel Marbun	SMK Prestasi Prima	Ilmu Komputer	Reguler	100%
16	Zeid Held Tirta Zaputra	SMK Prestasi Prima	Ilmu Komputer	Reguler	100%
17	Indria Syifa Pratiwi	SMK Informatika Utama	Ilmu Komputer	Reguler	100%
18	Gabriel Taliak	SMA NEGERI 5 MALUKU BARAT DAYA	Ilmu Komputer	Reguler	100%
19	Nazma Mariyam Alawiyah	SMAN 1 Ciawi Bogor	Ilmu Komputer	Reguler	100%
20	Mahalia Putri Aprilli	SMAN 1 Parungpanjang	Pendidikan Matematika	Reguler	100%
21	Aldo Prayoga	SMA Yadika 1 Duri Kepa	Pendidikan Matematika	Reguler	100%
22	Faturohman	MAS Sabilurrahman	Pendidikan Matematika	Reguler	100%
23	Zahro Aema Shodikokh	SMA Boash	Pendidikan Matematika	Reguler	100%
24	Muhamad Hafidz Aryadillah	MAN 5 Bogor	Pendidikan Matematika	Reguler	100%
25	Maria Magdalena Putri Do Karmo	SMAK Bhakti Luhur Malang	Pendidikan Matematika	Reguler	100%
26	ELMEERA RADHIYA REZQYA BASARI	SMAN 1 WANAYASA	Pendidikan Matematika	Reguler	100%
27	Intania Setia Rahayu	SMAN 1 BANDUNG	Pendidikan Matematika	Reguler	100%
28	Hana Zahra	SMAN 1 Menggala	Pendidikan Matematika	Reguler	100%
29	Raihan	SMAS Taman Islam	Pendidikan Bahasa Inggris	Reguler	100%
30	Johanes Buller Imanuel Sitompul	SMK MIGAS Balongan	Pendidikan Bahasa Inggris	Reguler	100%
31	Izzan Azzhilan Afhal	SMAN 2 Padalarang	Pendidikan Bahasa Inggris	Reguler	100%
32	Cindi Nur Apriliani	MAN 5 Bogor	Pendidikan Bahasa Inggris	Reguler	100%
33	Regita Hermayanti	MAS Al-Ghazaly Kota Bogor	Pendidikan Bahasa Inggris	Reguler	100%
34	Olivia	SMAN 1 Ciomas	Pendidikan Bahasa Inggris	Reguler	100%
35	Puja Melisa Oktapiani	MAN 2 Cirebon	Sistem Informasi	Reguler	100%
36	Marcel Sandika	MAN 1 Kota Tanggerang	Sistem Informasi	Reguler	100%
37	Nur Tyas Putri Asep Rahmadi	MAS Darunna'im	Sistem Informasi	Reguler	100%
38	Willy Alimudin	SMAN SITURAJA	Sistem Informasi	Reguler	100%
39	Risky Aditya Saputra	MA Miftahul Amal	Manajemen	Reguler	100%
40	Shofia latifah	SMA GENRUS NUSANTARA BOARDING SCHOOL	Manajemen	Reguler	100%
41	Hilman Ali Muchsin	MAN 5 Bogor	Manajemen	Reguler	100%
42	Nurina Tarini	SMKS YP IPPI Petojo	Manajemen	Reguler	100%
43	Faiqa Hadiya	SMA Negeri 1 Cigombong	Manajemen	Reguler	100%
44	Sohibul Milah	SMAN 1 Campaka	Manajemen	Reguler	100%
45	Raffa Athalariq	SMAN 2 KabupatenTanggerang	Manajemen	Reguler	100%
46	Alwan Sandi Devansyah	SMAS Pramita Curug	Sains Komunikasi	Reguler	100%
47	Derliano Fiqry Farhansyah	SMAN 17 Kabupaten Tanggerang	Sains Komunikasi	Reguler	100%
48	Nasya Alzeta Mulera	SMAN 15 Palembang	Sains Komunikasi	Reguler	100%
49	Abadani Ahda	SMKN 3 Kota Bekasi	Sains Komunikasi	Reguler	100%
50	Abdul Hafiz	MAN 2 Bandung	Sains Komunikasi	Reguler	100%";

        $lines = preg_split('/\r\n|\r|\n/', trim($rawText));
        $countSuccess = 0;
        $countFail = 0;

        $adminUser = DB::table('akun')->whereIn('role', ['admin', 'palugada'])->first();
        $adminId = $adminUser ? $adminUser->id : 1;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $cols = preg_split('/\t/', $line);
            if (count($cols) < 5) continue;

            $first = strtolower(trim($cols[0]));
            if (in_array($first, ['no', 'no.', 'no,']) || !is_numeric(trim($cols[0]))) continue;

            $nama    = trim($cols[1]);
            $sekolah = trim($cols[2]);
            $prodi   = trim($cols[3]);
            
            if (count($cols) == 5) {
                $kelas    = 'Reguler';
                $beasiswa = trim($cols[4]);
            } else {
                $kelas    = trim($cols[4]);
                $beasiswa = trim($cols[5]);
            }

            // Normalisasi Beasiswa
            $beasiswa = preg_replace('/[^0-9%]/', '', $beasiswa);
            if (empty($beasiswa)) $beasiswa = '75%';
            if (strpos($beasiswa, '%') === false) $beasiswa .= '%';

            // Normalisasi Kelas
            $kelasLabel = ucfirst(strtolower($kelas));
            if (stripos($kelasLabel, 'exel') !== false || stripos($kelasLabel, 'excel') !== false) {
                $kelasLabel = 'Exellent';
            } elseif (stripos($kelasLabel, 'eksekutif') !== false || stripos($kelasLabel, 'executive') !== false) {
                $kelasLabel = 'Eksekutif';
            } else {
                $kelasLabel = 'Reguler';
            }

            // Cari peserta di database
            $peserta = Peserta::where('nama', $nama)->first()
                ?? Peserta::whereRaw('LOWER(TRIM(nama)) = ?', [strtolower(trim($nama))])->first()
                ?? Peserta::where('nama', 'like', '%' . trim($nama) . '%')->first();

            if (!$peserta) {
                $this->command->warn("Kandidat TIDAK DITEMUKAN: {$nama}");
                $countFail++;
                continue;
            }

            $daftar = $peserta->daftar;

            // Jika peserta sudah lulus sebelumnya, kita skip agar tidak menimpa/error
            if ($daftar && $daftar->status === 'lulus') {
                $this->command->line("Kandidat SUDAH DIPROSES (Skip): {$nama}");
                continue;
            }

            if ($daftar) {
                $daftar->update([
                    'nominal_beasiswa' => $beasiswa,
                    'status'           => 'lulus',
                ]);
            } else {
                Daftar::create([
                    'peserta_id'       => $peserta->id,
                    'nominal_beasiswa' => $beasiswa,
                    'status'           => 'lulus',
                ]);
            }

            // Update/Create Penilaian Akademik
            PenilaianAkademik::updateOrCreate(
                ['peserta_id' => $peserta->id],
                [
                    'penilai_id'             => $adminId,
                    'rekomendasi_prodi_1'    => $prodi,
                    'rekomendasi_kelas'      => $kelasLabel,
                    'rekomendasi_beasiswa'   => 'Beasiswa ' . $beasiswa,
                    'rekomendasi_akhir'      => 'Lolos',
                ]
            );

            $this->command->info("BERHASIL UPDATE: {$peserta->nama} -> {$prodi} ({$kelasLabel}) [{$beasiswa}]");
            $countSuccess++;
        }

        $this->command->info("=== SEEDING SELESAI ===");
        $this->command->info("Total Berhasil: {$countSuccess}");
        $this->command->warn("Total Gagal/Tidak Ditemukan: {$countFail}");
    }
}
