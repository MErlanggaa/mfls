@extends('layouts.user')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-white pt-12 pb-20">
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
                    Beasiswa Kuliah Gratis 100% hingga lulus di Media Nusantara Citra University
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="/register" class="bg-primary-yellow hover:bg-primary-yellow-hover text-white px-8 py-4 rounded-full text-base font-bold shadow-lg hover:shadow-xl transition-all duration-300">
                        Daftar Sekarang
                    </a>
                    <a href="https://t.me/iggs_official" target="_blank" class="flex items-center justify-center gap-2 text-dark-navy font-semibold hover:text-primary-yellow transition-colors">
                        Gabung Grup Telegram
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>
            
            <!-- Right Column: Hero Image -->
            <div class="relative lg:block hidden scroll-fade-right">
                <img src="{{ asset('icon/mnclogo.jpg') }}" alt="Placeholder: Student Hero Image" class="w-full h-auto rounded-3xl shadow-2xl">
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
                
                <div class="grid grid-cols-4 gap-8 max-w-5xl mx-auto">
                    <div class="text-center">
                        <div id="days" class="text-7xl font-black text-primary-yellow mb-2">00</div>
                        <div class="text-lg font-bold text-primary-yellow uppercase">Hari</div>
                    </div>
                    <div class="text-center">
                        <div id="hours" class="text-7xl font-black text-primary-yellow mb-2">00</div>
                        <div class="text-lg font-bold text-primary-yellow uppercase">Jam</div>
                    </div>
                    <div class="text-center">
                        <div id="minutes" class="text-7xl font-black text-primary-yellow mb-2">00</div>
                        <div class="text-lg font-bold text-primary-yellow uppercase">Menit</div>
                    </div>
                    <div class="text-center">
                        <div id="seconds" class="text-7xl font-black text-primary-yellow mb-2">00</div>
                        <div class="text-lg font-bold text-primary-yellow uppercase">Detik</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Yellow Bottom Border -->
        <div class="h-2 bg-primary-yellow"></div>
    </div>
</div>

<!-- About Section with Photos -->
<div class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-20 items-start">
            <!-- Left: Text + Stats (3 columns) -->
            <div class="lg:col-span-3 scroll-fade-left">
                <h3 class="text-primary-yellow font-caveat font-semibold text-2xl mb-4">Tentang Kami</h3>
                <h2 class="text-4xl md:text-5xl font-black text-dark-navy mb-8 leading-tight">Indonesian Gold Generation Scholarship</h2>
                
                <div class="space-y-6 text-gray-700 leading-relaxed mb-12">
                    <p>
                        Indonesian Gold Generation Scholarship (IGGS) merupakan program beasiswa 100% Full sampai lulus di Telkom University yang dipersembahkan oleh Gala Edukasi Nusantara (GEN) untuk siswa-siswi kelas 12 yang berprestasi dan memiliki semangat juang tinggi.
                    </p>
                    <p>
                        Pada tahun pertamanya, IGGS bernama Forum OSIS Jawa Barat (FOJB) Scholarship di mana hanya menjaring siswa/i SMA se-Jawa Barat. Pada tahun 2022, program ini berkembang menjadi skala nasional melalui kolaborasi dengan Forum OSIS dan Forum Anak se-Indonesia untuk menjaring putra-putri terbaik bangsa dari berbagai provinsi.
                    </p>
                </div>
                
                <!-- Stats Grid 2x2 -->
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div class="stat-item text-center lg:text-left">
                        <div class="text-5xl md:text-6xl font-black text-dark-navy mb-2">4</div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Kampus</div>
                    </div>
                    <div class="stat-item text-center lg:text-left">
                        <div class="text-5xl md:text-6xl font-black text-dark-navy mb-2">7</div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Fakultas</div>
                    </div>
                    <div class="stat-item text-center lg:text-left">
                        <div class="text-5xl md:text-6xl font-black text-dark-navy mb-2">92</div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Program Studi</div>
                    </div>
                    <div class="stat-item text-center lg:text-left">
                        <div class="text-5xl md:text-6xl font-black text-dark-navy mb-2">20+</div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Kemitraan</div>
                    </div>
                </div>
                
                <!-- Link Selengkapnya -->
                <a href="#" class="inline-flex items-center gap-2 text-primary-yellow font-bold hover:gap-4 transition-all">
                    Selengkapnya
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
            
            <!-- Right: Staggered Photo Collage (2 columns) -->
            <div class="lg:col-span-2 scroll-fade-right">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Top Right -->
                    <div class="col-start-2">
                        <img src="https://placehold.co/300x400/F2B451/FFFFFF?text=Students+1&font=montserrat" alt="Placeholder: Students Photo 1" class="rounded-2xl shadow-lg w-full h-64 object-cover">
                    </div>
                    
                    <!-- Middle Left -->
                    <div class="col-start-1 row-start-2">
                        <img src="https://placehold.co/400x300/F2B451/FFFFFF?text=Seminar+2&font=montserrat" alt="Placeholder: Seminar Photo 2" class="rounded-2xl shadow-lg w-full h-48 object-cover">
                    </div>
                    
                    <!-- Middle Right -->
                    <div class="col-start-2 row-start-2">
                        <img src="https://placehold.co/400x300/F2B451/FFFFFF?text=Group+3&font=montserrat" alt="Placeholder: Group Photo 3" class="rounded-2xl shadow-lg w-full h-48 object-cover">
                    </div>
                    
                    <!-- Bottom Left -->
                    <div class="col-start-1 row-start-3">
                        <img src="https://placehold.co/300x400/F2B451/FFFFFF?text=Students+4&font=montserrat" alt="Placeholder: Students Photo 4" class="rounded-2xl shadow-lg w-full h-64 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timeline Section -->
