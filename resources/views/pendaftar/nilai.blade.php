@extends('pendaftar.layout')

@section('content')
<div class="max-w-6xl mx-auto space-y-10 pb-32" x-data="{ activeTab: 1 }">
    
    {{-- 1. PREMIUM HEADER --}}
    <div class="relative overflow-hidden bg-navy-mnc rounded-[3.5rem] p-10 md:p-16 text-white shadow-2xl border border-white/5">
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-primary-orange/5 rounded-full blur-[120px] -mr-40 -mt-40"></div>
        
        <div class="relative z-10">
            <div class="inline-flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-2 rounded-2xl mb-8 backdrop-blur-md">
                <span class="iconify text-primary-orange text-lg" data-icon="solar:ranking-bold-duotone"></span>
                <span class="text-[9px] font-black uppercase tracking-[0.3em] text-primary-orange">Academic Record</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-6 leading-tight">Input Nilai <span class="text-primary-orange italic">Rapor Resmi</span></h1>
            <p class="text-orange-100/60 text-sm md:text-base font-medium max-w-2xl leading-relaxed mb-8">
                Lengkapi transkrip nilai pengetahuan Anda (Skala 0-100) dan unggah bukti fisik rapor asli per semester untuk proses verifikasi.
            </p>
            <div class="flex flex-wrap gap-4">
                <div class="inline-flex items-center gap-3 bg-white/5 text-orange-100/40 px-4 py-2.5 rounded-xl border border-white/10 backdrop-blur-sm">
                    <span class="iconify text-primary-orange" data-icon="solar:info-circle-bold-duotone"></span>
                    <span class="text-[9px] font-black uppercase tracking-widest leading-none">Mapel Pendukung Wajib (min. 2)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- SUCCESS & ERROR ALERTS --}}
    @if(session('success'))
    <div class="bg-navy-mnc border border-primary-orange/30 p-6 rounded-[2rem] shadow-xl animate-fade-in flex items-center gap-4">
        <div class="w-10 h-10 bg-primary-orange text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-primary-orange/20">
            <span class="iconify text-xl" data-icon="solar:check-circle-bold"></span>
        </div>
        <div>
            <h3 class="text-white font-black uppercase tracking-widest text-[10px] mb-1">Berhasil Disimpan</h3>
            <p class="text-orange-100/60 text-[10px] font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any() || session('error'))
    <div class="bg-navy-mnc border border-red-500/30 p-6 rounded-[2rem] shadow-xl animate-fade-in flex items-start gap-4">
        <div class="w-10 h-10 bg-red-500 text-white rounded-xl flex items-center justify-center shrink-0 mt-0.5">
            <span class="iconify text-xl" data-icon="solar:danger-bold"></span>
        </div>
        <div class="flex-1">
            <h3 class="text-white font-black uppercase tracking-widest text-[10px] mb-1">Terjadi Kesalahan</h3>
            <p class="text-orange-100/60 text-[10px] font-medium mb-3">{{ session('error') ?? 'Beberapa informasi memerlukan perhatian Anda.' }}</p>
            @if($errors->any())
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-[9px] font-bold text-red-400 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span> {{ $error }}
                    </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
    @endif

    <form action="{{ route('pendaftar.nilai.store') }}" method="POST" enctype="multipart/form-data" id="mainNilaiForm" class="space-y-8">
        @csrf

        {{-- 2. PRODI SELECTION --}}
        <div class="bg-white rounded-[3rem] p-8 md:p-12 border-2 border-slate-50 shadow-sm relative overflow-hidden group">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-5">
                    <div>
                        <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3">Target Academic Program</h3>
                        <label class="block text-2xl font-black text-navy-mnc tracking-tight leading-tight">Program Studi Pilihan</label>
                    </div>
                    <div class="relative group/select">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/select:text-primary-orange transition-colors z-10 pointer-events-none">
                            <span class="iconify text-2xl" data-icon="solar:square-academic-cap-bold-duotone"></span>
                        </div>
                        <select name="pilihan_prodi" id="prodiSelect" onchange="checkProdi()" 
                            class="w-full bg-slate-50 text-navy-mnc font-black text-base rounded-2xl border-2 border-transparent focus:border-primary-orange/30 focus:bg-white focus:ring-4 focus:ring-primary-orange/5 pl-14 pr-12 py-5 appearance-none transition-all cursor-pointer shadow-sm">
                            <option value="">-- Pilih Program Studi --</option>
                            @php $prodis = ['Sains Komunikasi', 'Desain Komunikasi Visual (DKV)', 'Manajemen', 'Akuntansi', 'Sistem Informasi', 'Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Ilmu Komputer']; @endphp
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi }}" {{ ($peserta->pilihan_prodi == $prodi) ? 'selected' : '' }}>{{ $prodi }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <span class="iconify text-xl" data-icon="solar:alt-arrow-down-bold-duotone"></span>
                        </div>
                    </div>
                </div>

                {{-- DKV Special Alert --}}
                <div id="butaWarnaSection" class="{{ ($peserta->pilihan_prodi == 'Desain Komunikasi Visual (DKV)') ? '' : 'hidden' }}">
                    <div id="butaWarnaBox" class="bg-navy-mnc rounded-[2.5rem] p-8 border border-white/5 relative overflow-hidden transition-all duration-500 shadow-2xl">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-orange/5 rounded-full blur-2xl -mr-16 -mt-16 transition-colors duration-700"></div>
                        
                        <div class="relative z-10 space-y-5">
                            <div class="flex items-center gap-4">
                                <div id="butaWarnaIcon" class="w-12 h-12 bg-white/5 text-primary-orange rounded-xl flex items-center justify-center border border-white/10 shadow-lg">
                                    <span class="iconify text-2xl" data-icon="solar:eye-scan-bold-duotone"></span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-white font-black text-xs uppercase tracking-widest truncate">Persyaratan Khusus</h4>
                                    <p class="text-[9px] text-orange-200/40 font-bold uppercase tracking-widest mt-1">Surat Tidak Buta Warna</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div id="butaWarnaFileName" class="hidden px-4 py-3 bg-white/10 border border-white/10 rounded-xl max-w-full">
                                    <p class="text-[8px] font-black text-primary-orange uppercase tracking-[0.2em] flex items-center gap-2">
                                        <span class="iconify" data-icon="solar:check-circle-bold"></span> 
                                        <span id="butaWarnaFileText" class="truncate">File Terpilih</span>
                                    </p>
                                </div>

                                @if($berkas && $berkas->surat_buta_warna)
                                    <div class="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-xl backdrop-blur-md">
                                        <a href="{{ Storage::url($berkas->surat_buta_warna) }}" target="_blank" class="text-[8px] font-black text-primary-orange uppercase tracking-widest flex items-center gap-2 hover:underline">
                                            <span class="iconify" data-icon="solar:file-check-bold"></span> Buka File
                                        </a>
                                        <button type="button" onclick="confirmDeleteFile('surat_buta_warna')" class="text-[8px] font-black text-red-400 uppercase tracking-widest hover:text-red-300 transition-colors">Hapus</button>
                                    </div>
                                @endif

                                <div class="flex items-center gap-3">
                                    <input type="file" name="surat_buta_warna" id="input-buta-warna" class="hidden" accept=".pdf,.jpg,.jpeg,.png,.webp" onchange="previewButaWarna(this)">
                                    <label for="input-buta-warna" class="flex-1 cursor-pointer px-6 py-5 bg-primary-orange text-white rounded-xl text-[10px] font-black uppercase tracking-[0.25em] text-center hover:bg-white hover:text-navy-mnc transition-all shadow-xl shadow-primary-orange/20 active:scale-95 border border-transparent">
                                        Pilih Dokumen
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. SEMESTER NAVIGATION --}}
        <div class="sticky top-4 z-40 px-2">
            <div class="bg-white/95 backdrop-blur-2xl p-2 rounded-[2.5rem] border-2 border-slate-50 shadow-2xl flex items-center gap-1 overflow-x-auto scrollbar-hide max-w-4xl mx-auto ring-1 ring-black/5">
                 @for ($i = 1; $i <= $maxSemester; $i++)
                <button type="button" @click="activeTab = {{ $i }}" onclick="setActiveSem({{ $i }})"
                    class="flex-1 relative min-w-[85px] px-5 py-4 rounded-[1.8rem] text-[10px] font-black tracking-[0.2em] transition-all duration-500 flex items-center justify-center gap-2"
                    :class="activeTab === {{ $i }} ? 'bg-navy-mnc text-white shadow-xl shadow-navy-mnc/20 translate-y-[-2px]' : 'text-slate-400 hover:text-navy-mnc hover:bg-slate-50'">
                    <span class="opacity-30 text-[8px]" :class="activeTab === {{ $i }} ? 'text-primary-orange opacity-100' : ''">0{{ $i }}</span>
                    <span>SEM {{ $i }}</span>
                    <div x-show="activeTab === {{ $i }}" class="absolute bottom-2 w-1 h-1 bg-primary-orange rounded-full shadow-[0_0_8px_rgba(249,115,22,1)]" x-transition></div>
                </button>
                @endfor
            </div>
        </div>

        <!-- 4. CONTENT SECTIONS -->
        <div class="space-y-10 min-h-[600px]">
            @for ($semKey = 1; $semKey <= $maxSemester; $semKey++)
            <div x-show="activeTab === {{ $semKey }}" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 class="space-y-8">

                <!-- SEMESTER PROOF CARD -->
                <div class="bg-white rounded-[3rem] p-8 md:p-12 border-2 border-slate-50 shadow-sm overflow-hidden relative group">
                    <div class="absolute top-0 right-0 p-8 opacity-[0.03] select-none pointer-events-none group-hover:scale-110 transition-transform duration-700">
                         <h2 class="text-[10rem] font-black text-navy-mnc leading-none tracking-tighter">{{ $semKey }}</h2>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
                        <!-- Upload Zone -->
                        <div class="lg:col-span-12 xl:col-span-5 space-y-6">
                            <h3 class="text-xl font-black text-navy-mnc tracking-tight flex items-center gap-3">
                                <span class="w-10 h-10 bg-navy-mnc text-primary-orange rounded-xl flex items-center justify-center shadow-lg shadow-navy-mnc/10">
                                    <span class="iconify" data-icon="solar:camera-bold"></span>
                                </span>
                                Bukti Fisik Rapor
                            </h3>
                            <label class="flex flex-col items-center justify-center w-full h-64 border-4 border-dotted border-slate-100 rounded-[2.5rem] cursor-pointer bg-slate-50/50 hover:bg-orange-500/5 hover:border-primary-orange transition-all duration-500 group/upload relative overflow-hidden shadow-inner">
                                <div class="flex flex-col items-center justify-center py-8 relative z-10">
                                    <div class="w-16 h-16 bg-white rounded-3xl shadow-xl text-slate-300 mb-5 flex items-center justify-center group-hover/upload:text-primary-orange group-hover/upload:scale-110 group-hover/upload:rotate-6 transition-all border border-slate-50">
                                        <span class="iconify text-3xl" data-icon="solar:cloud-plus-bold-duotone"></span>
                                    </div>
                                    <p class="mb-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 group-hover/upload:text-primary-orange">Scan Rapor Semester {{ $semKey }}</p>
                                    <p class="text-[8px] font-bold text-slate-300 uppercase tracking-widest bg-white px-3 py-1 rounded-full border border-slate-100">PDF / JPG / PNG (Max 10MB)</p>
                                </div>
                                <input type="file" name="rapor{{ $semKey }}[]" multiple accept=".pdf,.jpg,.jpeg,.png,.webp" class="hidden" onchange="previewFiles(this, 'preview-{{ $semKey }}', {{ $semKey }})" />
                            </label>
                        </div>

                        <!-- File Status & Preview -->
                        <div class="lg:col-span-12 xl:col-span-7 space-y-6">
                            <div class="p-6 bg-orange-500/[0.03] rounded-3xl border border-orange-500/10 backdrop-blur-sm">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-8 h-8 bg-primary-orange/10 text-primary-orange rounded-lg flex items-center justify-center shadow-sm">
                                        <span class="iconify text-lg" data-icon="solar:info-square-bold-duotone"></span>
                                    </div>
                                    <h4 class="text-[10px] font-black text-navy-mnc uppercase tracking-widest">Digital Guide</h4>
                                </div>
                                <p class="text-[11px] text-slate-500 font-bold leading-relaxed opacity-80 italic">Pastikan seluruh nilai terlihat jelas & terbaca oleh sistem verifikasi. Anda dapat mengunggah beberapa file secara bersamaan.</p>
                            </div>

                            <div id="preview-{{ $semKey }}" class="flex flex-wrap gap-3 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                                <!-- Existing Files -->
                                @php 
                                    $field = 'rapor'.$semKey;
                                    $uploadedFiles = ($berkas && $berkas->$field) ? json_decode($berkas->$field) : null;
                                @endphp
                                @if($uploadedFiles)
                                    @foreach(is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles] as $idx => $file)
                                    <div class="flex items-center gap-4 px-5 py-4 bg-white border-2 border-slate-50 text-navy-mnc rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-sm hover:shadow-lg hover:border-primary-orange/20 transition-all group/file">
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="flex items-center gap-3 min-w-0">
                                            <div class="w-8 h-8 bg-primary-orange/10 text-primary-orange rounded-lg flex items-center justify-center shrink-0">
                                                <span class="iconify text-base" data-icon="solar:file-check-bold"></span>
                                            </div>
                                            <span class="truncate max-w-[120px]">Berkas {{ $idx + 1 }}</span>
                                        </a>
                                        <button type="button" onclick="confirmDeleteFile('rapor{{ $semKey }}', '{{ $file }}')" class="w-8 h-8 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                            <span class="iconify" data-icon="solar:trash-bin-minimalistic-bold"></span>
                                        </button>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TRANSCRIPT INPUT CARD -->
                <div class="bg-white rounded-[3rem] p-8 md:p-14 border-2 border-slate-50 shadow-sm relative group/transcript hover:border-primary-orange/10 transition-all duration-500">
                    <div class="flex flex-col md:flex-row items-center justify-between mb-12 pb-8 border-b-2 border-slate-50 gap-6">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 bg-navy-mnc text-primary-orange rounded-[1.5rem] flex items-center justify-center shadow-2xl shadow-navy-mnc/20 transform group-hover/transcript:rotate-3 transition-transform">
                                <span class="iconify text-3xl" data-icon="solar:pen-new-square-bold-duotone"></span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-navy-mnc tracking-tight leading-none mb-2">Transkrip Nilai Semester {{ $semKey }}</h3>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] flex items-center gap-2">
                                     <span class="w-1.5 h-1.5 bg-primary-orange rounded-full"></span>
                                     Skala Penilaian 0 - 100
                                </p>
                            </div>
                        </div>
                        <div class="px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                             <p class="text-[9px] font-black text-navy-mnc uppercase tracking-widest opacity-60">Status: <span class="text-primary-orange">Sync Enabled</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        @foreach($matpels as $mp)
                        <div class="flex items-center gap-6 p-4 rounded-3xl hover:bg-slate-50 transition-all group/input border-2 border-transparent hover:border-slate-100 shadow-sm hover:shadow-md">
                            <div class="w-14 h-14 rounded-2xl bg-white border-2 border-slate-50 flex items-center justify-center text-slate-300 font-black transition-all group-hover/input:bg-navy-mnc group-hover/input:text-primary-orange group-hover/input:shadow-lg shrink-0 text-xl">
                                {{ substr($mp->nama, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0 space-y-2">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover/input:text-navy-mnc transition-colors">{{ $mp->nama }}</h4>
                                <div class="relative">
                                    @php $score = isset($existingNilai[$mp->id]) ? ($existingNilai[$mp->id]->where('semester', $semKey)->first()->nilai ?? '') : ''; @endphp
                                    <input type="number" step="0.01" name="nilai[{{ $mp->id }}][{{ $semKey }}]" 
                                        value="{{ $score }}" 
                                        class="w-full text-2xl font-black text-navy-mnc bg-transparent border-b-2 border-slate-100 focus:border-primary-orange focus:ring-0 outline-none transition-all py-2 px-1 placeholder:text-slate-100"
                                        placeholder="0.00">
                                    <div class="absolute right-0 bottom-3 text-[10px] font-black text-slate-200 uppercase tracking-widest pointer-events-none group-focus-within/input:text-primary-orange transition-colors">PTS</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- SUPPORTING SUBJECTS -->
                    <div class="mt-16 pt-10 border-t-2 border-slate-50 space-y-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-navy-mnc text-primary-orange rounded-xl flex items-center justify-center shadow-lg shadow-navy-mnc/10">
                                    <span class="iconify text-xl" data-icon="solar:add-circle-bold-duotone"></span>
                                </div>
                                <h5 class="text-[11px] font-black text-navy-mnc uppercase tracking-[0.2em]">Mapel Pendukung <span class="text-primary-orange italic">(Minimal 2)</span></h5>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @for($slotIdx = 1; $slotIdx <= 2; $slotIdx++)
                            @php
                                $existing = isset($customNilaiBySemester[$semKey]) ? $customNilaiBySemester[$semKey]->values()->get($slotIdx - 1) : null;
                                $subjName = $existing ? $existing->matpel->nama : '';
                                $subjNilai = $existing ? $existing->nilai : '';
                            @endphp
                            <div class="bg-slate-50/50 p-8 rounded-[2.5rem] border-2 border-slate-50 space-y-6 hover:bg-white hover:border-primary-orange/20 transition-all duration-300 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest border border-slate-100 px-3 py-1 rounded-full">Subject Slot 0{{ $slotIdx }}</span>
                                    <span class="iconify text-navy-mnc opacity-20" data-icon="solar:notebook-bold" data-width="24"></span>
                                </div>
                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Mata Pelajaran</label>
                                        <input type="text" name="custom_matpel[{{ $semKey }}][{{ $slotIdx }}][nama]" 
                                            value="{{ old("custom_matpel.$semKey.$slotIdx.nama", $subjName) }}"
                                            placeholder="Contoh: Seni Budaya" 
                                            class="w-full bg-white px-6 py-5 rounded-2xl border-2 border-transparent font-black text-navy-mnc text-[12px] uppercase tracking-widest outline-none focus:border-primary-orange/30 focus:ring-4 focus:ring-primary-orange/5 transition-all shadow-sm">
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest ml-1">Nilai Pengetahuan</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="custom_matpel[{{ $semKey }}][{{ $slotIdx }}][nilai]"
                                                value="{{ old("custom_matpel.$semKey.$slotIdx.nilai", $subjNilai) }}"
                                                class="w-full bg-white px-6 py-5 rounded-2xl border-2 border-transparent font-black text-2xl text-navy-mnc outline-none focus:border-primary-orange/30 focus:ring-4 focus:ring-primary-orange/5 transition-all shadow-sm"
                                                placeholder="0.00">
                                            <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-200 uppercase tracking-widest">Poin</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <!-- 5. FLOATING DOCK ACTION -->
        <div class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 w-full max-w-[92%] sm:w-auto">
            <div class="bg-navy-mnc/95 p-3 rounded-[2.5rem] shadow-2xl flex items-center gap-8 border border-white/10 backdrop-blur-3xl ring-1 ring-white/10">
                <div class="hidden md:flex items-center gap-4 px-6 border-r border-white/10">
                    <div class="w-10 h-10 bg-primary-orange text-white rounded-xl flex items-center justify-center shadow-lg shadow-primary-orange/20">
                        <span class="iconify text-xl" data-icon="solar:diskette-bold"></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-black text-[10px] uppercase tracking-widest leading-none">Auto-Sync</span>
                        <span class="text-primary-orange font-black text-[8px] uppercase tracking-[0.25em] mt-1.5 opacity-80 animate-pulse">Endpoint Secure</span>
                    </div>
                </div>
                <button type="submit" class="w-full sm:w-auto px-12 py-5 bg-primary-orange text-white font-black rounded-2xl hover:bg-white hover:text-navy-mnc transition-all flex items-center justify-center gap-4 transform active:scale-95 shadow-xl shadow-primary-orange/20 group">
                    <span class="text-[11px] uppercase tracking-[0.3em]">Simpan Transkrip</span>
                    <span class="iconify text-2xl group-hover:translate-x-1.5 transition-transform" data-icon="solar:arrow-right-bold"></span>
                </button>
            </div>
        </div>

    </form>

    {{-- Hidden Delete Form --}}
    <form id="deleteFileForm" action="{{ route('pendaftar.berkas.delete_file') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="field" id="deleteField">
        <input type="hidden" name="file_path" id="deleteFilePath">
    </form>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//unpkg.com/alpinejs" defer></script>

<script>
    window.__activeSem = 1;
    function setActiveSem(i) { window.__activeSem = i; }

    function confirmDeleteFile(field, filePath = null) {
        Swal.fire({
            title: 'Hapus Berkas?',
            text: "Data yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#001f3f',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'YA, HAPUS',
            cancelButtonText: 'BATAL',
            customClass: {
                popup: 'rounded-[2.5rem] border-2 border-slate-50',
                confirmButton: 'rounded-xl px-10 py-4 font-black text-[10px] uppercase tracking-widest',
                cancelButton: 'rounded-xl px-10 py-4 font-black text-[10px] uppercase tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteField').value = field;
                document.getElementById('deleteFilePath').value = filePath || '';
                document.getElementById('deleteFileForm').submit();
            }
        });
    }

    function previewButaWarna(input) {
        const nameEl = document.getElementById('butaWarnaFileName');
        const textEl = document.getElementById('butaWarnaFileText');
        if (input.files && input.files.length > 0) {
            textEl.textContent = input.files[0].name;
            nameEl.classList.remove('hidden');
        } else {
            nameEl.classList.add('hidden');
        }
    }

    function checkProdi() {
        const val = document.getElementById('prodiSelect').value;
        const section = document.getElementById('butaWarnaSection');
        if (val.includes('DKV') || val.includes('Desain')) {
            section.classList.remove('hidden');
        } else {
            section.classList.add('hidden');
        }
    }

    function previewFiles(input, previewId, sem = null) {
        const previewEl = document.getElementById(previewId);
        let html = '';
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach(file => {
                html += `<div class="px-4 py-3 bg-navy-mnc text-primary-orange rounded-xl text-[9px] font-black uppercase tracking-widest border border-white/10 animate-pulse shadow-lg">
                    📎 ${file.name}
                </div>`;
            });
        }
        let container = previewEl.querySelector('.new-files-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'new-files-container flex flex-wrap gap-2 w-full mt-6 pt-6 border-t-2 border-dashed border-slate-100';
            previewEl.appendChild(container);
        }
        container.innerHTML = html;
    }

    const mainForm = document.getElementById('mainNilaiForm');
    if (mainForm) {
        mainForm.addEventListener('submit', function(e) {
            const prodi = document.getElementById('prodiSelect').value;
            if (!prodi) {
                e.preventDefault();
                Swal.fire({ icon: 'error', title: 'Pilih Program Studi', text: 'Silakan pilih Program Studi tujuan Anda.', confirmButtonColor: '#f97316', customClass: { popup: 'rounded-[2rem]' } });
                return;
            }

            let filledCount = 0;
            document.querySelectorAll('input[name^="custom_matpel"][name$="[nama]"]').forEach(input => {
                const scoreInput = document.querySelector(`input[name="${input.name.replace('[nama]', '[nilai]')}"]`);
                if (input.value.trim() !== '' && scoreInput && scoreInput.value.trim() !== '') filledCount++;
            });

            if (filledCount < 2) {
                e.preventDefault();
                Swal.fire({ icon: 'warning', title: 'Lengkapi Mapel', text: 'Wajib mengisi minimal 2 Mata Pelajaran Pendukung.', confirmButtonColor: '#f97316', customClass: { popup: 'rounded-[2rem]' } });
                return;
            }

            Swal.fire({ 
                title: 'Menyimpan Transkrip...', 
                html: 'Mohon tunggu, sinkronisasi data sedang berjalan.',
                allowOutsideClick: false, 
                didOpen: () => Swal.showLoading(), 
                customClass: { popup: 'rounded-[2rem]' } 
            });
        });
    }
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.6s ease-out; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
@endsection
