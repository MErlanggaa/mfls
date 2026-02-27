@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-xl sm:text-2xl font-black text-gray-800">Evaluasi Peserta (Mentor)</h2>
        <p class="text-gray-500 text-sm">Berikan penilaian kualitatif untuk setiap peserta yang lolos seleksi berkas.</p>
    </div>
    <a href="{{ $type === 'mentor' ? route('admin.penilaian.index') : route('admin.penilaian.akademik.index') }}" class="inline-flex self-start sm:self-auto items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-2xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest">
        <span class="iconify" data-icon="solar:arrow-left-bold"></span> Kembali
    </a>
</div>

<div class="flex justify-center">
    <div class="w-full {{ $type !== 'admin' ? 'max-w-3xl' : '' }}">
        <div class="grid grid-cols-1 {{ $type === 'admin' ? 'lg:grid-cols-2' : '' }} gap-8">
    <!-- Form Input (Mentor) -->
    @if($type === 'mentor' && (auth()->user()->role === 'mentor' || auth()->user()->role === 'admin'))
    <div class="bg-white p-5 sm:p-8 rounded-[2rem] border {{ auth()->user()->role === 'mentor' ? 'border-blue-100 shadow-blue-50' : 'border-gray-100' }} shadow-sm self-start">
        <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-2">
            <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm">✍️</span>
            Form Penilaian Mentor
        </h3>
        
        <form action="{{ route('admin.pendaftar.mentor_nilai', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @php
                $myMentorEval = $user->peserta->penilaianMentors->where('mentor_id', auth()->id())->first();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kepemimpinan (35%)</label>
                    <input type="number" name="nilai_kepemimpinan" min="0" max="100" required 
                        value="{{ $myMentorEval->nilai_kepemimpinan ?? '' }}"
                        class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600" placeholder="0-100">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kepribadian (35%)</label>
                    <input type="number" name="nilai_kepribadian" min="0" max="100" required 
                        value="{{ $myMentorEval->nilai_kepribadian ?? '' }}"
                        class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600" placeholder="0-100">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Keaktifan (30%)</label>
                    <input type="number" name="nilai_keaktifan" min="0" max="100" required 
                        value="{{ $myMentorEval->nilai_keaktifan ?? '' }}"
                        class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600" placeholder="0-100">
                </div>
            </div>
            
            @if($myMentorEval)
            <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl flex justify-between items-center">
                <span class="text-xs font-bold text-blue-700 uppercase">Total Nilai Berbobot:</span>
                <span class="text-2xl font-black text-blue-700">{{ number_format($myMentorEval->nilai, 2) }}</span>
            </div>
            @endif

            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Kualitatif</label>
                <textarea name="catatan" rows="4" placeholder="Berikan alasan penilaian atau catatan perkembangan..."
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-semibold text-slate-700">{{ $myMentorEval->catatan ?? '' }}</textarea>
            </div>
            <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all">
                SIMPAN PENILAIAN MENTOR
            </button>
        </form>
    </div>
    @endif

    <!-- Form Input (Akademik) -->
    @if($type === 'akademik' && (auth()->user()->role === 'akademik' || auth()->user()->role === 'admin'))
    <div class="bg-white p-5 sm:p-8 rounded-[2rem] border {{ auth()->user()->role === 'akademik' ? 'border-orange-100 shadow-orange-50' : 'border-gray-100' }} shadow-sm">
        <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-2">
            <span class="w-8 h-8 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-sm">🎓</span>
            Form Penilaian Akademik (Dosen & Kemahasiswaan)
        </h3>
        
        <form action="{{ route('admin.penilaian.akademik.store', $user->id) }}" method="POST" class="space-y-8">
            @csrf
            @php
                $myAkademikEval = $user->peserta->penilaianAkademiks->where('penilai_id', auth()->id())->first();
            @endphp

            <!-- Bagian Dosen -->
            <div class="space-y-4">
                <h4 class="text-xs font-black text-orange-600 uppercase tracking-widest flex items-center gap-2 mb-4">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                    I. Penilaian Dosen (Prodi)
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Kompetensi Prodi</label>
                        <input type="number" name="dosen_kompetensi" min="0" max="100" required value="{{ $myAkademikEval->dosen_kompetensi ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-orange-600 outline-none font-bold text-orange-600" placeholder="0-100">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Motivasi Studi</label>
                        <input type="number" name="dosen_motivasi" min="0" max="100" required value="{{ $myAkademikEval->dosen_motivasi ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-orange-600 outline-none font-bold text-orange-600" placeholder="0-100">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Wawasan Akademik</label>
                        <input type="number" name="dosen_wawasan" min="0" max="100" required value="{{ $myAkademikEval->dosen_wawasan ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-orange-600 outline-none font-bold text-orange-600" placeholder="0-100">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Rencana Karir</label>
                        <input type="number" name="dosen_karir" min="0" max="100" required value="{{ $myAkademikEval->dosen_karir ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-orange-600 outline-none font-bold text-orange-600" placeholder="0-100">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Integritas Prodi</label>
                        <input type="number" name="dosen_integritas" min="0" max="100" required value="{{ $myAkademikEval->dosen_integritas ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-orange-600 outline-none font-bold text-orange-600" placeholder="0-100">
                    </div>
                </div>
            </div>

            <!-- Bagian Kemahasiswaan -->
            <div class="space-y-4">
                <h4 class="text-xs font-black text-blue-600 uppercase tracking-widest flex items-center gap-2 mb-4">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    II. Penilaian Kemahasiswaan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Leadership Potential</label>
                        <input type="number" name="mhs_leadership" min="0" max="100" required value="{{ $myAkademikEval->mhs_leadership ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-blue-600 outline-none font-bold text-blue-600" placeholder="0-100">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Pengalaman Organisasi</label>
                        <input type="number" name="mhs_organisasi" min="0" max="100" required value="{{ $myAkademikEval->mhs_organisasi ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-blue-600 outline-none font-bold text-blue-600" placeholder="0-100">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Etika & Karakter</label>
                        <input type="number" name="mhs_etika" min="0" max="100" required value="{{ $myAkademikEval->mhs_etika ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-blue-600 outline-none font-bold text-blue-600" placeholder="0-100">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Kemampuan Adaptasi</label>
                        <input type="number" name="mhs_adaptasi" min="0" max="100" required value="{{ $myAkademikEval->mhs_adaptasi ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-blue-600 outline-none font-bold text-blue-600" placeholder="0-100">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Komitmen Kontribusi</label>
                        <input type="number" name="mhs_komitmen" min="0" max="100" required value="{{ $myAkademikEval->mhs_komitmen ?? '' }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-blue-600 outline-none font-bold text-blue-600" placeholder="0-100">
                    </div>
                </div>
            </div>
            
            @if($myAkademikEval)
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-orange-50 border border-orange-100 rounded-2xl">
                    <span class="block text-[8px] font-black text-orange-400 uppercase mb-1">Total Dosen</span>
                    <span class="text-xl font-black text-orange-700">{{ number_format($myAkademikEval->total_dosen, 2) }}</span>
                </div>
                <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl">
                    <span class="block text-[8px] font-black text-blue-400 uppercase mb-1">Total Mhs</span>
                    <span class="text-xl font-black text-blue-700">{{ number_format($myAkademikEval->total_mhs, 2) }}</span>
                </div>
                <div class="col-span-2 p-4 bg-slate-900 border border-slate-800 rounded-2xl flex justify-between items-center text-white">
                    <span class="text-xs font-bold uppercase">HASIL AKHIR (AVERAGE):</span>
                    <span class="text-2xl font-black text-yellow-400">{{ number_format($myAkademikEval->total_akhir, 2) }}</span>
                </div>
            </div>
            @endif

            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Khusus Akademik</label>
                <textarea name="catatan" rows="4" placeholder="Berikan catatan terkait hasil wawancara prodi dan kemahasiswaan..."
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-orange-600 outline-none font-semibold text-slate-700">{{ $myAkademikEval->catatan ?? '' }}</textarea>
            </div>
            <button type="submit" class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-black transition-all">
                SIMPAN PENILAIAN DOUBLE
            </button>
        </form>
    </div>
    @endif
        </div>
    </div>

        <!-- History Summary -->
        <div class="grid grid-cols-1 {{ $type === 'admin' ? 'md:grid-cols-2' : '' }} gap-8 mt-12">
            <!-- History Mentor -->
            @if($type === 'mentor' || $type === 'admin')
            <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                <h4 class="font-black text-slate-800 mb-6 uppercase tracking-widest text-[10px]">Ringkasan Evaluasi Mentor</h4>
                @php $allMentorPenilaian = $user->peserta->penilaianMentors; @endphp
                @if($allMentorPenilaian->count() > 0)
                    <div class="space-y-4">
                        @foreach($allMentorPenilaian as $penilaian)
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-[10px] font-black text-blue-600 uppercase">{{ $penilaian->mentor->nama }}</span>
                                    <span class="text-lg font-black text-slate-900">{{ number_format($penilaian->nilai, 2) }}</span>
                                </div>
                                <p class="text-xs text-slate-500 font-semibold italic">"{{ $penilaian->catatan ?? 'Tidak ada catatan.' }}"</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-slate-400 p-8 font-bold italic text-xs">Belum ada penilaian mentor.</div>
                @endif
            </div>
            @endif

            <!-- History Akademik -->
            @if($type === 'akademik' || $type === 'admin')
            <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                <h4 class="font-black text-slate-800 mb-6 uppercase tracking-widest text-[10px]">Ringkasan Evaluasi Akademik (Dosen & Mhs)</h4>
                @php $allAkademikPenilaian = $user->peserta->penilaianAkademiks; @endphp
                @if($allAkademikPenilaian->count() > 0)
                    <div class="space-y-4">
                        @foreach($allAkademikPenilaian as $penilaian)
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-[10px] font-black text-orange-600 uppercase">{{ $penilaian->penilai->nama }}</span>
                                    <span class="text-lg font-black text-slate-900">{{ number_format($penilaian->total_akhir, 2) }}</span>
                                </div>
                                <div class="flex gap-2 mb-2">
                                    <span class="px-2 py-0.5 bg-orange-50 text-orange-600 rounded text-[8px] font-black">DOSEN: {{ $penilaian->total_dosen }}</span>
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[8px] font-black">MHS: {{ $penilaian->total_mhs }}</span>
                                </div>
                                <p class="text-xs text-slate-500 font-semibold italic">"{{ $penilaian->catatan ?? 'Tidak ada catatan.' }}"</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-slate-400 p-8 font-bold italic text-xs">Belum ada penilaian akademik.</div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