<div class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-black text-dark-navy text-center mb-16 fade-in">Jadwal dan Tahapan Seleksi</h2>
        
        <!-- Horizontal Timeline -->
        <div class="relative fade-in">
            <div class="flex justify-between items-start max-w-6xl mx-auto">
                @php
                    $timeline = [
                        ['title' => 'Pendaftaran', 'date' => '13 Jan - 13 Apr 2026', 'active' => true],
                        ['title' => 'Seleksi Berkas', 'date' => '14 - 30 Apr 2026', 'active' => false],
                        ['title' => 'Pengumuman Berkas', 'date' => '2 Mei 2026', 'active' => false],
                        ['title' => 'Tahap Wawancara', 'date' => '4 - 26 Mei 2026', 'active' => false],
                        ['title' => 'Pengumuman Akhir', 'date' => '6 Juli 2026', 'active' => false]
                    ];
                @endphp
                
                @foreach($timeline as $index => $item)
                <div class="flex flex-col items-center text-center flex-1">
                    <!-- Dot with pulse animation for active phase -->
                    @if($item['active'])
                        <div class="relative w-4 h-4 mb-4 z-10">
                            <div class="absolute inset-0 bg-primary-yellow rounded-full animate-ping"></div>
                            <div class="relative w-4 h-4 bg-primary-yellow rounded-full"></div>
                        </div>
                    @else
                        <div class="w-4 h-4 bg-primary-yellow rounded-full mb-4 relative z-10"></div>
                    @endif
                    
                    <h4 class="font-bold {{ $item['active'] ? 'text-primary-yellow' : 'text-dark-navy' }} mb-2 text-sm">{{ $item['title'] }}</h4>
                    <p class="text-xs {{ $item['active'] ? 'text-primary-yellow font-semibold' : 'text-gray-500' }}">{{ $item['date'] }}</p>
                </div>
                @endforeach
            </div>
            
            <!-- Line connecting dots -->
            <div class="absolute top-2 left-0 right-0 h-0.5 bg-primary-yellow" style="width: calc(100% - 100px); margin: 0 50px;"></div>
        </div>
    </div>
</div>

