@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Manajemen Tim Mentor</h2>
        <p class="text-gray-500">Pantau dan kelola akun operasional Mentor MFLS.</p>
    </div>
    <button class="px-6 py-3 bg-blue-600 text-white rounded-2xl text-sm font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all uppercase tracking-widest">+ Tambah Mentor</button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($mentors as $mentor)
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all relative overflow-hidden group">
        <div class="absolute top-0 left-0 w-full h-1 bg-blue-600"></div>
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 font-black text-xl shadow-inner">
                {{ substr($mentor->nama, 0, 1) }}
            </div>
            <div>
                <h3 class="font-black text-slate-800 text-sm mb-0.5">{{ $mentor->nama }}</h3>
                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded text-[9px] font-black uppercase tracking-widest">MENTOR AKTIF</span>
            </div>
        </div>

        <div class="space-y-3 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400">Handle Pendaftar</span>
                <span class="text-sm font-black text-slate-800">{{ $mentor->peserta_count }} Peserta</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400">Penilaian Selesai</span>
                <span class="text-sm font-black text-green-600">{{ $mentor->peserta_count }} / {{ $mentor->peserta_count }}</span>
            </div>
        </div>

        <div class="flex gap-2">
            <button class="flex-1 py-3 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black hover:bg-slate-100 transition-all uppercase tracking-widest">Edit Akun</button>
            <button class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">🗑️</button>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-12 bg-blue-50 p-8 rounded-[2rem] border border-blue-100 flex items-center gap-6">
    <div class="text-4xl">💡</div>
    <div>
        <h4 class="font-black text-blue-900 mb-1">Informasi Manajemen Mentor</h4>
        <p class="text-sm text-blue-700 font-semibold leading-relaxed">
            Sidebar ini membantu Administrator untuk mengontrol siapa saja yang memiliki akses sebagai penilai (Mentor). <br>
            Setiap mentor memiliki tanggung jawab untuk memberikan nilai kualitatif kepada peserta yang ditugaskan kepada mereka.
        </p>
    </div>
</div>
@endsection
