@extends('layouts.user')

@section('content')
<!-- Hero Section -->
<div id="home" class="relative overflow-hidden bg-white pt-12 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Column: Text Content -->
            <div class="text-center lg:text-left space-y-8 scroll-fade-left">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-dark-navy leading-tight">
                  MNCU 
                    <span class="text-primary-yellow">Future</span> Leader
                    Scholarship
                </h1>
                
                <p class="text-xl text-gray-700 font-semibold">
                    Beasiswa Kuliah Up To 100% hingga lulus<br>
                     di Media Nusantara Citra University
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="/register" class="bg-primary-yellow hover:bg-primary-yellow-hover text-white px-8 py-4 rounded-full text-base font-bold shadow-lg hover:shadow-xl transition-all duration-300"> 
                        <i class="fas fa-rocket me-2"></i>
                        Daftar Sekarang
                    </a>
                    <a href="https://whatsapp.com/channel/0029VbC0L7I6hENrmgrr9D3D" target="_blank" class="flex items-center justify-center gap-2 text-dark-navy font-semibold hover:text-primary-yellow transition-colors">
                        Gabung Saluran WhatsApp
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>
            
            <!-- Right Column: Hero Image -->
            <!-- Right Column: Hero Image -->
            <div class="relative w-full scroll-fade-right mt-8 lg:mt-0">
                <img src="{{ asset('icon/mnclogo.jpg') }}" alt="MNCU Future Leader Scholarship" class="w-full h-auto rounded-[2.5rem] shadow-2xl hover:scale-[1.02] transition-transform duration-500 border-4 border-white/50">
                <!-- Decorative element -->
                <div class="absolute -z-10 top-10 -right-10 w-32 h-32 bg-primary-yellow/20 rounded-full blur-2xl"></div>
                <div class="absolute -z-10 -bottom-10 -left-10 w-32 h-32 bg-primary-blue/20 rounded-full blur-2xl"></div>
            </div>
        </div>
    </div>
</div>

<!-- Countdown Section -->
<div class="bg-white py-0 scroll-fade">
    <div class="w-full">
        <!-- Yellow Top Border -->
        <div class="h-2 bg-primary-yellow"></div>
        
        <!-- Blue Bar with Countdown -->
        <div class="bg-primary-blue py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h3 class="text-primary-yellow font-caveat font-semibold text-3xl mb-2">Daftar Sekarang!</h3>
                    <h2 class="text-xl font-bold text-white">Pendaftaran akan ditutup dalam</h2>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 max-w-5xl mx-auto">
                    <div class="text-center p-4 rounded-2xl md:bg-transparent bg-white/5 md:shadow-none shadow-lg backdrop-blur-sm border border-white/10 md:border-none">
                        <div id="days" class="text-4xl md:text-6xl lg:text-7xl font-black text-primary-yellow mb-1 md:mb-2">00</div>
                        <div class="text-xs md:text-base lg:text-lg font-bold text-white md:text-primary-yellow uppercase tracking-widest">Hari</div>
                    </div>
                    <div class="text-center p-4 rounded-2xl md:bg-transparent bg-white/5 md:shadow-none shadow-lg backdrop-blur-sm border border-white/10 md:border-none">
                        <div id="hours" class="text-4xl md:text-6xl lg:text-7xl font-black text-primary-yellow mb-1 md:mb-2">00</div>
                        <div class="text-xs md:text-base lg:text-lg font-bold text-white md:text-primary-yellow uppercase tracking-widest">Jam</div>
                    </div>
                    <div class="text-center p-4 rounded-2xl md:bg-transparent bg-white/5 md:shadow-none shadow-lg backdrop-blur-sm border border-white/10 md:border-none">
                        <div id="minutes" class="text-4xl md:text-6xl lg:text-7xl font-black text-primary-yellow mb-1 md:mb-2">00</div>
                        <div class="text-xs md:text-base lg:text-lg font-bold text-white md:text-primary-yellow uppercase tracking-widest">Menit</div>
                    </div>
                    <div class="text-center p-4 rounded-2xl md:bg-transparent bg-white/5 md:shadow-none shadow-lg backdrop-blur-sm border border-white/10 md:border-none">
                        <div id="seconds" class="text-4xl md:text-6xl lg:text-7xl font-black text-primary-yellow mb-1 md:mb-2">00</div>
                        <div class="text-xs md:text-base lg:text-lg font-bold text-white md:text-primary-yellow uppercase tracking-widest">Detik</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Yellow Bottom Border -->
        <div class="h-2 bg-primary-yellow"></div>
    </div>
