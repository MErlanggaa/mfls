@extends('layouts.admin')

@section('content')
<!-- Header Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-[2rem] p-6 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
        <h3 class="text-xs font-bold opacity-80 uppercase tracking-widest flex items-center gap-2">
            <span class="iconify" data-icon="solar:shield-check-bold"></span> Menunggu Verifikasi Final
        </h3>
        <p class="text-4xl font-black mt-2">{{ $pendaftars->count() }}</p>
        <div class="mt-4 text-xs font-bold bg-white/20 inline-block px-3 py-1 rounded-full">Double Check Required</div>
    </div>
    
    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-blue-200 transition-colors">
        <div class="absolute right-0 top-0 w-20 h-20 bg-blue-50 rounded-full blur-2xl -mr-5 -mt-5"></div>
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
            <span class="iconify text-blue-500" data-icon="solar:info-circle-bold"></span> Peran Palugada
        </h3>
        <p class="text-sm font-medium text-slate-600 mt-2">
            Anda bertanggung jawab untuk melakukan verifikasi akhir pada pendaftar yang telah disetujui oleh Admin/Panitia.
        </p>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
    <!-- Toolbar -->
    <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Final Verification Hub</h2>
            <p class="text-slate-500 text-sm font-medium mt-1">Daftar pendaftar yang memerlukan persetujuan akhir.</p>
        </div>
        <div class="flex items-center gap-4">
            <form method="GET" class="relative w-full md:w-auto">
                <span class="iconify absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" data-icon="solar:magnifer-linear"></span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / Email..." 
                    class="pl-12 pr-6 py-3 w-full md:w-64 bg-slate-50 border-transparent focus:bg-white focus:border-blue-200 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm font-bold transition-all outline-none text-slate-600">
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-50">
                    <th class="px-8 py-6">Kandidat</th>
                    <th class="px-4 py-6 text-center">AVG Nilai</th>
                    <th class="px-6 py-6 text-left">Minat Prodi</th>
                    <th class="px-6 py-6 text-center">Progress</th>
                    <th class="px-6 py-6 text-center">Status Saat Ini</th>
                    <th class="px-8 py-6 text-right">Tindakan Cepat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pendaftars as $akun)
                @php
                    $peserta = $akun->peserta;
                    $daftar = $peserta->daftar;
                    $percentage = $peserta->progress;
                @endphp
                <tr class="group hover:bg-blue-50/30 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="relative w-12 h-12 rounded-2xl overflow-hidden shadow-sm border border-slate-100 group-hover:scale-105 transition-transform">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($akun->nama) }}&background=random&color=fff" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">{{ $akun->nama }}</div>
                                <div class="text-[10px] font-bold text-slate-400 mt-0.5 uppercase tracking-wide">{{ $peserta->nama_sekolah ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-5 text-center">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-black border border-blue-200">
                            {{ number_format($daftar->rata_rata_nilai ?? 0, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="font-bold text-slate-800 text-xs">{{ $peserta->pilihan_prodi ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $progressColor = $percentage == 100 ? 'text-emerald-600 bg-emerald-50' : ($percentage >= 50 ? 'text-blue-600 bg-blue-50' : 'text-orange-600 bg-orange-50');
                        @endphp
                        <div class="inline-flex flex-col items-center">
                            <span class="px-2.5 py-1 {{ $progressColor }} rounded-lg text-[11px] font-black mb-2 border border-current/10">
                                {{ $percentage }}%
                            </span>
                            <div class="w-20 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full {{ $percentage == 100 ? 'bg-emerald-500' : 'bg-blue-500' }} rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-wide border border-blue-100">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span> Double Check
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                         <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.pendaftar.show', $akun->id) }}" class="h-9 px-4 bg-blue-600 text-white rounded-xl text-[10px] font-black hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/20 flex items-center gap-2 border border-blue-500">
                                <span>DETAIL & VERIFIKASI</span>
                                <span class="iconify" data-icon="solar:shield-check-bold"></span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(count($pendaftars) == 0)
    <div class="p-20 text-center">
        <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="iconify text-4xl" data-icon="solar:check-circle-bold"></span>
        </div>
        <h3 class="text-lg font-black text-slate-400">Semua Beres!</h3>
        <p class="text-slate-400 text-sm font-medium">Tidak ada pendaftar yang menunggu verifikasi final saat ini.</p>
    </div>
    @endif
</div>
@endsection
