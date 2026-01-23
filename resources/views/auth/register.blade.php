@extends('layouts.auth')

@section('title', 'Daftar Akun')

@section('content')
<div class="mb-10 text-center lg:text-left">
    <h1 class="text-3xl font-black text-gray-900 mb-3">Mulai Perjalananmu!</h1>
    <p class="text-gray-500 font-medium">Buat akun untuk memulai pendaftaran beasiswa MFLS 2026.</p>
</div>

<form action="/register" method="POST" class="space-y-8">
    @csrf
    
    <!-- Section 1: Akun -->
    <div class="space-y-4">
        <h3 class="text-xs font-bold text-primary-gold uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-primary-gold"></span>
            Detail Akun
        </h3>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="nama" class="block text-xs font-bold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all placeholder:text-gray-400 font-medium text-sm" placeholder="Sesuai Ijazah/KTP">
            </div>
            <div>
                <label for="email" class="block text-xs font-bold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" id="email" name="email" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all placeholder:text-gray-400 font-medium text-sm" placeholder="nama@email.com">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-bold text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all placeholder:text-gray-400 font-medium text-sm" placeholder="••••••••">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all placeholder:text-gray-400 font-medium text-sm" placeholder="••••••••">
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Info Pribadi -->
    <div class="space-y-4">
        <h3 class="text-xs font-bold text-primary-gold uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-primary-gold"></span>
            Informasi Pribadi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="no_whatsapp" class="block text-xs font-bold text-gray-700 mb-2">No. WhatsApp</label>
                <input type="text" id="no_whatsapp" name="no_whatsapp" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all placeholder:text-gray-400 font-medium text-sm" placeholder="08xxxxxx">
            </div>
            <div>
                <label for="tgl_lahir" class="block text-xs font-bold text-gray-700 mb-2">Tanggal Lahir</label>
                <input type="date" id="tgl_lahir" name="tgl_lahir" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all text-sm font-medium">
            </div>
            <div>
                <label for="jenis_kelamin" class="block text-xs font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all text-sm font-medium">
                    <option value="">Pilih Gender</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div>
                <label for="tahun_lulus" class="block text-xs font-bold text-gray-700 mb-2">Tahun Lulus</label>
                <select id="tahun_lulus" name="tahun_lulus" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all text-sm font-medium">
                    <option value="">Pilih Tahun</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Section 3: Info Sekolah -->
    <div class="space-y-4">
        <h3 class="text-xs font-bold text-primary-gold uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-primary-gold"></span>
            Informasi Sekolah
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="provinsi" class="block text-xs font-bold text-gray-700 mb-2">Provinsi Sekolah</label>
                <input type="text" id="provinsi" name="provinsi" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all text-sm font-medium" placeholder="Contoh: Jawa Barat">
            </div>
            <div>
                <label for="kabupaten" class="block text-xs font-bold text-gray-700 mb-2">Kota/Kabupaten</label>
                <input type="text" id="kabupaten" name="kabupaten" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all text-sm font-medium" placeholder="Contoh: Bandung">
            </div>
            <div class="col-span-full">
                <label for="nama_sekolah" class="block text-xs font-bold text-gray-700 mb-2">Nama Sekolah</label>
                <input type="text" id="nama_sekolah" name="nama_sekolah" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none transition-all text-sm font-medium" placeholder="Nama SMA/SMK/MA">
            </div>
        </div>
    </div>

    <div class="flex items-start">
        <input type="checkbox" id="agreement" required class="mt-1 w-5 h-5 border-gray-200 rounded text-primary-gold focus:ring-primary-gold/20">
        <label for="agreement" class="ml-3 text-xs font-semibold text-gray-600 leading-relaxed">
            Data yang saya masukkan sudah benar dan saya menyetujui <a href="#" class="text-primary-gold hover:underline">Syarat & Ketentuan</a> yang berlaku.
        </label>
    </div>

    <button type="submit" 
        class="w-full bg-primary-gold hover:bg-primary-gold-hover text-dark-navy font-black py-4 rounded-2xl shadow-xl shadow-primary-gold/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
        Daftar Sekarang
    </button>
</form>

<p class="mt-10 text-center text-sm font-bold text-gray-500">
    Sudah punya akun? 
    <a href="/login" class="text-primary-gold hover:underline">Masuk di sini</a>
</p>
@endsection
