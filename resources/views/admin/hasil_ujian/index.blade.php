@extends('layouts.admin')

@section('content')
<div class="mb-8 space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-2xl font-black text-gray-800">Hasil Pengerjaan Soal</h2>
            <p class="text-gray-500 font-medium">Kelola status kelulusan peserta ujian secara manual dan kirim email notifikasi.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <!-- Search Form -->
            <form action="{{ route('admin.hasil_ujian.index') }}" method="GET" class="w-full sm:w-80 relative">
                <input type="hidden" name="type" value="{{ request('type') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta..." class="w-full pl-12 pr-6 py-4 bg-white border border-gray-100 rounded-3xl text-sm font-bold shadow-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                <span class="iconify absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-xl" data-icon="solar:magnifer-linear"></span>
            </form>

            <!-- Tombol Kirim Email Massal -->
            @php
                $adaYangLulus = $hasilUjians->filter(fn($h) => ($h->status_seleksi ?? 'menunggu') === 'lulus' && !str_contains(strtolower($h->ujian->nama ?? ''), 'pemetaan diri'))->count();
            @endphp
            @if($adaYangLulus > 0)
            <form action="{{ route('admin.hasil_ujian.kirim_massal') }}" method="POST"
                  onsubmit="return confirm('Kirim email notifikasi lolos seleksi ujian ke {{ $adaYangLulus }} peserta yang telah dinyatakan LULUS?');">
                @csrf
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black uppercase tracking-widest rounded-3xl shadow-md transition-all whitespace-nowrap">
                    <span class="iconify text-lg" data-icon="solar:letter-bold"></span>
                    Kirim Email Massal ({{ $adaYangLulus }} Lulus)
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-6 py-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 font-bold text-sm">
            <span class="iconify text-xl flex-shrink-0" data-icon="solar:check-circle-bold"></span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-6 py-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 font-bold text-sm">
            <span class="iconify text-xl flex-shrink-0" data-icon="solar:danger-circle-bold"></span>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-2 p-1.5 bg-gray-100 rounded-[2rem] w-fit">
        <a href="{{ route('admin.hasil_ujian.index', ['search' => request('search')]) }}" class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ !request('type') ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Semua</a>
        <a href="{{ route('admin.hasil_ujian.index', ['type' => 'tba', 'search' => request('search')]) }}" class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ request('type') == 'tba' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">TBA (Akademik)</a>
        <a href="{{ route('admin.hasil_ujian.index', ['type' => 'tbi', 'search' => request('search')]) }}" class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ request('type') == 'tbi' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">TBI (Inggris)</a>
        <a href="{{ route('admin.hasil_ujian.index', ['type' => 'pemetaan_diri', 'search' => request('search')]) }}" class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all {{ request('type') == 'pemetaan_diri' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Pemetaan Diri</a>
    </div>

    {{-- Summary Stats --}}
    @php
        $totalCbt    = $hasilUjians->filter(fn($h) => !str_contains(strtolower($h->ujian->nama ?? ''), 'pemetaan diri'))->count();
        $totalLulus  = $hasilUjians->filter(fn($h) => ($h->status_seleksi ?? 'menunggu') === 'lulus' && !str_contains(strtolower($h->ujian->nama ?? ''), 'pemetaan diri'))->count();
        $totalGagal  = $hasilUjians->filter(fn($h) => ($h->status_seleksi ?? 'menunggu') === 'tidak_lulus' && !str_contains(strtolower($h->ujian->nama ?? ''), 'pemetaan diri'))->count();
        $totalMenunggu = $hasilUjians->filter(fn($h) => ($h->status_seleksi ?? 'menunggu') === 'menunggu' && !str_contains(strtolower($h->ujian->nama ?? ''), 'pemetaan diri'))->count();
    @endphp
    @if($totalCbt > 0)
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white border border-gray-100 rounded-2xl p-4 text-center shadow-sm">
            <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Peserta</div>
            <div class="text-2xl font-black text-slate-800">{{ $totalCbt }}</div>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 text-center shadow-sm">
            <div class="text-[9px] font-black text-amber-500 uppercase tracking-widest mb-1">⏳ Menunggu</div>
            <div class="text-2xl font-black text-amber-700">{{ $totalMenunggu }}</div>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 text-center shadow-sm">
            <div class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-1">✅ Lulus</div>
            <div class="text-2xl font-black text-emerald-700">{{ $totalLulus }}</div>
        </div>
        <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 text-center shadow-sm">
            <div class="text-[9px] font-black text-rose-400 uppercase tracking-widest mb-1">❌ Gagal</div>
            <div class="text-2xl font-black text-rose-600">{{ $totalGagal }}</div>
        </div>
    </div>
    @endif
</div>

<div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[10px] tracking-[0.2em]">
                <tr>
                    <th class="px-6 py-5">Peserta</th>
                    <th class="px-6 py-5">Jenis Ujian</th>
                    <th class="px-6 py-5 text-center">Skor Akhir</th>
                    <th class="px-6 py-5 text-center">Status Seleksi</th>
                    <th class="px-6 py-5 text-center">Waktu Pengerjaan</th>
                    <th class="px-6 py-5 text-right">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($hasilUjians as $hasil)
                @php
                    $isPemetaanDiri = str_contains(strtolower($hasil->ujian->nama ?? ''), 'pemetaan diri');
                    $status = $hasil->status_seleksi ?? 'menunggu';
                    $asalSekolah = $hasil->peserta->daftar->asal_sekolah ?? ($hasil->peserta->nama_sekolah ?? '-');
                @endphp
                <tr class="hover:bg-slate-50/50 transition-all">
                    <td class="px-6 py-4">
                        <div class="font-black text-slate-800 uppercase">{{ $hasil->peserta->akun->nama }}</div>
                        <div class="text-[10px] font-bold text-blue-500 uppercase">NISN: {{ $hasil->peserta->nisn }}</div>
                        <div class="text-[10px] font-semibold text-slate-400 mt-0.5">🏫 {{ $asalSekolah }}</div>
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
                        @if($isPemetaanDiri)
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-50 text-purple-600 text-[9px] font-black uppercase tracking-widest rounded-full border border-purple-100">
                                🧠 Pemetaan Diri
                            </span>
                        @elseif($status === 'lulus')
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[9px] font-black uppercase tracking-widest rounded-full border border-emerald-200">
                                ✅ Lulus Seleksi
                            </span>
                        @elseif($status === 'tidak_lulus')
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 text-rose-600 text-[9px] font-black uppercase tracking-widest rounded-full border border-rose-100">
                                ❌ Tidak Lulus
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 text-amber-700 text-[9px] font-black uppercase tracking-widest rounded-full border border-amber-200">
                                ⏳ Menunggu
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="text-xs font-bold text-slate-500">{{ $hasil->created_at->isoFormat('LLL') }}</div>
                        <div class="text-[9px] text-slate-400 uppercase font-black">{{ $hasil->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 flex-wrap items-center">
                            {{-- Aksi Manual Kelulusan (Kecuali Pemetaan Diri) --}}
                            @if(!$isPemetaanDiri)
                            <div class="inline-flex rounded-xl border border-slate-100 bg-slate-50 p-1 gap-1">
                                <form action="{{ route('admin.hasil_ujian.update_status', $hasil->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status_seleksi" value="lulus">
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all {{ $status === 'lulus' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-700' }}" title="Set Lulus">
                                        Lolos 👍
                                    </button>
                                </form>
                                <form action="{{ route('admin.hasil_ujian.update_status', $hasil->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status_seleksi" value="tidak_lulus">
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all {{ $status === 'tidak_lulus' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-700' }}" title="Set Tidak Lulus">
                                        Gagal 👎
                                    </button>
                                </form>
                            </div>
                            @endif

                            <a href="{{ route('admin.beasiswa.show', $hasil->peserta->akun_id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[9px] font-black hover:bg-blue-600 hover:text-white transition-all shadow-sm uppercase tracking-widest">
                                Report 📑
                            </a>

                            {{-- Tombol Kirim Email (hanya untuk yang lulus manual & bukan Pemetaan Diri) --}}
                            @if($status === 'lulus' && !$isPemetaanDiri)
                            <form action="{{ route('admin.hasil_ujian.kirim_email', $hasil->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Kirim email notifikasi lolos seleksi ujian ke {{ $hasil->peserta->akun->nama }}?');">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-[9px] font-black hover:bg-emerald-600 hover:text-white transition-all shadow-sm uppercase tracking-widest animate-bounce">
                                    <span class="iconify" data-icon="solar:letter-bold"></span> Email
                                </button>
                            </form>
                            @endif

                            <form action="{{ route('admin.hasil_ujian.reset', $hasil->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mereset/menghapus jawaban ini? Peserta akan bisa mengerjakan ujian kembali.');">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-[9px] font-black hover:bg-red-600 hover:text-white transition-all shadow-sm uppercase tracking-widest">
                                    Hapus 🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($hasilUjians->isEmpty())
                <tr>
                    <td colspan="6" class="py-20 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-6">
                                <span class="iconify text-4xl text-slate-400" data-icon="solar:document-cross-bold"></span>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 mb-2">Belum Ada Data Ujian</h3>
                            <p class="text-slate-500 font-medium">Peserta belum ada yang mengerjakan ujian.</p>
                            <p class="text-sm text-slate-400 mt-2">Data akan muncul setelah peserta menyelesaikan ujian online.</p>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
