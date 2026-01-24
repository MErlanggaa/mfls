@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-800">Verifikasi Berkas</h2>
    <p class="text-gray-500">Cek kelengkapan dokumen pendaftaran (Rapor, Ijazah, Video).</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($pendaftars as $akun)
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-blue-500/5 transition-all group">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="font-black text-slate-800">{{ $akun->nama }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $akun->peserta->nisn }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 font-black">
                    {{ substr($akun->nama, 0, 1) }}
                </div>
            </div>

            @php
                $uploaded = 0;
                $total = 9;
                if($akun->peserta->berkas) {
                    if($akun->peserta->berkas->foto) $uploaded++;
                    if($akun->peserta->berkas->rapor1) $uploaded++;
                    if($akun->peserta->berkas->rapor2) $uploaded++;
                    if($akun->peserta->berkas->rapor3) $uploaded++;
                    if($akun->peserta->berkas->rapor4) $uploaded++;
                    if($akun->peserta->berkas->rapor5) $uploaded++;
                    if($akun->peserta->berkas->ijazah) $uploaded++;
                    if($akun->peserta->berkas->motivasi_video) $uploaded++;
                    if($akun->peserta->berkas->personal_statement) $uploaded++;
                }
                $percent = ($uploaded / $total) * 100;
            @endphp

            <div class="space-y-4 mb-6">
                <div class="flex justify-between items-end">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Progress Upload</span>
                    <span class="text-xs font-black text-blue-600">{{ $uploaded }}/{{ $total }} File</span>
                </div>
                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-600 transition-all duration-700" style="width: {{ $percent }}%"></div>
                </div>
            </div>

            <a href="{{ route('admin.berkas.show', $akun->id) }}" class="block w-full py-3 bg-blue-600 text-white rounded-2xl text-center text-xs font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all uppercase tracking-widest">
                VERIFIKASI FILE 📂
            </a>
        </div>
    @endforeach
</div>
@endsection
