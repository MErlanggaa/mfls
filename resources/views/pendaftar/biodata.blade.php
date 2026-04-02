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

        <form action="{{ route('pendaftar.biodata.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $peserta->nama ?? Auth::user()->nama }}" placeholder="Nama Lengkap" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">NISN</label>
                    <input type="text" name="nisn" value="{{ $peserta->nisn }}" placeholder="Masukkan NISN" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Nomor WhatsApp</label>
                    <input type="text" name="no_whatsapp" value="{{ $peserta->no_whatsapp }}" placeholder="08xxxxxxxxxx" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ ($peserta->jenis_kelamin == 'Laki-laki' || $peserta->jenis_kelamin == 'L') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ ($peserta->jenis_kelamin == 'Perempuan' || $peserta->jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" value="{{ $peserta->tgl_lahir }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Provinsi Domisili</label>
                    <input type="text" name="provinsi" value="{{ $peserta->provinsi }}" placeholder="Provinsi" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Kabupaten/Kota</label>
                    <input type="text" name="kabupaten" value="{{ $peserta->kabupaten }}" placeholder="Kabupaten/Kota" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="col-span-full space-y-2">
                    <label class="text-sm font-bold text-gray-700">Asal Sekolah</label>
                    <input type="text" name="nama_sekolah" value="{{ $peserta->nama_sekolah }}" placeholder="Nama Sekolah SMA/SMK/MA" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <!-- Social Media & Additional Info -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" value="{{ $peserta->tahun_lulus }}" placeholder="2024" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">No. WhatsApp Guru BK</label>
                    <input type="text" name="no_guru_bk" value="{{ $peserta->no_guru_bk }}" placeholder="Contoh: 0812xxxx" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="col-span-full space-y-2">
                    <label class="text-sm font-bold text-gray-700">Kode Referal (Opsional)</label>
                    <input type="text" name="kode_referral" value="{{ $peserta->daftar->kode_referral ?? '' }}" placeholder="Masukkan kode referral jika ada" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <!-- <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Link Instagram</label>
                    <input type="text" name="link_ig" value="{{ $peserta->link_ig }}" placeholder="https://instagram.com/user" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Link TikTok</label>
                    <input type="text" name="link_tiktok" value="{{ $peserta->link_tiktok }}" placeholder="https://tiktok.com/@user" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div> -->
                <!-- <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Link Twibbon</label>
                    <input type="text" name="link_twibbon" value="{{ $peserta->link_twibbon }}" placeholder="Link Postingan Twibbon" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 outline-none">
                </div> -->
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
