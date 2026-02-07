@extends('layouts.admin')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h2 class="text-2xl font-black text-slate-800">
            {{ $type === 'mentor' ? 'Evaluasi Peserta (Mentor)' : 'Evaluasi Peserta (Akademik)' }}
        </h2>
        <p class="text-slate-500 font-medium">Berikan penilaian kualitatif untuk setiap peserta yang lolos seleksi berkas.</p>
    </div>
</div>

<!-- Filter & Search Section -->
<div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm mb-8">
    <form action="{{ $type === 'mentor' ? route('admin.penilaian.index') : route('admin.penilaian.akademik.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
        <div class="relative flex-grow">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <span class="iconify" data-icon="solar:magnifer-bold"></span>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, sekolah, atau kabupaten..." 
                class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/20 outline-none font-bold text-slate-700">
        </div>
        
        <div class="flex flex-wrap gap-2">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-4 rounded-2xl text-[10px] font-black hover:bg-indigo-700 transition-all uppercase tracking-[0.2em] shadow-lg shadow-indigo-100 flex items-center gap-2">
                <span class="iconify" data-icon="solar:magnifer-bold"></span>
                Cari Peserta
            </button>
            @if(request()->has('search'))
                <a href="{{ route('admin.penilaian.index') }}" class="bg-slate-100 text-slate-500 px-6 py-4 rounded-2xl text-[10px] font-black hover:bg-slate-200 transition-all uppercase tracking-[0.2em] flex items-center gap-2">
                    <span class="iconify" data-icon="solar:refresh-bold"></span>
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

@if($pendaftars->isEmpty())
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-20">
    <div class="text-center">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="iconify text-5xl text-slate-200" data-icon="solar:user-block-bold-duotone"></span>
        </div>
        <h3 class="text-xl font-black text-slate-800 mb-2">Tidak Ada Hasil</h3>
        <p class="text-slate-500 font-medium">Maaf, kami tidak menemukan peserta yang sesuai dengan kata kunci Anda.</p>
        <a href="{{ route('admin.penilaian.index') }}" class="inline-block mt-6 text-blue-600 font-bold hover:underline">Lihat Semua Peserta</a>
    </div>
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($pendaftars as $akun)
        <div class="group bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center gap-5 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 rounded-2xl flex items-center justify-center font-black text-2xl shadow-inner group-hover:from-blue-600 group-hover:to-indigo-600 group-hover:text-white transition-all duration-500">
                    {{ substr($akun->nama, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-slate-800 text-lg leading-tight truncate">{{ $akun->nama }}</h3>
                    <div class="flex items-center gap-2 text-slate-400 mt-1">
                        <span class="iconify shrink-0" data-icon="solar:square-academic-cap-bold"></span>
                        <p class="text-[10px] font-bold uppercase tracking-widest truncate">{{ $akun->peserta->nama_sekolah ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4 mb-8">
                <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 shadow-sm font-bold">
                        <span class="iconify" data-icon="solar:map-point-bold"></span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Lokasi</p>
                        <p class="text-xs font-bold text-slate-700 truncate">{{ $akun->peserta->kabupaten ?? '-' }}, {{ $akun->peserta->provinsi ?? '-' }}</p>
                    </div>
                </div>

                @php
                    if($type === 'mentor') {
                        $myScore = $akun->peserta->penilaianMentors->where('mentor_id', auth()->id())->first();
                        $label = 'Skor Mentor';
                        $scoreVal = $myScore ? $myScore->nilai : null;
                        $themeColor = 'blue';
                    } else {
                        $myScore = $akun->peserta->penilaianAkademiks->where('penilai_id', auth()->id())->first();
                        $label = 'Skor Akademik';
                        $scoreVal = $myScore ? $myScore->total_akhir : null;
                        $themeColor = 'orange';
                    }
                @endphp

                <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                    @if($myScore)
                        <div class="flex items-center justify-between font-black">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest leading-none mb-1">{{ $label }}</p>
                                <span class="text-3xl text-{{ $themeColor }}-600">{{ $scoreVal }}</span>
                            </div>
                            <div class="flex items-center gap-2 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl border border-emerald-100 shadow-sm">
                                <span class="iconify" data-icon="solar:verified-check-bold"></span>
                                <span class="text-[10px] uppercase tracking-widest font-black">SELESAI</span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between text-slate-400">
                            <p class="text-[10px] uppercase tracking-widest font-black">Belum Dinilai</p>
                            <span class="iconify text-xl animate-pulse" data-icon="solar:star-linear"></span>
                        </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('admin.penilaian.show', ['id' => $akun->id, 'type' => $type]) }}" class="block w-full py-4 rounded-2xl text-center text-[10px] font-black shadow-lg transition-all uppercase tracking-[0.2em] flex items-center justify-center gap-3 {{ $myScore ? 'bg-slate-50 text-slate-600 border border-slate-100 hover:bg-slate-100' : 'bg-'.$themeColor.'-600 text-white hover:bg-'.$themeColor.'-700 shadow-'.$themeColor.'-200' }}">
                <span class="iconify" data-icon="{{ $myScore ? 'solar:pen-bold' : 'solar:play-bold' }}"></span>
                {{ $myScore ? 'Ubah Penilaian' : 'Mulai Evaluasi' }}
            </a>
        </div>
    @endforeach
</div>
@endif
@endsection
