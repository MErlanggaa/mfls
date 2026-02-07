@extends('pendaftar.layout')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner with Glassmorphism -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-gold via-yellow-400 to-orange-400 p-8 md:p-12 rounded-[2.5rem] shadow-2xl shadow-orange-500/20">
        <!-- Decoration Circles -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-white/20 rounded-full blur-3xl mix-blend-overlay"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/4 w-64 h-64 bg-yellow-200/20 rounded-full blur-2xl mix-blend-overlay"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="text-dark-navy text-center md:text-left">
                <div class="inline-block px-4 py-1 bg-white/30 backdrop-blur-md rounded-full text-xs font-black uppercase tracking-widest text-dark-navy/80 mb-4 border border-white/20">
                    Scholarship Applicant
                </div>
                <h1 class="text-4xl md:text-5xl font-black mb-4 leading-tight">Halo, {{ explode(' ', $peserta->nama)[0] }}! 👋</h1>
                <p class="text-dark-navy/80 font-semibold text-lg max-w-lg mb-8 leading-relaxed">
                    Perjalananmu menuju masa depan cerah dimulai di sini. Lengkapi berkasmu dan raih beasiswa impianmu!
                </p>
                
                @php
                    $fotoProfil = ($berkas && $berkas->foto) ? asset('storage/' . $berkas->foto) : "https://ui-avatars.com/api/?name=".urlencode($peserta->nama)."&background=random&color=fff";
                @endphp
                
                <div class="flex items-center gap-6 mt-8">
                    <!-- User Photo -->
                    <div class="relative group cursor-pointer">
                        <div class="absolute -inset-0.5 bg-gradient-to-br from-white/60 to-white/10 rounded-full blur opacity-50 group-hover:opacity-100 transition duration-1000"></div>
                        <div class="relative w-20 h-20 rounded-full border-[3px] border-white/50 bg-white shadow-xl overflow-hidden">
                            <img src="{{ $fotoProfil }}" alt="Foto Profil" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        @if(!$berkas || !$berkas->foto)
                            <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-white rounded-full flex items-center justify-center text-orange-400 shadow-md text-xs font-black group-hover:scale-110 transition-transform" title="Belum upload foto">
                                ⚠️
                            </div>
                        @endif
                    </div>

                    <!-- Status Text -->
                    <div>
                        <p class="text-sm font-bold text-dark-navy mb-1 opacity-80">Status Pendaftaran</p>
                        <div class="flex items-center gap-2">
                            @if(($peserta->daftar->status ?? '') == 'lulus')
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-900 rounded-lg text-xs font-black uppercase tracking-widest border border-emerald-500/20 backdrop-blur-sm">
                                    BERKAS DITERIMA
                                </span>
                            @elseif(($peserta->daftar->status ?? '') == 'tidak_lulus')
                                <span class="px-3 py-1 bg-red-500/20 text-red-900 rounded-lg text-xs font-black uppercase tracking-widest border border-red-500/20 backdrop-blur-sm">
                                    DITOLAK
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/40 text-dark-navy rounded-lg text-[10px] font-black uppercase tracking-widest border border-white/20 backdrop-blur-sm shadow-sm">
                                    <span class="relative flex h-2 w-2">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-dark-navy opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-dark-navy"></span>
                                    </span>
                                    MENUNGGU VERIFIKASI
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Circle -->
            <div class="shrink-0 relative group">
                <div class="absolute inset-0 bg-white/30 blur-2xl rounded-full group-hover:bg-white/40 transition-all duration-700"></div>
                <div class="relative w-48 h-48 bg-white/20 backdrop-blur-xl rounded-full flex flex-col items-center justify-center border border-white/40 shadow-inner text-dark-navy transition-transform duration-500 hover:scale-105">
                    <div class="text-6xl font-black mb-1 drop-shadow-sm">{{ $progress }}<span class="text-3xl align-top">%</span></div>
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Completed</div>
                </div>
                
                <!-- Circular SVG Progress could actulally rely on CSS or SVG Dasharray, keeping it simple visual for now -->
                <svg class="absolute top-0 left-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="48" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="4" />
                    <!-- Calculate stroke-dasharray: 2 * PI * r = 2 * 3.14 * 48 ≈ 301 -->
                    <circle cx="50" cy="50" r="48" fill="none" stroke="#111827" stroke-width="4" stroke-dasharray="301" stroke-dashoffset="{{ 301 - (301 * $progress / 100) }}" stroke-linecap="round" class="transition-all duration-1000 ease-out" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Verification Status Alert / Notification -->
    @if(($peserta->daftar->status ?? '') == 'lulus')
    <div class="relative overflow-hidden bg-white border border-emerald-100 p-8 rounded-[2.5rem] shadow-xl shadow-emerald-500/5 group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-8 -mt-8 opacity-50"></div>
        <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
            <div class="w-20 h-20 bg-emerald-500 text-white rounded-[2rem] flex items-center justify-center shadow-lg shadow-emerald-500/20 shrink-0">
                <span class="iconify text-4xl" data-icon="solar:confetti-bold"></span>
            </div>
            <div class="flex-grow text-center md:text-left">
                <h2 class="text-2xl font-black text-slate-800 mb-2">Selamat! Berkas Anda Diterima 🎉</h2>
                <p class="text-sm font-medium text-slate-500 leading-relaxed mb-6">
                    Tahap seleksi administrasi telah selesai. Berkas Anda dinyatakan <span class="text-emerald-600 font-bold">LENGKAP</span>. Langkah selanjutnya adalah mengikuti <span class="font-bold underline">Ujian Seleksi Online</span>.
                </p>
                <div class="flex flex-wrap items-center gap-4 justify-center md:justify-start">
                    <a href="https://ujian-react.mfls.com/start?token={{ base64_encode(auth()->user()->email) }}" target="_blank" class="px-8 py-3 bg-blue-600 text-white rounded-2xl text-xs font-black shadow-lg hover:bg-black transition-all uppercase tracking-widest flex items-center gap-2">
                        <span class="iconify" data-icon="solar:play-bold"></span> Mulai Ujian Sekarang
                    </a>
                    <div class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahap 2 Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card: Biodata -->
        <a href="{{ route('pendaftar.biodata') }}" class="group relative bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20 mb-6 group-hover:rotate-12 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Biodata Diri</h3>
                <p class="text-sm text-gray-500 mb-6 font-medium leading-relaxed">Data identitas utama sudah terpenuhi?</p>
                
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition-colors">
                        FORMULIR
                    </span>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Card: Berkas -->
        <a href="{{ route('pendaftar.berkas') }}" class="group relative bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 bg-primary-gold text-dark-navy rounded-2xl flex items-center justify-center shadow-lg shadow-primary-gold/20 mb-6 group-hover:rotate-12 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-gold transition-colors">Upload Berkas</h3>
                <p class="text-sm text-gray-500 mb-6 font-medium leading-relaxed">Rapor, Prestasi, dan Video Motivasi.</p>
                
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500 group-hover:bg-yellow-100 group-hover:text-yellow-700 transition-colors">
                        DOKUMEN
                    </span>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-primary-gold group-hover:text-dark-navy transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Card: Twibbon -->
        <a href="{{ route('pendaftar.twibbon') }}" class="group relative bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-pink-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 bg-pink-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-pink-500/20 mb-6 group-hover:rotate-12 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors">Twibbon</h3>
                <p class="text-sm text-gray-500 mb-6 font-medium leading-relaxed">Ramaikan MFLS di Sosial Mediamu.</p>
                
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500 group-hover:bg-pink-100 group-hover:text-pink-700 transition-colors">
                        CAMPAIGN
                    </span>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-pink-500 group-hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Timeline Activity -->
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50 via-white to-white">
            <h3 class="text-xl font-black text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600">
                    <span class="iconify" data-icon="solar:history-bold-duotone" data-width="24"></span>
                </div>
                Riwayat Aktivitas
            </h3>
            <span class="text-[10px] font-black text-orange-500 bg-orange-50 border border-orange-100 px-3 py-1.5 rounded-full uppercase tracking-widest text-shadow-sm">PENDAFTAR LOG</span>
        </div>
        <div class="p-8">
            <div class="relative pl-8 border-l-2 border-slate-100 space-y-12 py-4">
                @foreach($history as $h)
                @php
                    $iconMapper = [
                        'user' => 'solar:user-bold-duotone',
                        'edit' => 'solar:pen-square-bold-duotone',
                        'upload' => 'solar:upload-square-bold-duotone',
                        'chart-bar' => 'solar:chart-square-bold-duotone',
                        'graduation-cap' => 'solar:verified-check-bold-duotone'
                    ];
                    $colorMapper = [
                        'user' => 'bg-indigo-50 text-indigo-500 border-indigo-100',
                        'edit' => 'bg-blue-50 text-blue-500 border-blue-100',
                        'upload' => 'bg-emerald-50 text-emerald-500 border-emerald-100',
                        'chart-bar' => 'bg-amber-50 text-amber-500 border-amber-100',
                        'graduation-cap' => 'bg-purple-50 text-purple-600 border-purple-100'
                    ];
                    $currentIcon = $iconMapper[$h['icon']] ?? 'solar:info-circle-bold-duotone';
                    $currentColor = $colorMapper[$h['icon']] ?? 'bg-slate-50 text-slate-500 border-slate-100';
                @endphp
                <div class="relative group">
                    <div class="absolute -left-[58px] top-0 w-14 h-14 rounded-2xl border-[5px] border-white {{ $currentColor }} border flex items-center justify-center shadow-sm transition-all duration-300 group-hover:scale-110 group-hover:rotate-3 group-hover:shadow-lg">
                        <span class="iconify" data-icon="{{ $currentIcon }}" data-width="28"></span>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="max-w-xl">
                            <h4 class="text-lg font-black text-slate-800 tracking-tight group-hover:text-primary-gold transition-colors duration-300">{{ $h['title'] }}</h4>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed mt-1">{{ $h['desc'] }}</p>
                        </div>
                        <div class="shrink-0">
                            <div class="flex items-center gap-2 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 group-hover:bg-slate-100 transition-colors">
                                <span class="iconify text-slate-300" data-icon="solar:clock-circle-bold-duotone" data-width="14"></span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $h['date'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                @if(count($history) == 0)
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-slate-200">
                            <span class="iconify" data-icon="solar:database-broken" data-width="48"></span>
                        </div>
                        <p class="text-sm text-slate-400 font-black uppercase tracking-[0.2em]">Belum ada aktivitas terekam</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
