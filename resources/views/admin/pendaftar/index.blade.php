@extends('layouts.admin')

@section('content')
<!-- Notifikasi Flash -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-500 text-white rounded-2xl shadow-lg shadow-green-200 flex items-center justify-between animate-bounce">
    <div class="flex items-center gap-3">
        <span>✅</span>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
</div>
@endif

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Seleksi Administrasi</h2>
        <p class="text-gray-500">Verifikasi Profil, Nilai Raport, dan Kelengkapan Berkas pendaftar.</p>
    </div>
    <div class="flex gap-3">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama/Sekolah..." class="px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm w-64 focus:outline-none focus:border-blue-600">
            <button type="submit" class="bg-dark-navy text-white px-4 py-3 rounded-xl hover:bg-black transition-colors">🔍</button>
        </form>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-500 font-black uppercase text-[10px] tracking-widest px-6 py-4">
                <tr>
                    <th class="px-6 py-5">Mahasiswa / NISN</th>
                    <th class="px-6 py-5 text-center">Rata-Rata Raport</th>
                    <th class="px-6 py-5 text-center">Kelengkapan Berkas</th>
                    <th class="px-6 py-5 text-center">Status Berkas</th>
                    <th class="px-6 py-5 text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($pendaftars as $akun)
                @php
                    $peserta = $akun->peserta;
                    $daftar = $peserta->daftar;
                    $berkas = $peserta->berkas;
                    
                    // Hitung kelengkapan
                    $totalRequired = 8;
                    $uploaded = 0;
                    if($berkas) {
                        if($berkas->foto) $uploaded++;
                        if($berkas->rapor1) $uploaded++;
                        if($berkas->rapor2) $uploaded++;
                        if($berkas->rapor3) $uploaded++;
                        if($berkas->rapor4) $uploaded++;
                        if($berkas->rapor5) $uploaded++;
                        if($berkas->ijazah) $uploaded++;
                        if($berkas->motivasi_video) $uploaded++;
                    }
                @endphp
                <tr class="hover:bg-slate-50/50 transition-all">
                    <td class="px-6 py-4">
                        <div class="font-black text-slate-800 uppercase">{{ $akun->nama }}</div>
                        <div class="text-[10px] font-bold text-blue-500 uppercase tracking-tighter">{{ $peserta->nama_sekolah }} • {{ $peserta->nisn }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-lg font-black {{ ($daftar->rata_rata_nilai ?? 0) >= 80 ? 'text-emerald-500' : 'text-slate-700' }}">
                            {{ number_format($daftar->rata_rata_nilai ?? 0, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            @for($i=0; $i<$totalRequired; $i++)
                                <div class="w-2 h-2 rounded-full {{ $i < $uploaded ? 'bg-emerald-400' : 'bg-slate-200' }}"></div>
                            @endfor
                        </div>
                        <div class="text-[9px] font-black mt-1 text-slate-400">{{ $uploaded }}/{{ $totalRequired }} FILE</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if(($daftar->status ?? 'menunggu') == 'lulus')
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black border border-emerald-100 uppercase tracking-widest">LULUS BERKAS</span>
                        @elseif(($daftar->status ?? 'menunggu') == 'tidak_lulus')
                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-[9px] font-black border border-red-100 uppercase tracking-widest">TIDAK LOLOS</span>
                        @else
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-600 rounded-lg text-[9px] font-black border border-yellow-100 uppercase tracking-widest animate-pulse">MENUNGGU</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('admin.pendaftar.show', $akun->id) }}" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[9px] font-black hover:bg-blue-600 hover:text-white transition-all shadow-sm uppercase tracking-widest">
                                VERIFIKASI SEKARANG 🔍
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
