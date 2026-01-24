@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Manajemen Pendaftar</h2>
        <p class="text-gray-500">Kelola data, verifikasi berkas, dan kelulusan peserta.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.export') }}" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-bold transition-all shadow-lg shadow-green-600/20">
            <span>📊</span> Export Excel
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Peserta</th>
                    <th class="px-6 py-4">Asal Sekolah</th>
                    <th class="px-6 py-4">Rata-rata Nilai</th>
                    <th class="px-6 py-4">Rekomendasi Sistem</th>
                    <th class="px-6 py-4">Status Akhir</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($pendaftars as $akun)
                @php
                    $peserta = $akun->peserta;
                    $daftar = $peserta ? $peserta->daftar : null;
                    $nilai = $daftar ? $daftar->rata_rata_nilai : 0;
                @endphp
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $akun->nama }}</div>
                        <div class="text-xs text-gray-500">{{ $akun->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $daftar->asal_sekolah ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-lg {{ $nilai >= 90 ? 'text-green-600' : ($nilai >= 80 ? 'text-blue-600' : 'text-gray-600') }}">
                            {{ number_format($nilai, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($nilai >= 90)
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                <span>⭐</span> Sangat Direkomendasikan
                            </span>
                        @elseif($nilai >= 80)
                            <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold border border-blue-200">
                                <span>✅</span> Direkomendasikan
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold border border-gray-200">
                                <span>🔍</span> Perlu Review
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if(($daftar->status ?? 'menunggu') == 'lulus')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md shadow-green-500/20">LULUS</span>
                        @elseif(($daftar->status ?? 'menunggu') == 'tidak_lulus')
                            <span class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md shadow-red-500/20">TIDAK LULUS</span>
                        @else
                            <span class="bg-yellow-400 text-dark-navy px-3 py-1 rounded-lg text-xs font-bold">MENUNGGU</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <!-- Tombol Lulus -->
                            <form action="{{ route('admin.pendaftar.verify', $akun->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="lulus">
                                <button type="submit" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 flex items-center justify-center transition-colors" title="Luluskan">
                                    ✓
                                </button>
                            </form>

                            <!-- Tombol Tidak Lulus -->
                            <form action="{{ route('admin.pendaftar.verify', $akun->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="tidak_lulus">
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="Diskualifikasi">
                                    ✕
                                </button>
                            </form>
                            
                            <a href="{{ route('admin.pendaftar.show', $akun->id) }}" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 flex items-center justify-center transition-colors" title="Detail">
                                👁️
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($pendaftars->isEmpty())
    <div class="p-12 text-center">
        <div class="inline-block p-4 rounded-full bg-gray-50 text-gray-400 mb-4">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800">Belum ada pendaftar</h3>
        <p class="text-gray-500">Data pendaftar akan muncul di sini.</p>
    </div>
    @endif
</div>
@endsection
