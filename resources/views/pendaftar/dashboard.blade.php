@extends('pendaftar.layout')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden bg-primary-gold p-8 md:p-12 rounded-[2rem] shadow-xl shadow-primary-gold/20">
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-dark-navy">
                <h1 class="text-3xl md:text-4xl font-black mb-4">Halo, {{ explode(' ', $peserta->nama)[0] }}! 👋</h1>
                <p class="text-dark-navy/70 font-semibold max-w-lg mb-8">
                    Ayo lengkapi berkas pendaftaranmu untuk mendapatkan kesempatan beasiswa 100% di Telkom University.
                </p>
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="w-10 h-10 rounded-full border-2 border-primary-gold bg-gray-200 overflow-hidden">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $i }}" alt="User">
                            </div>
                        @endfor
                    </div>
                    <p class="text-xs font-bold text-dark-navy/60 underline decoration-2 underline-offset-4">
                        +1.200 pendaftar lainnya sudah melengkapi berkas
                    </p>
                </div>
            </div>
            <div class="shrink-0">
                <div class="w-48 h-48 bg-white/20 backdrop-blur-xl rounded-2xl flex flex-col items-center justify-center border border-white/30 text-dark-navy">
                    <div class="text-5xl font-black mb-1">65%</div>
                    <div class="text-[10px] font-bold uppercase tracking-widest opacity-60">Progres Data</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Steps -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Step 1 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative group overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white font-bold mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Biodata Diri</h3>
            <p class="text-sm text-gray-500 mb-6">Informasi dasar, alamat, dan asal sekolah pendaftar.</p>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-wider">Selesai</span>
                <a href="#" class="text-xs font-extrabold text-primary-gold hover:underline">Edit Data</a>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative group overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="w-12 h-12 bg-primary-gold rounded-2xl flex items-center justify-center text-dark-navy font-bold mb-6">
                <span class="text-xl">!</span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Upload Berkas</h3>
            <p class="text-sm text-gray-500 mb-6">Rapor sem. 1-5, foto, video motivasi, dan sertifikat prestasi.</p>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-primary-gold bg-primary-gold/10 px-3 py-1 rounded-full uppercase tracking-wider">Belum Lengkap</span>
                <a href="#" class="text-xs font-extrabold text-dark-navy bg-primary-gold hover:bg-primary-gold-hover px-4 py-2 rounded-xl transition-all">Lengkapi</a>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm relative group overflow-hidden opacity-50 grayscale">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 font-bold mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Ujian Online</h3>
            <p class="text-sm text-gray-500 mb-6">Akses akan terbuka setelah seluruh berkas diverifikasi tim MFLS.</p>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 bg-gray-50 px-3 py-1 rounded-full uppercase tracking-wider">Terkunci</span>
            </div>
        </div>
    </div>

    <!-- Latest Activities / Timeline -->
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Riwayat Pendaftaran</h3>
            <button class="text-xs font-bold text-primary-gold hover:underline">Lihat Semua</button>
        </div>
        <div class="p-8 space-y-6">
            <div class="flex gap-4">
                <div class="shrink-0 w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center relative after:absolute after:top-10 after:bottom-[-24px] after:w-[2px] after:bg-gray-100 after:left-1/2 after:-translate-x-1/2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Registrasi Akun Berhasil</h4>
                    <p class="text-xs text-gray-500 mt-1">Akun anda telah terdaftar di sistem MFLS 2026.</p>
                    <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase tracking-wide">18 Jan 2026 • 10:30 WIB</p>
                </div>
            </div>
            
            <div class="flex gap-4">
                <div class="shrink-0 w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center relative after:absolute after:top-10 after:bottom-[-24px] after:w-[2px] after:bg-gray-100 after:left-1/2 after:-translate-x-1/2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Biodata Diri Disimpan</h4>
                    <p class="text-xs text-gray-500 mt-1">Anda telah mengisi data profil dasar dengan lengkap.</p>
                    <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase tracking-wide">18 Jan 2026 • 14:20 WIB</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="shrink-0 w-10 h-10 rounded-full bg-primary-gold/10 text-primary-gold flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Menunggu Upload Berkas</h4>
                    <p class="text-xs text-gray-500 mt-1">Silakan upload rapor dan dokumen pendukung lainnya.</p>
                    <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase tracking-wide">Saat Ini</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
