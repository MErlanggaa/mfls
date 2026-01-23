@extends('pendaftar.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-2">Biodata Diri</h1>
                <p class="text-gray-500 font-medium">Lengkapi data profil pendaftaran Anda</p>
            </div>
            <div class="w-16 h-16 bg-primary-gold/10 rounded-2xl flex items-center justify-center text-primary-gold">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
        </div>

        <form action="#" class="p-10 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Nama Lengkap</label>
                    <input type="text" value="{{ Auth::user()->nama }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">NISN</label>
                    <input type="text" placeholder="Masukkan NISN" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Tempat Lahir</label>
                    <input type="text" placeholder="Kota Kelahiran" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Tanggal Lahir</label>
                    <input type="date" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="col-span-full space-y-2">
                    <label class="text-sm font-bold text-gray-700">Asal Sekolah</label>
                    <input type="text" placeholder="Nama Sekolah SMA/SMK/MA" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="bg-primary-gold hover:bg-primary-gold-hover text-dark-navy font-black px-10 py-4 rounded-2xl shadow-xl shadow-primary-gold/20 transition-all hover:scale-105">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