</div>

<!-- About Section with Photos -->
<div id="about" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-20 items-start">
            <!-- Left: Text + Stats (3 columns) -->
            <div class="lg:col-span-3 scroll-fade-left">
                <h3 class="text-primary-yellow font-caveat font-semibold text-2xl mb-4">Tentang Kami</h3>
                <h2 class="text-4xl md:text-5xl font-black text-dark-navy mb-8 leading-tight">MNCU Future Leader Scholarship</h2>
                
                <div class="space-y-6 text-gray-700 leading-relaxed mb-12">
                    <p>
MNCU Future Leader Scholarship adalah program beasiswa yang diberikan oleh MNC Group kepada calon mahasiswa berprestasi untuk melanjutkan pendidikan di MNC University. Program ini bertujuan untuk mencetak generasi muda yang unggul, inovatif, dan berjiwa kepemimpinan, dengan memberikan kesempatan kuliah hingga 100%.                    </p>
                    <p>
Melalui beasiswa ini, penerima tidak hanya mendapatkan dukungan finansial, tetapi juga akses pada lingkungan pendidikan yang berkualitas dan terintegrasi dengan dunia industri, khususnya di bidang bisnis, keuangan, teknologi, dan industri kreatif.                    </p>
                </div>
                
                <!-- Stats Grid 2x2 -->
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div class="stat-item text-center lg:text-left">
                        <div class="text-5xl md:text-6xl font-black text-dark-navy mb-2">2</div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Kampus</div>
                    </div>
                    <div class="stat-item text-center lg:text-left">
                        <div class="text-5xl md:text-6xl font-black text-dark-navy mb-2">2</div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Fakultas</div>
                    </div>
                    <div class="stat-item text-center lg:text-left">
                        <div class="text-5xl md:text-6xl font-black text-dark-navy mb-2">8</div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Program Studi</div>
                    </div>
                    <div class="stat-item text-center lg:text-left">
                        <div class="text-5xl md:text-6xl font-black text-dark-navy mb-2">90+</div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Kemitraan</div>
                    </div>
                </div>
                
                <!-- Link Selengkapnya -->
                <a href="#" id="selengkapnya-btn" class="inline-flex items-center gap-2 text-primary-yellow font-bold hover:gap-4 transition-all">
                    Selengkapnya
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
            
            <!-- Right: Staggered Photo Collage (2 columns) -->
            <div class="lg:col-span-2 scroll-fade-right">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Top Right -->
                    <div class="col-start-2">
                        <img src="{{ asset('icon/Student1.png') }}" alt="Students Photo 1" class="rounded-2xl shadow-lg w-full h-64 object-cover">
                    </div>
                    
                    <!-- Middle Left -->
                    <div class="col-start-1 row-start-2">
                        <img src="{{ asset('icon/seminar2.jpeg') }}" alt="Seminar Photo 2" class="rounded-2xl shadow-lg w-full h-48 object-cover">
                    </div>
                    
                    <!-- Middle Right -->
                    <div class="col-start-2 row-start-2">
                        <img src="{{ asset('icon/group3.jpeg') }}" alt="Group Photo 3" class="rounded-2xl shadow-lg w-full h-48 object-cover">
                    </div>
                    
                    <!-- Bottom Left -->
                    <div class="col-start-1 row-start-3">
                        <img src="{{ asset('icon/student4.jpeg') }}" alt="Students Photo 4" class="rounded-2xl shadow-lg w-full h-64 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Program Studi -->
