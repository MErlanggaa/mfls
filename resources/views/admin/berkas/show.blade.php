@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-xl sm:text-2xl font-black text-gray-800">Verifikasi Berkas</h2>
        <p class="text-gray-500 text-sm">Dokumen Pendaftaran: {{ $user->nama }}</p>
    </div>
    <a href="{{ route('admin.berkas.index') }}" class="inline-flex self-start sm:self-auto items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-2xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest">
        <span class="iconify" data-icon="solar:arrow-left-bold"></span> Kembali
    </a>
</div>

<div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
    <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-2">
        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm">📂</span>
        Checklist Dokumen & Tugas
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $berkasList = [
                'Pas Foto Formal' => $user->peserta->berkas->foto ?? null,
                'Rapor Semester 1' => $user->peserta->berkas->rapor1 ?? null,
                'Rapor Semester 2' => $user->peserta->berkas->rapor2 ?? null,
                'Rapor Semester 3' => $user->peserta->berkas->rapor3 ?? null,
                'Rapor Semester 4' => $user->peserta->berkas->rapor4 ?? null,
                'Rapor Semester 5' => $user->peserta->berkas->rapor5 ?? null,
                'Ijazah / SKL' => $user->peserta->berkas->ijazah ?? null,
                'Video Motivasi' => $user->peserta->berkas->motivasi_video ?? null,
                'Personal Statement' => $user->peserta->berkas->personal_statement ?? null,
            ];
        @endphp
        @foreach($berkasList as $name => $path)
            <div class="p-6 rounded-3xl border {{ $path ? 'bg-blue-50/30 border-blue-100' : 'bg-slate-50 border-slate-200 opacity-60' }} transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 {{ $path ? 'bg-blue-600 text-white' : 'bg-slate-300 text-white' }} rounded-2xl flex items-center justify-center shadow-lg text-lg">
                        @if($path) ✓ @else ! @endif
                    </div>
                </div>
                <div class="text-lg font-black text-slate-800 mb-1">{{ $name }}</div>
                <div class="text-xs font-bold {{ $path ? 'text-blue-500' : 'text-slate-400' }} uppercase mb-4">{{ $path ? 'FILE TERSEDIA' : 'BELUM UPLOAD' }}</div>
                
                @if($path)
                    <a href="{{ asset('storage/'.$path) }}" target="_blank" class="inline-block px-6 py-2 bg-white border border-blue-200 text-blue-600 rounded-xl text-xs font-black shadow-sm hover:bg-blue-50 transition-all">
                        LIHAT DOKUMEN ↗
                    </a>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
