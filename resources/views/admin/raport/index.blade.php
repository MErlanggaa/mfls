@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Manajemen Akademik</h2>
        <p class="text-gray-500">Pantau perolehan nilai raport semester 1-6.</p>
    </div>
    <div class="flex gap-2">
        <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-xs font-black border border-blue-100 uppercase tracking-widest">Global Avg: {{ number_format($pendaftars->avg('peserta.daftar.rata_rata_nilai'), 2) }}</span>
    </div>
</div>

<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[10px] tracking-[0.2em]">
                <tr>
                    <th class="px-6 py-5">Pendaftar</th>
                    <th class="px-6 py-5">Kode Ref</th>
                    <th class="px-6 py-5 text-center">Rata-Rata</th>
                    <th class="px-6 py-5">Rekomendasi</th>
                    <th class="px-6 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($pendaftars as $akun)
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-6 py-4">
                        <div class="font-black text-slate-800">{{ $akun->nama }}</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $akun->peserta->nama_sekolah }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">{{ $akun->peserta->daftar->kode_referral ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="text-lg font-black text-slate-800">{{ number_format($akun->peserta->daftar->rata_rata_nilai, 2) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($akun->peserta->daftar->rata_rata_nilai >= 90)
                            <span class="text-[10px] font-black text-green-600 bg-green-50 px-3 py-1.5 rounded-full border border-green-100">SANGAT DIREKOMENDASIKAN</span>
                        @elseif($akun->peserta->daftar->rata_rata_nilai >= 80)
                            <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full border border-blue-100">DIREKOMENDASIKAN</span>
                        @else
                            <span class="text-[10px] font-black text-slate-400 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">STANDAR</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.raport.show', $akun->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-black text-slate-700 hover:border-blue-600 hover:text-blue-600 transition-all shadow-sm">
                            LIHAT NILAI 📚
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
