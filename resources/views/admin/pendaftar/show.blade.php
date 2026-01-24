@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Profil Pendaftar</h2>
        <p class="text-gray-500">Informasi basic seleksi: {{ $user->nama }}</p>
    </div>
    <a href="{{ route('admin.pendaftar.index') }}" class="text-blue-600 font-bold hover:underline">← Kembali</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Utama -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50/50 rounded-full translate-x-1/2 -translate-y-1/2"></div>
            
            <div class="flex items-center gap-8 mb-10 relative">
                <div class="w-32 h-32 bg-blue-600 text-white rounded-[2rem] flex items-center justify-center text-5xl font-black shadow-2xl shadow-blue-200">
                    {{ substr($user->nama, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-4xl font-black text-slate-900 mb-2">{{ $user->nama }}</h1>
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-xl text-xs font-black uppercase tracking-widest">{{ $user->peserta->nisn }}</span>
                        <span class="text-slate-400 font-bold">•</span>
                        <span class="text-slate-500 font-bold uppercase text-xs tracking-widest">{{ $user->peserta->kabupaten }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12 border-t border-slate-50 pt-10">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Alamat Email</label>
                    <p class="font-black text-slate-800">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">No. WhatsApp</label>
                    <p class="font-black text-slate-800">{{ $user->peserta->no_whatsapp }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Tanggal Lahir</label>
                    <p class="font-black text-slate-800">{{ \Carbon\Carbon::parse($user->peserta->tgl_lahir)->isoFormat('LL') }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Jenis Kelamin</label>
                    <p class="font-black text-slate-800">{{ $user->peserta->jenis_kelamin }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center text-xl">🏫</span>
                Latar Belakang Pendidikan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Institusi / Sekolah</label>
                    <p class="font-black text-slate-800">{{ $user->peserta->nama_sekolah }}</p>
                </div>
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tahun Lulus</label>
                    <p class="font-black text-slate-800">{{ $user->peserta->tahun_lulus }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Detail -->
    <div class="space-y-8">
        <div class="bg-dark-navy p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full"></div>
            <h3 class="text-lg font-black mb-6 uppercase tracking-widest">Status Seleksi</h3>
            
            <div class="mb-8">
                @if($user->peserta->daftar->status == 'lulus')
                    <span class="block w-full py-4 bg-green-500 rounded-2xl text-center font-black text-sm shadow-lg shadow-green-500/20">LULUS SELEKSI ✅</span>
                @elseif($user->peserta->daftar->status == 'tidak_lulus')
                    <span class="block w-full py-4 bg-red-500 rounded-2xl text-center font-black text-sm shadow-lg shadow-red-500/20">TIDAK LULUS ✕</span>
                @else
                    <span class="block w-full py-4 bg-yellow-500 text-blue-900 rounded-2xl text-center font-black text-sm shadow-lg shadow-yellow-500/20">MENUNGGU VERIFIKASI ⏳</span>
                @endif
            </div>

            @if(auth()->user()->role !== 'mentor')
            <div class="flex flex-col gap-3">
                <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="lulus">
                    <button type="submit" class="w-full py-4 bg-white/10 hover:bg-white/20 rounded-2xl font-black text-xs transition-all uppercase tracking-widest">Tandai Lulus</button>
                </form>
                <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="tidak_lulus">
                    <button type="submit" class="w-full py-4 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-2xl font-black text-xs transition-all uppercase tracking-widest border border-red-500/20">Tandai Tidak Lulus</button>
                </form>
            </div>
            @endif
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Aksi Cepat</h4>
            <div class="space-y-3">
                <a href="{{ route('admin.raport.show', $user->id) }}" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 rounded-2xl font-black text-xs transition-all border border-slate-100">
                    LIHAT RAPORT 📚 <span>→</span>
                </a>
                <a href="{{ route('admin.berkas.show', $user->id) }}" class="flex items-center justify-between p-4 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 rounded-2xl font-black text-xs transition-all border border-slate-100">
                    LIHAT BERKAS 📂 <span>→</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
