@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-xl sm:text-2xl font-black text-gray-800">
            {{ $type === 'mentor' ? 'Evaluasi Peserta (Mentor)' : 'Evaluasi Peserta (Akademik)' }}
        </h2>
        <p class="text-gray-500 text-sm">Update penilaian kualitatif untuk setiap peserta.</p>
    </div>
    <a href="{{ $type === 'mentor' ? route('admin.penilaian.index') : route('admin.penilaian.akademik.index') }}" class="inline-flex self-start sm:self-auto items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-2xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest">
        <span class="iconify" data-icon="solar:arrow-left-bold"></span> Kembali
    </a>
</div>

<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Main Form Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Form Input (Mentor) -->
            @if($type === 'mentor' && (auth()->user()->role === 'mentor' || auth()->user()->role === 'admin'))
            <div class="bg-white p-5 sm:p-10 rounded-[2.5rem] border {{ auth()->user()->role === 'mentor' ? 'border-blue-100 shadow-xl shadow-blue-500/5' : 'border-gray-100' }} shadow-sm">
                <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-3">
                    <span class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-lg">
                        <span class="iconify" data-icon="solar:pen-new-square-bold"></span>
                    </span>
                    Form Penilaian Mentor
                </h3>
                
                <form action="{{ route('admin.pendaftar.mentor_nilai', $user->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @php
                        $myMentorEval = $user->peserta->penilaianMentors->where('mentor_id', auth()->id())->first();
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kepemimpinan (35%)</label>
                            <input type="number" name="nilai_kepemimpinan" min="0" max="100" required 
                                value="{{ $myMentorEval->nilai_kepemimpinan ?? '' }}"
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600 transition-all" placeholder="0">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kepribadian (35%)</label>
                            <input type="number" name="nilai_kepribadian" min="0" max="100" required 
                                value="{{ $myMentorEval->nilai_kepribadian ?? '' }}"
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600 transition-all" placeholder="0">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Keaktifan (30%)</label>
                            <input type="number" name="nilai_keaktifan" min="0" max="100" required 
                                value="{{ $myMentorEval->nilai_keaktifan ?? '' }}"
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600 transition-all" placeholder="0">
                        </div>
                    </div>
                    
                    @if($myMentorEval)
                    <div class="p-6 bg-blue-50 border border-blue-100 rounded-[1.5rem] flex justify-between items-center shadow-inner">
                        <span class="text-xs font-black text-blue-700 uppercase tracking-widest">Total Nilai Berbobot</span>
                        <span class="text-4xl font-black text-blue-700">{{ number_format($myMentorEval->nilai, 2) }}</span>
                    </div>
                    @endif

                    <div class="space-y-4">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">
                            <span class="iconify" data-icon="solar:notes-bold"></span> Catatan Kualitatif
                        </label>
                        <textarea name="catatan" rows="5" placeholder="Berikan alasan penilaian atau catatan perkembangan..."
                            class="w-full px-8 py-6 bg-slate-50 border border-slate-200 rounded-[2rem] focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-semibold text-slate-700 shadow-inner transition-all">{{ $myMentorEval->catatan ?? '' }}</textarea>
                    </div>
                    
                    <button type="submit" class="group w-full py-6 bg-blue-600 text-white font-black rounded-[2rem] shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                        <span class="text-sm uppercase tracking-[0.2em]">Simpan Penilaian Mentor</span>
                        <span class="iconify text-xl group-hover:translate-x-1 transition-transform" data-icon="solar:arrow-right-bold"></span>
                    </button>
                </form>
            </div>
            @endif

            <!-- Form Input (Akademik) -->
            @if($type === 'akademik' && (auth()->user()->role === 'akademik' || auth()->user()->role === 'admin'))
            <div class="bg-white p-5 sm:p-10 rounded-[2.5rem] border {{ auth()->user()->role === 'akademik' ? 'border-orange-100 shadow-xl shadow-orange-500/5' : 'border-gray-100' }} shadow-sm">
                <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-100">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-200">
                        <span class="iconify text-2xl" data-icon="solar:diploma-bold"></span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Penilaian Wawancara</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Dosen Prodi & Kemahasiswaan</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.penilaian.akademik.store', $user->id) }}" method="POST" class="space-y-12">
                    @csrf
                    @php
                        $myAkademikEval = $user->peserta->penilaianAkademiks->where('penilai_id', auth()->id())->first();
                    @endphp

                    <!-- Bagian Dosen -->
                    <div class="p-6 sm:p-8 bg-orange-50/30 rounded-[2rem] border border-orange-100/50 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="iconify text-6xl" data-icon="solar:library-bold"></span>
                        </div>
                        
                        <h4 class="text-sm font-black text-orange-600 uppercase tracking-[0.2em] flex items-center gap-3 mb-8 relative z-10">
                            <span class="w-3 h-3 bg-orange-500 rounded-full shadow-sm"></span>
                            I. Penilaian Dosen (Prodi)
                        </h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 relative z-10">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:star-bold"></span> Kompetensi Prodi
                                </label>
                                <input type="number" name="dosen_kompetensi" min="0" max="100" required value="{{ $myAkademikEval->dosen_kompetensi ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-orange-100 rounded-2xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none font-black text-xl text-orange-600 transition-all shadow-sm" placeholder="0">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:fire-bold"></span> Motivasi Studi
                                </label>
                                <input type="number" name="dosen_motivasi" min="0" max="100" required value="{{ $myAkademikEval->dosen_motivasi ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-orange-100 rounded-2xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none font-black text-xl text-orange-600 transition-all shadow-sm" placeholder="0">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:globus-bold"></span> Wawasan Akademik
                                </label>
                                <input type="number" name="dosen_wawasan" min="0" max="100" required value="{{ $myAkademikEval->dosen_wawasan ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-orange-100 rounded-2xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none font-black text-xl text-orange-600 transition-all shadow-sm" placeholder="0">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:case-bold"></span> Rencana Karir
                                </label>
                                <input type="number" name="dosen_karir" min="0" max="100" required value="{{ $myAkademikEval->dosen_karir ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-orange-100 rounded-2xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none font-black text-xl text-orange-600 transition-all shadow-sm" placeholder="0">
                            </div>
                            <div class="col-span-1 sm:col-span-2 space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:shield-check-bold"></span> Integritas Prodi
                                </label>
                                <input type="number" name="dosen_integritas" min="0" max="100" required value="{{ $myAkademikEval->dosen_integritas ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-orange-100 rounded-2xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none font-black text-xl text-orange-600 transition-all shadow-sm" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Kemahasiswaan -->
                    <div class="p-6 sm:p-8 bg-blue-50/30 rounded-[2rem] border border-blue-100/50 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="iconify text-6xl" data-icon="solar:users-group-two-rounded-bold"></span>
                        </div>

                        <h4 class="text-sm font-black text-blue-600 uppercase tracking-[0.2em] flex items-center gap-3 mb-8 relative z-10">
                            <span class="w-3 h-3 bg-blue-500 rounded-full shadow-sm"></span>
                            II. Penilaian Kemahasiswaan
                        </h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 relative z-10">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:medal-star-bold"></span> Leadership Potential
                                </label>
                                <input type="number" name="mhs_leadership" min="0" max="100" required value="{{ $myAkademikEval->mhs_leadership ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-blue-100 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600 transition-all shadow-sm" placeholder="0">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:structure-bold"></span> Pengalaman Organisasi
                                </label>
                                <input type="number" name="mhs_organisasi" min="0" max="100" required value="{{ $myAkademikEval->mhs_organisasi ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-blue-100 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600 transition-all shadow-sm" placeholder="0">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:hand-shake-bold"></span> Etika & Karakter
                                </label>
                                <input type="number" name="mhs_etika" min="0" max="100" required value="{{ $myAkademikEval->mhs_etika ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-blue-100 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600 transition-all shadow-sm" placeholder="0">
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:bolt-bold"></span> Kemampuan Adaptasi
                                </label>
                                <input type="number" name="mhs_adaptasi" min="0" max="100" required value="{{ $myAkademikEval->mhs_adaptasi ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-blue-100 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600 transition-all shadow-sm" placeholder="0">
                            </div>
                            <div class="col-span-1 sm:col-span-2 space-y-2">
                                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                    <span class="iconify" data-icon="solar:hand-heart-bold"></span> Komitmen Kontribusi
                                </label>
                                <input type="number" name="mhs_komitmen" min="0" max="100" required value="{{ $myAkademikEval->mhs_komitmen ?? '' }}"
                                    class="w-full px-5 py-4 bg-white border border-blue-100 rounded-2xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 outline-none font-black text-xl text-blue-600 transition-all shadow-sm" placeholder="0">
                            </div>
                        </div>
                    </div>
                    
                    @if($myAkademikEval)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-6 bg-orange-50 border border-orange-100 rounded-[1.5rem] shadow-sm">
                            <span class="block text-[10px] font-black text-orange-400 uppercase tracking-widest mb-2">Total Dosen</span>
                            <span class="text-3xl font-black text-orange-700">{{ number_format($myAkademikEval->total_dosen, 2) }}</span>
                        </div>
                        <div class="p-6 bg-blue-50 border border-blue-100 rounded-[1.5rem] shadow-sm">
                            <span class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">Total Kemahasiswaan</span>
                            <span class="text-3xl font-black text-blue-700">{{ number_format($myAkademikEval->total_mhs, 2) }}</span>
                        </div>
                        <div class="p-6 bg-slate-900 border border-slate-800 rounded-[1.5rem] flex flex-col justify-center text-white shadow-xl">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">SKOR AKHIR</span>
                            <span class="text-4xl font-black text-yellow-400">{{ number_format($myAkademikEval->total_akhir, 2) }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="space-y-4">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">
                            <span class="iconify" data-icon="solar:notes-bold"></span> Catatan Rekomendasi
                        </label>
                        <textarea name="catatan" rows="5" placeholder="Berikan catatan mendalam terkait potensi calon mahasiswa ini..."
                            class="w-full px-8 py-6 bg-slate-50 border border-slate-200 rounded-[2rem] focus:border-slate-400 outline-none font-semibold text-slate-700 shadow-inner transition-all">{{ $myAkademikEval->catatan ?? '' }}</textarea>
                    </div>
                    
                    <button type="submit" class="group w-full py-6 bg-slate-900 text-white font-black rounded-[2rem] shadow-2xl shadow-slate-200 hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                        <span class="text-sm uppercase tracking-[0.2em]">Simpan Evaluasi Wawancara</span>
                        <span class="iconify text-xl group-hover:translate-x-1 transition-transform" data-icon="solar:arrow-right-bold"></span>
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Right Side: History & Summary Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Summary Mentor -->
            @if($type === 'mentor' || $type === 'admin')
            <div class="bg-slate-50 p-6 sm:p-8 rounded-[2.5rem] border border-slate-100">
                <h4 class="font-black text-slate-800 mb-6 uppercase tracking-[0.2em] text-[10px] flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Ringkasan Evaluasi Mentor
                </h4>
                @php $allMentorPenilaian = $user->peserta->penilaianMentors; @endphp
                @if($allMentorPenilaian->count() > 0)
                    <div class="space-y-4">
                        @foreach($allMentorPenilaian as $penilaian)
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">{{ $penilaian->mentor->nama ?? 'Unknown Mentor' }}</span>
                                    <span class="text-xl font-black text-slate-900">{{ number_format($penilaian->nilai, 2) }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500 font-semibold italic border-l-2 border-slate-100 pl-3">"{{ $penilaian->catatan ?? 'Tidak ada catatan.' }}"</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <span class="iconify text-3xl text-slate-200 mb-2 mx-auto" data-icon="solar:notes-minimalistic-bold-duotone"></span>
                        <p class="text-[10px] text-slate-400 font-bold italic uppercase tracking-widest">Belum ada penilaian mentor.</p>
                    </div>
                @endif
            </div>
            @endif

            <!-- Summary Akademik -->
            @if($type === 'akademik' || $type === 'admin')
            <div class="bg-slate-50 p-6 sm:p-8 rounded-[2.5rem] border border-slate-100">
                <h4 class="font-black text-slate-800 mb-6 uppercase tracking-[0.2em] text-[10px] flex items-center gap-2">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                    Ringkasan Evaluasi Akademik
                </h4>
                @php $allAkademikPenilaian = $user->peserta->penilaianAkademiks; @endphp
                @if($allAkademikPenilaian->count() > 0)
                    <div class="space-y-4">
                        @foreach($allAkademikPenilaian as $penilaian)
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest">{{ $penilaian->penilai->nama ?? 'Unknown Evaluator' }}</span>
                                    <span class="text-xl font-black text-slate-900">{{ number_format($penilaian->total_akhir, 2) }}</span>
                                </div>
                                <div class="flex gap-2 mb-3">
                                    <span class="px-2 py-0.5 bg-orange-50 text-orange-600 rounded text-[8px] font-black border border-orange-100/50">DOSEN: {{ $penilaian->total_dosen }}</span>
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[8px] font-black border border-blue-100/50">MHS: {{ $penilaian->total_mhs }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500 font-semibold italic border-l-2 border-slate-100 pl-3">"{{ $penilaian->catatan ?? 'Tidak ada catatan.' }}"</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <span class="iconify text-3xl text-slate-200 mb-2 mx-auto" data-icon="solar:library-bold-duotone"></span>
                        <p class="text-[10px] text-slate-400 font-bold italic uppercase tracking-widest">Belum ada penilaian akademik.</p>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
