@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Hasil Pengerjaan Soal</h2>
        <p class="text-gray-500">Pantau skor ujian (TPA, TBI, dll) dari seluruh pendaftar secara real-time.</p>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[10px] tracking-[0.2em]">
                <tr>
                    <th class="px-6 py-5">Peserta</th>
                    <th class="px-6 py-5">Jenis Ujian</th>
                    <th class="px-6 py-5 text-center">Skor Akhir</th>
                    <th class="px-6 py-5 text-center">Waktu Pengerjaan</th>
                    <th class="px-6 py-5 text-right">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($hasilUjians as $hasil)
                <tr class="hover:bg-slate-50/50 transition-all">
                    <td class="px-6 py-4">
                        <div class="font-black text-slate-800 uppercase">{{ $hasil->peserta->nama }}</div>
                        <div class="text-[10px] font-bold text-blue-500 uppercase">NISN: {{ $hasil->peserta->nisn }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                            {{ $hasil->ujian->nama }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-xl font-black {{ $hasil->nilai >= 80 ? 'text-green-600' : ($hasil->nilai >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
                            {{ number_format($hasil->nilai, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="text-xs font-bold text-slate-500">{{ $hasil->created_at->isoFormat('LLL') }}</div>
                        <div class="text-[9px] text-slate-400 uppercase font-black">{{ $hasil->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.beasiswa.show', $hasil->peserta->akun_id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[9px] font-black hover:bg-blue-600 hover:text-white transition-all shadow-sm uppercase tracking-widest">
                            Report Lulus 📑
                        </a>
                    </td>
                </tr>
                @endforeach
                @if($hasilUjians->isEmpty())
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="text-slate-300 font-black uppercase tracking-widest text-sm">Belum ada peserta yang mensubmit ujian.</div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