<div id="program-studi-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden opacity-0 transition-all duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl max-w-6xl w-full max-h-[90vh] overflow-y-auto transform scale-95 transition-all duration-300" id="modal-content">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-gray-100 p-8 rounded-t-3xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-black text-dark-navy">Program Studi MNCU</h2>
                        <p class="text-gray-600 mt-2">Pilih program studi sesuai minat dan bakatmu</p>
                    </div>
                    <button id="close-modal" class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-8">
                <!-- Fakultas Bisnis dan Keuangan -->
                <div class="mb-12">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 bg-primary-yellow/10 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-dark-navy">Fakultas Bisnis dan Keuangan</h3>
                            <p class="text-gray-600">Mempersiapkan lulusan yang kompeten di bidang bisnis dan keuangan</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach([
                            ['name' => 'Manajemen', 'desc' => 'Mempelajari strategi bisnis, kepemimpinan, dan pengelolaan organisasi modern', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            ['name' => 'Akuntansi', 'desc' => 'Fokus pada pencatatan, analisis, dan pelaporan keuangan perusahaan', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                            ['name' => 'Pendidikan Matematika', 'desc' => 'Mempersiapkan pendidik matematika yang profesional dan inovatif', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z']
                        ] as $prodi)
                        <div class="bg-gradient-to-br from-gray-50 to-white p-6 rounded-2xl border border-gray-100 hover:border-primary-yellow hover:shadow-lg transition-all duration-300 group">
                            <div class="w-12 h-12 bg-primary-yellow/10 group-hover:bg-primary-yellow/20 rounded-xl flex items-center justify-center mb-4 transition-colors">
                                <svg class="w-6 h-6 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $prodi['icon'] }}"/></svg>
                            </div>
                            <h4 class="font-bold text-dark-navy text-lg mb-2">{{ $prodi['name'] }}</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $prodi['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Fakultas Industri dan Kreatif -->
                <div>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 bg-primary-yellow/10 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-dark-navy">Fakultas Industri dan Kreatif</h3>
                            <p class="text-gray-600">Mengembangkan talenta kreatif dan teknologi untuk masa depan</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach([
                            ['name' => 'Pendidikan Bahasa Inggris', 'desc' => 'Mempersiapkan pendidik bahasa Inggris yang kompeten dan berdaya saing global', 'icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'],
                            ['name' => 'Sains Komunikasi', 'desc' => 'Mempelajari teori dan praktik komunikasi di era digital dan media massa', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                            ['name' => 'Desain Komunikasi Visual', 'desc' => 'Mengembangkan kreativitas dalam desain grafis, branding, dan komunikasi visual', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5a2 2 0 00-2-2z'],
                            ['name' => 'Ilmu Komputer', 'desc' => 'Fokus pada pengembangan software, algoritma, dan teknologi komputer terdepan', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                            ['name' => 'Sistem Informasi', 'desc' => 'Menggabungkan teknologi informasi dengan manajemen bisnis untuk solusi digital', 'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4']
                        ] as $prodi)
                        <div class="bg-gradient-to-br from-gray-50 to-white p-6 rounded-2xl border border-gray-100 hover:border-primary-yellow hover:shadow-lg transition-all duration-300 group">
                            <div class="w-12 h-12 bg-primary-yellow/10 group-hover:bg-primary-yellow/20 rounded-xl flex items-center justify-center mb-4 transition-colors">
                                <svg class="w-6 h-6 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $prodi['icon'] }}"/></svg>
                            </div>
                            <h4 class="font-bold text-dark-navy text-lg mb-2">{{ $prodi['name'] }}</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $prodi['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- CTA Section -->
                <div class="mt-12 text-center p-8 bg-gradient-to-r from-primary-yellow/10 to-primary-yellow/5 rounded-2xl border border-primary-yellow/20">
                    <h4 class="text-xl font-bold text-dark-navy mb-4">Tertarik dengan Program Studi di Atas?</h4>
                    <p class="text-gray-600 mb-6">Daftar sekarang dan raih kesempatan mendapatkan beasiswa penuh!</p>
                    <a href="/register" class="inline-flex items-center gap-2 bg-primary-yellow hover:bg-primary-yellow-hover text-dark-navy px-8 py-3 rounded-full font-bold transition-all hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        Daftar Beasiswa Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timeline Section -->
<div id="timeline" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-black text-dark-navy text-center mb-16 fade-in">Jadwal dan Tahapan Seleksi</h2>
        
        <!-- Vertical Timeline -->
        <div class="relative fade-in max-w-4xl mx-auto">
            @php
                $timeline = [
                    ['title' => 'Pendaftaran', 'date' => '16 Maret - 04 Mei 2026', 'active' => true],
                    ['title' => 'Pengumuman Hasil seleksi Administrasi', 'date' => '7 Mei 2026', 'active' => false],
                    ['title' => 'TPS, LBI & Pemetaan Diri', 'date' => '18 Mei 2026', 'active' => false],
                    ['title' => 'Company Visit & Sit In Class', 'date' => '21 - 22 Mei 2026', 'active' => false],
                    ['title' => 'Interview ', 'date' => '23 Mei 2026', 'active' => false],
                    ['title' => 'Awarding', 'date' => '30 Mei 2026', 'active' => false],
                ];
            @endphp
            
            <!-- Vertical Line -->
            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-primary-yellow"></div>
            
            @foreach($timeline as $index => $item)
            <div class="relative flex items-start mb-12 last:mb-0">
                <!-- Dot -->
                <div class="relative z-10 mr-8">
                    @if($item['active'])
                        <div class="relative w-6 h-6">
                            <div class="absolute inset-0 bg-primary-yellow rounded-full animate-ping"></div>
                            <div class="relative w-6 h-6 bg-primary-yellow rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                    @else
                        <div class="w-6 h-6 bg-primary-yellow rounded-full border-4 border-white shadow-lg"></div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="flex-1 bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 {{ $item['active'] ? 'border-primary-yellow bg-primary-yellow/5' : '' }}">
                    <h4 class="font-bold text-lg {{ $item['active'] ? 'text-primary-yellow' : 'text-dark-navy' }} mb-2">
                        {{ $item['title'] }}
                    </h4>
                    <p class="text-sm {{ $item['active'] ? 'text-primary-yellow font-semibold' : 'text-gray-600' }}">
                        <i class="fas fa-calendar-alt mr-2"></i>{{ $item['date'] }}
                    </p>
                    @if($item['active'])
                        <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full bg-primary-yellow text-white text-xs font-semibold">
                            <i class="fas fa-clock mr-1"></i>Sedang Berlangsung
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Exclusive MNC Group Benefits -->
<div class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-fade">
            <h3 class="text-primary-yellow font-caveat font-semibold text-2xl mb-4">Benefit Eksklusif</h3>
            <h2 class="text-4xl md:text-5xl font-black text-dark-navy mb-6 leading-tight">Melangkah Lebih Jauh Bersama MNC University</h2>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left: 5 Benefits -->
            <div class="space-y-6 order-2 lg:order-1">
                <!-- Benefit 1 -->
                <div class="bg-gray-50 p-6 rounded-2xl hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-primary-yellow rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-dark-navy mb-2">Dukungan Biaya Kuliah Hingga 100%</h4>
                            <p class="text-gray-600 text-sm">Mendapat keringanan biaya kuliah hingga potongan penuh sesuai kategori beasiswa.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Benefit 2 -->
                <div class="bg-gray-50 p-6 rounded-2xl hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-dark-navy rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-dark-navy mb-2">Program Pengembangan Kepemimpinan & Mentorship</h4>
                            <p class="text-gray-600 text-sm">Pelatihan leadership, personal branding, dan bimbingan langsung dari praktisi MNC Group.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Benefit 3 -->
                <div class="bg-gray-50 p-6 rounded-2xl hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-primary-yellow rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-dark-navy mb-2">Site In Class & Company Visit MNC Group</h4>
                            <p class="text-gray-600 text-sm">Belajar langsung di lingkungan industri serta unit bisnis MNC Group untuk mendapatkan pengalaman nyata.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Benefit 4 -->
                <div class="bg-gray-50 p-6 rounded-2xl hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-dark-navy rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-dark-navy mb-2">Kesempatan Magang di MNC Group</h4>
                            <p class="text-gray-600 text-sm">Dapat pengalaman kerja profesional di berbagai divisi sesuai bidang studi dan minat karier.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Benefit 5 -->
                <div class="bg-gray-50 p-6 rounded-2xl hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-primary-yellow rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-dark-navy mb-2">Networking & Sertifikat Participation</h4>
                            <p class="text-gray-600 text-sm">Bertemu dengan siswa/siswi berprestasi, saling belajar dan tumbuh bersama calon pemimpin serta mendapatkan sertifikat resmi dari MNC University.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right: Image -->
            <div class="relative order-1 lg:order-2">
                <img src="{{ asset('icon/Keuntungan.jpeg') }}" alt="Benefit Keuntungan" class="rounded-3xl shadow-2xl w-full object-cover">
            </div>
        </div>
    </div>
</div>

<!-- Syarat dan Ketentuan Section -->
<div id="requirements" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in">
            <h3 class="text-primary-yellow font-caveat font-semibold text-2xl mb-2">Persyaratan</h3>
            <h2 class="text-4xl font-black text-dark-navy">Syarat dan Ketentuan</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Pastikan Anda memenuhi semua persyaratan berikut sebelum mendaftar</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <!-- Left: Requirements List -->
            <div class="scroll-fade-left">
                <h3 class="text-2xl font-bold text-dark-navy mb-8">Persyaratan Umum</h3>
                
                <div class="space-y-6">
                    @foreach([
                        ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'title' => 'Siswa Kelas 12 & Gap Year', 'desc' => 'Siswa/i kelas 12 SMA/SMK/MA sederajat tahun ajaran 2025/2026, atau lulusan tahun ajaran 2023/2024/2025'],
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Prestasi Akademik', 'desc' => 'Memiliki nilai rapor rata-rata minimal 80 atau peringkat 10 besar di kelas'],
                        ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'Domisili', 'desc' => 'Berdomisili di wilayah Jabodetabek atau bersedia tinggal di Jakarta selama kuliah'],
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Komitmen', 'desc' => 'Bersedia mengikuti seluruh rangkaian seleksi dan program pembinaan'],
                        ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Karakter', 'desc' => 'Memiliki jiwa kepemimpinan, aktif berorganisasi, dan berkarakter baik']
                    ] as $requirement)
                    <div class="flex gap-4 items-start p-6 bg-gray-50 rounded-2xl hover:bg-primary-yellow/5 hover:border-primary-yellow border border-transparent transition-all duration-300">
                        <div class="w-12 h-12 bg-primary-yellow rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $requirement['icon'] }}"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-dark-navy text-lg mb-2">{{ $requirement['title'] }}</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $requirement['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Right: Documents Required -->
            <div class="scroll-fade-right">
                <h3 class="text-2xl font-bold text-dark-navy mb-8">Dokumen yang Diperlukan</h3>
                
                <div class="bg-gradient-to-br from-primary-yellow/10 to-primary-yellow/5 rounded-3xl p-8 border border-primary-yellow/20">
                    <div class="space-y-6">
                        @foreach([
                            ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Rapor Semester 1-5', 'format' => 'PDF (Max 5MB)'],
                            ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'title' => 'Pas Foto Terbaru', 'format' => 'JPG/PNG (3x4 cm)'],
                            ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'title' => 'Sertifikat Prestasi', 'format' => 'PDF (Jika ada)'],
                            ['icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'title' => 'Personal Statement', 'format' => 'PDF (Max 500 kata)']
                        ] as $document)
                        <div class="flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-100 hover:shadow-md transition-all duration-300">
                            <div class="w-10 h-10 bg-primary-yellow/20 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $document['icon'] }}"/></svg>
                            </div>
                            <div class="flex-1">
                                <h5 class="font-semibold text-dark-navy">{{ $document['title'] }}</h5>
                                <p class="text-xs text-gray-500">{{ $document['format'] }}</p>
                            </div>
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Important Note -->
                    <div class="mt-8 p-6 bg-white rounded-2xl border-l-4 border-primary-yellow">
                        <div class="flex gap-3">
                            <svg class="w-6 h-6 text-primary-yellow shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            <div>
                                <h5 class="font-bold text-dark-navy mb-2">Penting!</h5>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    Pastikan semua dokumen dalam format yang benar dan dapat dibaca dengan jelas. 
                                    Dokumen yang tidak sesuai ketentuan akan menyebabkan pendaftaran ditolak.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CTA Button -->
        <div class="text-center mt-16 fade-in">
            <a href="/register" class="inline-flex items-center gap-3 bg-primary-yellow hover:bg-primary-yellow-hover text-dark-navy px-10 py-4 rounded-full text-lg font-bold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Saya Memenuhi Syarat, Daftar Sekarang!
            </a>
            <p class="text-sm text-gray-500 mt-4">Gratis dan tanpa biaya apapun</p>
        </div>
    </div>
</div>

<!-- Benefits Section (Dark Box) -->
<div id="program" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-dark-navy rounded-[3rem] p-12 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center scroll-fade">
            <!-- Left: Benefits List -->
            <div class="space-y-8">
                <h2 class="text-4xl font-black text-white mb-8">Cakupan Beasiswa</h2>
                
                @foreach([
                    ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Beasiswa Penuh', 'desc' => 'Pembebasan biaya pendidikan 100% hingga lulus'],
                    ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'Beasiswa Parsial', 'desc' => 'Pembebasan Biaya Pendidikan Mulai Dari 50% Hingga 70%'],
                    ['icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Peluang Karir', 'desc' => 'Prioritas rekrutmen bagi lulusan terbaik di lingkungan MNC Group'],
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Pengembangan Diri', 'desc' => 'Program pembinaan karakter dan skill kepemimpinan'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Networking Luas', 'desc' => 'Terhubung dengan profesional dan pemimpin industri'],
                ] as $benefit)
                <div class="flex gap-4 items-start">
                    <div class="w-12 h-12 bg-primary-yellow rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $benefit['icon'] }}"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-lg mb-1">{{ $benefit['title'] }}</h4>
                        <p class="text-gray-300 text-sm">{{ $benefit['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Right: Portrait Photo -->
            <div>
                <img src="{{ asset('icon/scholar.png') }}" alt="Scholar Portrait" class="rounded-3xl shadow-2xl w-full">
            </div>
        </div>
    </div>
</div>

<!-- Collaboration Section -->
<div class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h3 class="text-primary-yellow font-caveat font-semibold text-2xl mb-2">Kolaborasi</h3>
            <h2 class="text-4xl font-black text-dark-navy">Mitra dan Pendukung</h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 items-center justify-items-center scroll-fade">
            @foreach([
                'Telkom+University', 'GEN+Logo', 'FOJB', 'Forum+Anak',
                'FOSIS+Jateng', 'FAN+Jateng', 'FKPO+DIY', 'HIMOSIS+Jatim',
                'FA+Jatim', 'FOS+DKI'
            ] as $logo)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow w-full flex items-center justify-center min-h-[120px]">
                <img src="https://placehold.co/150x80/EEEEEE/666666?text={{ $logo }}&font=montserrat" alt="Placeholder: {{ str_replace('+', ' ', $logo) }}" class="max-w-full h-auto">
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Testimonials Section - "Apa Kata Mereka" -->
<div class="py-24 bg-gradient-to-br from-primary-yellow/5 to-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-yellow/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 fade-in">
            <h3 class="text-primary-yellow font-caveat font-semibold text-2xl mb-2">Testimonial</h3>
            <h2 class="text-4xl font-black text-dark-navy">Apa Kata Mereka?</h2>
        </div>
        
        <!-- Testimonials Grid with Scroll Animation -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['name' => 'Putri Andini', 'batch' => 'MFLS 2025', 'major' => 'Desain Komunikasi Visual', 'quote' => 'Beasiswa ini mengubah hidup saya. Dari yang awalnya ragu bisa kuliah, sekarang saya sudah semester 3 dengan prestasi yang membanggakan.', 'photo' => 'Andini.png'],
                ['name' => 'Muhammad Rizki', 'batch' => 'MFLS 2023', 'major' => 'Sistem Informasi', 'quote' => 'Program mentoring yang diberikan sangat membantu saya beradaptasi di dunia perkuliahan. Highly recommended!', 'photo' => 'Rizki.png'],
                ['name' => 'Alfiah', 'batch' => 'MFLS 2024', 'major' => 'Manajemen', 'quote' => 'MFLS bukan hanya memberikan beasiswa, tapi juga keluarga baru dan pengalaman yang luar biasa. Terima kasih atas kesempatan ini!', 'photo' => 'Alfiah.png'],
                ['name' => 'Baim', 'batch' => 'MFLS 2024', 'major' => 'Akuntansi', 'quote' => 'Kesempatan magang di MNC Group memberikan pengalaman kerja yang sangat berharga untuk karir saya ke depan.', 'photo' => 'Baim.png'],
                ['name' => 'Cellindia', 'batch' => 'MFLS 2025', 'major' => 'Sains Komunikasi', 'quote' => 'Program leadership dan mentorship dari praktisi MNC Group sangat membantu mengembangkan soft skill saya.', 'photo' => 'Cellindia.png'],
                ['name' => 'Dzakiyah', 'batch' => 'MFLS 2023', 'major' => 'Pendidikan Bahasa Inggris', 'quote' => 'Site visit dan company visit ke unit bisnis MNC memberikan wawasan industri yang tidak bisa didapat di kelas.', 'photo' => 'Dzakiyah.png'],
                ['name' => 'Gavino', 'batch' => 'MFLS 2024', 'major' => 'Ilmu Komputer', 'quote' => 'Networking dengan sesama penerima beasiswa membuka banyak peluang kolaborasi dan pembelajaran bersama.', 'photo' => 'Gavino.png'],
                ['name' => 'Innez', 'batch' => 'MFLS 2025', 'major' => 'Desain Komunikasi Visual', 'quote' => 'Fasilitas kampus yang modern dan dosen-dosen berpengalaman membuat proses belajar jadi lebih menyenangkan.', 'photo' => 'Innez.png'],
                ['name' => 'Irfan', 'batch' => 'MFLS 2023', 'major' => 'Sistem Informasi', 'quote' => 'Beasiswa 100% dari MFLS membebaskan saya dari beban finansial dan bisa fokus pada prestasi akademik.', 'photo' => 'Irfan.png'],
                ['name' => 'Kirania', 'batch' => 'MFLS 2024', 'major' => 'Manajemen', 'quote' => 'Program pengembangan kepemimpinan sangat membantu saya membangun personal branding yang kuat.', 'photo' => 'Kirania.png'],
                ['name' => 'Raput', 'batch' => 'MFLS 2025', 'major' => 'Akuntansi', 'quote' => 'Sertifikat dari MNC University menjadi nilai tambah yang luar biasa di CV saya.', 'photo' => 'raput.png'],
                ['name' => 'Rifatur', 'batch' => 'MFLS 2023', 'major' => 'Pendidikan Matematika', 'quote' => 'Bimbingan dari mentor profesional MNC Group membuka perspektif baru tentang dunia kerja.', 'photo' => 'Rifatur.png'],
                ['name' => 'Rini Amanda', 'batch' => 'MFLS 2024', 'major' => 'Sains Komunikasi', 'quote' => 'Pengalaman sit in class di lingkungan industri memberikan pembelajaran praktis yang sangat aplikatif.', 'photo' => 'Rini Amanda.png'],
                ['name' => 'Risky', 'batch' => 'MFLS 2025', 'major' => 'Ilmu Komputer', 'quote' => 'MFLS memberikan kesempatan untuk berkembang tidak hanya secara akademis tapi juga profesional.', 'photo' => 'Risky.png'],
                ['name' => 'Sandy', 'batch' => 'MFLS 2023', 'major' => 'Desain Komunikasi Visual', 'quote' => 'Komunitas MFLS sangat supportif dan membantu saya beradaptasi dengan lingkungan kampus.', 'photo' => 'Sandy.png'],
                ['name' => 'Satria', 'batch' => 'MFLS 2024', 'major' => 'Sistem Informasi', 'quote' => 'Kesempatan magang di berbagai divisi MNC Group memberikan exposure yang luas tentang industri.', 'photo' => 'Satria.png'],
                ['name' => 'Silvi', 'batch' => 'MFLS 2025', 'major' => 'Manajemen', 'quote' => 'Program beasiswa ini benar-benar life changing dan membuka banyak pintu kesempatan baru.', 'photo' => 'Silvi.png']
            ] as $index => $testimonial)
            <div class="testimonial-card bg-white p-8 rounded-3xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-primary-yellow/30 transition-all duration-500" style="animation-delay: {{ $index * 200 }}ms;">
                <!-- Quote Icon -->
                <svg class="w-12 h-12 text-primary-yellow/20 mb-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                
                <p class="text-gray-700 leading-relaxed mb-8 italic">"{{ $testimonial['quote'] }}"</p>
                
                <div class="flex items-center gap-4 border-t border-gray-100 pt-6">
                    <img src="{{ asset('icon/' . $testimonial['photo']) }}" alt="{{ $testimonial['name'] }}" class="w-14 h-14 rounded-full object-cover border-2 border-primary-yellow/20">
                    <div>
                        <h4 class="font-bold text-dark-navy">{{ $testimonial['name'] }}</h4>
                        <p class="text-sm text-gray-500">{{ $testimonial['major'] }}</p>
                        <p class="text-xs text-primary-yellow font-semibold">{{ $testimonial['batch'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination Dots -->
        <div class="flex justify-center gap-3 mt-12">
            <div class="w-3 h-3 rounded-full bg-primary-yellow"></div>
            <div class="w-3 h-3 rounded-full bg-gray-300"></div>
            <div class="w-3 h-3 rounded-full bg-gray-300"></div>
        </div>
    </div>
</div>

<!-- Contact Section - "Hubungi Kami" -->
<div id="contact" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in">
            <h2 class="text-4xl font-black text-dark-navy mb-4">Hubungi Kami</h2>
            <p class="text-gray-600 font-semibold max-w-2xl mx-auto">Punya pertanyaan? Tim kami siap membantu Anda</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- WhatsApp -->
            <div class="contact-card bg-gradient-to-br from-gray-50 to-white p-10 rounded-3xl border-2 border-gray-100 text-center hover:border-primary-yellow hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-primary-yellow/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-yellow" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                </div>
                <h4 class="font-black text-dark-navy text-xl mb-3">WhatsApp</h4>
                <a href="https://wa.me/6285880059189" target="_blank" class="text-primary-yellow font-bold text-lg hover:underline">+62 858-8005-9189</a>
                <p class="text-gray-500 text-sm mt-3">Senin - Jumat: 09.00 - 17.00 WIB</p>
            </div>
            
            <!-- Email -->
            <div class="contact-card bg-gradient-to-br from-gray-50 to-white p-10 rounded-3xl border-2 border-gray-100 text-center hover:border-primary-yellow hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" style="animation-delay: 200ms;">
                <div class="w-20 h-20 bg-primary-yellow/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="font-black text-dark-navy text-xl mb-3">Email</h4>
                <a href="mailto:iggsmfls@gmail.com" class="text-primary-yellow font-bold text-lg hover:underline">beasiswamncuniversity@gmail.com</a>
                <p class="text-gray-500 text-sm mt-3">Respon dalam 1x24 jam</p>
            </div>
            
            <!-- Instagram -->
            <div class="contact-card bg-gradient-to-br from-gray-50 to-white p-10 rounded-3xl border-2 border-gray-100 text-center hover:border-primary-yellow hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" style="animation-delay: 400ms;">
                <a href="https://www.instagram.com/beasiswamncu/" target="_blank">
                <div class="w-20 h-20 bg-primary-yellow/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-yellow" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </div>
                <h4 class="font-black text-dark-navy text-xl mb-3">Instagram</h4>
                <a href="https://www.instagram.com/beasiswamncu/" target="_blank" class="text-primary-yellow font-bold text-lg hover:underline">@beasiswamncu</a>
                <p class="text-gray-500 text-sm mt-3">Follow untuk info terbaru</p>
            </div>
        </div>
    </div>
</div>

<style>
/* Fade-in Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.fade-in {
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
}

/* Scroll-triggered animations */
.scroll-fade {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.scroll-fade.visible {
    opacity: 1;
    transform: translateY(0);
}

.scroll-fade-left {
    opacity: 0;
    transform: translateX(-50px);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.scroll-fade-left.visible {
    opacity: 1;
    transform: translateX(0);
}

.scroll-fade-right {
    opacity: 0;
    transform: translateX(50px);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.scroll-fade-right.visible {
    opacity: 1;
    transform: translateX(0);
}

.testimonial-card,
.contact-card {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.testimonial-card.visible,
.contact-card.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Stagger effect for stats */
.stat-item {
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.stat-item.visible {
    opacity: 1;
    transform: scale(1);
}
@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(-10%);
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }
    50% {
        transform: translateY(0);
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}

.animate-bounce-slow {
    animation: bounce-slow 3s infinite;
}
</style>

<script>
// Comprehensive Scroll Animation Observer
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Optional: unobserve after animation to improve performance
                // observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all scroll-animated elements
    const animatedElements = [
        '.scroll-fade',
        '.scroll-fade-left',
        '.scroll-fade-right',
        '.testimonial-card',
        '.contact-card',
        '.stat-item'
    ];
    
    animatedElements.forEach(selector => {
        document.querySelectorAll(selector).forEach((element, index) => {
            // Add stagger delay
            element.style.transitionDelay = `${index * 0.1}s`;
            observer.observe(element);
        });
    });
});

// Real-time Countdown Timer
(function() {
    const targetDate = new Date("2026-05-04T23:59:59+07:00").getTime();
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = targetDate - now;
        
        if (distance < 0) {
            ['days', 'hours', 'minutes', 'seconds'].forEach(id => {
                document.getElementById(id).textContent = "00";
            });
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById("days").textContent = String(days).padStart(2, '0');
        document.getElementById("hours").textContent = String(hours).padStart(2, '0');
        document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
        document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
    }
    
    updateCountdown();  
    setInterval(updateCountdown, 1000);
})();

// Modal Program Studi
document.addEventListener('DOMContentLoaded', function() {
    const selengkapnyaBtn = document.getElementById('selengkapnya-btn');
    const modal = document.getElementById('program-studi-modal');
    const modalContent = document.getElementById('modal-content');
    const closeBtn = document.getElementById('close-modal');
    
    // Open modal
    if (selengkapnyaBtn) {
        selengkapnyaBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        });
    }
    
    // Close modal function
    function closeModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
    
    // Close modal events
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
@endsection
