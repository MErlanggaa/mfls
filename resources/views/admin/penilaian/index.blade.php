@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-800">Evaluasi Peserta oleh Mentor</h2>
    <p class="text-gray-500">Berikan penilaian kualitatif untuk setiap peserta.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($pendaftars as $akun)
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center font-black text-xl">
                    {{ substr($akun->nama, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-black text-slate-800 leading-tight">{{ $akun->nama }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PENDAFTAR MFLS</p>
                </div>
            </div>

            @php
                $myScore = $akun->peserta->penilaianMentors->where('mentor_id', auth()->id())->first();
            @endphp

            <div class="mb-6">
                @if($myScore)
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Penilaian</div>
                    <div class="flex items-center gap-2">
                        <span class="text-3xl font-black text-blue-600">{{ $myScore->nilai }}</span>
                        <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-0.5 rounded">SUDAH DINILAI</span>
                    </div>
                @else
                    <div class="py-4 text-center border-2 border-dashed border-slate-100 rounded-2xl text-xs font-bold text-slate-400">
                        BELUM DINILAI
                    </div>
                @endif
            </div>

            <a href="{{ route('admin.penilaian.show', $akun->id) }}" class="block w-full py-4 bg-dark-navy text-white rounded-2xl text-center text-xs font-black shadow-lg hover:bg-black transition-all uppercase tracking-widest">
                {{ $myScore ? 'Ubah Nilai ⭐' : 'Mulai Menilai ⭐' }}
            </a>
        </div>
    @endforeach
</div>
@endsection
