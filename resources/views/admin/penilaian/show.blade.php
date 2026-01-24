@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Evaluasi Mentor</h2>
        <p class="text-gray-500">Memberikan penilaian untuk: {{ $user->nama }}</p>
    </div>
    <a href="{{ route('admin.penilaian.index') }}" class="text-blue-600 font-bold hover:underline">← Kembali</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Form Input -->
    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
        <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-2">
            <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm">✍️</span>
            Form Penilaian
        </h3>
        
        <form action="{{ route('admin.pendaftar.mentor_nilai', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nilai Evaluasi (0-100)</label>
                <input type="number" name="nilai" min="0" max="100" required 
                    value="{{ $user->peserta->penilaianMentors->where('mentor_id', auth()->id())->first()->nilai ?? '' }}"
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-2xl text-blue-600">
            </div>
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Kualitatif</label>
                <textarea name="catatan" rows="6" placeholder="Berikan alasan penilaian atau catatan perkembangan..."
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-semibold text-slate-700">{{ $user->peserta->penilaianMentors->where('mentor_id', auth()->id())->first()->catatan ?? '' }}</textarea>
            </div>
            <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all">
                SIMPAN PENILAIAN
            </button>
        </form>
    </div>

    <!-- History / Summary -->
    <div class="space-y-6">
        <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
            <h4 class="font-black text-slate-800 mb-6 uppercase tracking-widest text-[10px]">Ringkasan Evaluasi Mentor Lain</h4>
            @php
                $allPenilaian = $user->peserta->penilaianMentors;
            @endphp
            @if($allPenilaian->count() > 0)
                <div class="space-y-4">
                    @foreach($allPenilaian as $penilaian)
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-all hover:border-blue-300">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-black text-blue-600 uppercase">{{ $penilaian->mentor->nama }}</span>
                                <span class="text-lg font-black text-slate-900">{{ $penilaian->nilai }} <span class="text-[10px] text-slate-400">PTS</span></span>
                            </div>
                            <p class="text-xs text-slate-500 font-semibold italic leading-relaxed">"{{ $penilaian->catatan ?? 'Tidak ada catatan.' }}"</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-slate-400 p-8 font-bold italic">Belum ada penilaian dari mentor manapun.</div>
            @endif
        </div>
    </div>
</div>
@endsection