<!-- Benefits Section (Dark Box) -->
<div class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-dark-navy rounded-[3rem] p-12 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center scroll-fade">
            <!-- Left: Benefits List -->
            <div class="space-y-8">
                <h2 class="text-4xl font-black text-white mb-8">Cakupan Beasiswa</h2>
                
                @foreach([
                    ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Beasiswa Penuh', 'desc' => 'Pembebasan biaya pendidikan (UP3 dan SDP2) 100% hingga lulus'],
                    ['icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'title' => 'Beasiswa Parsial', 'desc' => 'Potongan biaya (SDP2/UP3) sesuai persentase yang diberikan'],
                    ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'Pilihan Kampus', 'desc' => 'Bandung, Jakarta, Surabaya, dan Purwokerto'],
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Pengembangan Diri', 'desc' => 'Kegiatan volunteering dan proyek sosial via GEMFI'],
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Program Mentoring', 'desc' => 'Bimbingan 1-on-1 eksklusif dengan mentor berpengalaman']
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
                <img src="https://placehold.co/500x700/F2B451/FFFFFF?text=Scholar+Portrait&font=montserrat" alt="Placeholder: Scholar Portrait" class="rounded-3xl shadow-2xl w-full">
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
                ['name' => 'Sarah Amelia', 'batch' => 'IGGS 2024', 'major' => 'Teknik Informatika', 'quote' => 'IGGS bukan hanya memberikan beasiswa, tapi juga keluarga baru dan pengalaman yang luar biasa. Terima kasih atas kesempatan ini!'],
                ['name' => 'Muhammad Rizki', 'batch' => 'IGGS 2023', 'major' => 'Sistem Informasi', 'quote' => 'Program mentoring yang diberikan sangat membantu saya beradaptasi di dunia perkuliahan. Highly recommended!'],
                ['name' => 'Putri Andini', 'batch' => 'IGGS 2025', 'major' => 'Desain Komunikasi Visual', 'quote' => 'Beasiswa ini mengubah hidup saya. Dari yang awalnya ragu bisa kuliah, sekarang saya sudah semester 3 dengan prestasi yang membanggakan.']
            ] as $index => $testimonial)
            <div class="testimonial-card bg-white p-8 rounded-3xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-primary-yellow/30 transition-all duration-500" style="animation-delay: {{ $index * 200 }}ms;">
                <!-- Quote Icon -->
                <svg class="w-12 h-12 text-primary-yellow/20 mb-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                
                <p class="text-gray-700 leading-relaxed mb-8 italic">"{{ $testimonial['quote'] }}"</p>
                
                <div class="flex items-center gap-4 border-t border-gray-100 pt-6">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary-yellow to-primary-yellow-hover flex items-center justify-center text-white font-black text-lg">
                        {{ substr($testimonial['name'], 0, 1) }}
                    </div>
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
<div class="py-24 bg-white">
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
                <a href="https://wa.me/6281234567890" class="text-primary-yellow font-bold text-lg hover:underline">+62 812-3456-7890</a>
                <p class="text-gray-500 text-sm mt-3">Senin - Jumat: 09.00 - 17.00 WIB</p>
            </div>
            
            <!-- Email -->
            <div class="contact-card bg-gradient-to-br from-gray-50 to-white p-10 rounded-3xl border-2 border-gray-100 text-center hover:border-primary-yellow hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" style="animation-delay: 200ms;">
                <div class="w-20 h-20 bg-primary-yellow/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="font-black text-dark-navy text-xl mb-3">Email</h4>
                <a href="mailto:iggsmfls@gmail.com" class="text-primary-yellow font-bold text-lg hover:underline">iggsmfls@gmail.com</a>
                <p class="text-gray-500 text-sm mt-3">Respon dalam 1x24 jam</p>
            </div>
            
            <!-- Instagram -->
            <div class="contact-card bg-gradient-to-br from-gray-50 to-white p-10 rounded-3xl border-2 border-gray-100 text-center hover:border-primary-yellow hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" style="animation-delay: 400ms;">
                <div class="w-20 h-20 bg-primary-yellow/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-primary-yellow" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </div>
                <h4 class="font-black text-dark-navy text-xl mb-3">Instagram</h4>
                <a href="https://instagram.com/iggsmfls" target="_blank" class="text-primary-yellow font-bold text-lg hover:underline">@iggsmfls</a>
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
    const targetDate = new Date("2026-04-13T23:59:59+07:00").getTime();
    
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
</script>
@endsection
