@extends('pendaftar.layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 sm:space-y-10 font-sans" x-data="{ activeTab: 1 }">
    
    <!-- 1. HEADER SECTION -->
    <div class="relative overflow-hidden bg-[#0B1221] rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-10 md:p-14 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-80 h-80 bg-primary-gold/20 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-600/20 rounded-full blur-[80px] translate-y-1/3 -translate-x-1/3"></div>
        
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight mb-2 sm:mb-3">Input Nilai Rapor</h1>
            <p class="text-gray-400 text-sm sm:text-base font-medium max-w-2xl leading-relaxed mb-4">
                Silahkan input nilai pengetahuan (Knowledge) skala 0-100 dan unggah bukti fisik rapor asli anda per semester.
            </p>
            <div class="inline-flex items-center gap-2 bg-orange-500/20 text-orange-300 px-4 py-2 rounded-lg border border-orange-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <span class="text-sm font-bold">Mata Pelajaran Pendukung (2 per Semester)</span>
            </div>
        </div>
    </div>



    <!-- SUCCESS ALERT -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in mb-6">
        <div class="flex items-center gap-3">
            <div class="shrink-0 w-8 h-8 bg-green-100 text-green-500 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-green-800">Berhasil!</h3>
                <p class="text-xs text-green-600 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- ERROR ALERT (NEW) -->
    @if($errors->any() || session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm animate-fade-in-down mb-6">
        <div class="flex items-center gap-3">
            <div class="shrink-0 w-8 h-8 bg-red-100 text-red-500 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-red-800">Ups! Terjadi Kesalahan</h3>
                <p class="text-xs text-red-600 font-medium">
                    {{ session('error') ?? ($errors->any() ? 'Silakan periksa kembali isian Anda. Pastikan semua file tidak melebihi 10MB.' : '') }}
                </p>
                @if($errors->any())
                <ul class="mt-1 list-disc list-inside text-[10px] text-red-500 font-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('pendaftar.nilai.store') }}" method="POST" enctype="multipart/form-data" id="mainNilaiForm">
        @csrf

    <!-- 2. PRODI SELECTION CARD -->
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 md:p-10 border border-gray-100 shadow-xl shadow-gray-200/40">
            <div class="flex flex-col md:flex-row gap-5 md:gap-8 items-start">
                <div class="w-full md:w-1/2 space-y-3">
                    <label class="block text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider">Program Studi Pilihan</label>
                    <div class="relative group">
                        <select name="pilihan_prodi" id="prodiSelect" onchange="checkProdi()" 
                            class="w-full bg-gray-50 text-gray-900 font-bold text-base sm:text-lg rounded-xl border-2 border-transparent focus:border-primary-gold focus:bg-white focus:ring-0 px-4 sm:px-5 py-3 sm:py-4 appearance-none transition-all cursor-pointer hover:bg-gray-100">
                            <option value="">-- Pilih Program Studi --</option>
                            @php $prodis = ['Sains Komunikasi', 'Desain Komunikasi Visual (DKV)', 'Manajemen', 'Akuntansi', 'Sistem Informasi', 'Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Ilmu Komputer']; @endphp
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi }}" {{ ($peserta->pilihan_prodi == $prodi) ? 'selected' : '' }}>{{ $prodi }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <!-- DKV Special Warning -->
                <div id="butaWarnaSection" class="w-full md:w-1/2 {{ ($peserta->pilihan_prodi == 'Desain Komunikasi Visual (DKV)') ? '' : 'hidden' }}">
                     <label class="block text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Persyaratan Khusus DKV</label>
                     <div id="butaWarnaBox" class="relative bg-red-50/50 border-2 border-dashed border-red-200 rounded-xl p-4 flex items-center gap-3 transition-all hover:border-red-300">
                        <div id="butaWarnaIcon" class="shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-red-100 text-red-500 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <div class="flex-grow min-w-0 space-y-1">
                            <p class="text-sm font-bold text-gray-800">Surat Keterangan Tidak Buta Warna</p>
                            <div class="flex flex-wrap items-center gap-2">
                                 <label class="cursor-pointer inline-block">
                                     <span class="text-red-500 hover:text-red-700 text-xs font-bold underline decoration-2 underline-offset-2">Pilih File (PDF/JPG/PNG/WEBP)</span>
                                     <input type="file" name="surat_buta_warna" accept=".pdf,.jpg,.jpeg,.png,.webp,application/pdf,image/jpeg,image/png,image/webp" class="hidden" onchange="previewButaWarna(this)">
                                 </label>
                                 <span id="butaWarnaFileName" class="hidden text-[10px] px-2 py-1 bg-green-600 text-white rounded-md font-black shadow-sm animate-pulse inline-flex items-center gap-1" title="File siap diunggah">
                                     <span id="butaWarnaFileText" class="max-w-[150px] truncate"></span>
                                 </span>
                                 @if($berkas && $berkas->surat_buta_warna)
                                     <div class="flex items-center gap-3 mt-1">
                                         <a href="{{ Storage::url($berkas->surat_buta_warna) }}" target="_blank" 
                                            class="flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-xl text-[10px] font-black border border-green-200 shadow-sm hover:bg-green-100 transition-all">
                                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                             <span class="max-w-[150px] truncate">Buka File: {{ basename($berkas->surat_buta_warna) }}</span>
                                         </a>
                                         <button type="button" onclick="confirmDeleteFile('surat_buta_warna')" 
                                                 class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                 title="Hapus file ini">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                         </button>
                                     </div>
                                 @endif
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>

        <!-- 3. TABS NAVIGATION -->
        <div class="sticky top-4 z-30 bg-gray-50/90 backdrop-blur-lg p-1.5 sm:p-2 rounded-[1.5rem] border border-gray-200 shadow-lg flex items-center gap-1 sm:gap-2 overflow-x-auto scrollbar-hide">
             @for ($i = 1; $i <= 5; $i++)
            <button type="button" @click="activeTab = {{ $i }}" onclick="setActiveSem({{ $i }})"
                class="flex-shrink-0 sm:flex-1 relative px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm font-bold transition-all duration-300"
                :class="activeTab === {{ $i }} ? 'bg-white text-dark-navy shadow-md ring-1 ring-black/5' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-100'">
                <span>SEM {{ $i }}</span>
                <div class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-primary-gold opacity-0 transition-all duration-300"
                    :class="activeTab === {{ $i }} ? 'opacity-100 w-4' : ''"></div>
            </button>
            @endfor
        </div>

        <!-- 4. CONTENT SECTIONS -->
        <div class="min-h-[600px]">
            @for ($semKey = 1; $semKey <= 5; $semKey++)
            <div x-show="activeTab === {{ $semKey }}" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6">

            <!-- UPLOAD CARD -->
                <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 border border-gray-100 shadow-lg shadow-gray-200/30 overflow-hidden relative">
                    <div class="absolute top-0 right-0 p-4 sm:p-6 opacity-5">
                         <h2 class="text-7xl sm:text-9xl font-black text-gray-900 leading-none tracking-tighter">{{ $semKey }}</h2>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5 sm:gap-8 items-stretch sm:items-center relative z-10">
                        <!-- Upload Area -->
                        <div class="w-full sm:w-5/12">
                            <label class="flex flex-col items-center justify-center w-full h-36 sm:h-48 border-2 border-dashed border-gray-200 rounded-2xl sm:rounded-3xl cursor-pointer bg-gray-50/50 hover:bg-blue-50/50 hover:border-blue-300 transition-all duration-300">
                                <div class="flex flex-col items-center justify-center py-4">
                                    <div class="w-12 h-12 bg-white rounded-full shadow-md text-blue-500 mb-2 flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    </div>
                                    <p class="mb-1 text-xs sm:text-sm text-gray-500 font-bold"><span class="text-blue-600">Klik untuk upload</span> rapor</p>
                                    <p class="text-xs text-gray-400 font-medium text-center px-2">PDF/JPG/WEBP (Max 10MB)<br><span class="text-[9px] text-orange-400 font-bold italic block mt-1">Jika error, pastikan pilih file dari "Penyimpanan Internal" (bukan Google Drive/Photos)</span></p>
                                </div>
                                <input type="file" name="rapor{{ $semKey }}[]" multiple accept=".pdf,.jpg,.jpeg,.png,.webp" class="hidden" onchange="previewFiles(this, 'preview-{{ $semKey }}', {{ $semKey }})" />
                            </label>
                        </div>

                        <!-- Preview & Instructions -->
                        <div class="w-full sm:w-7/12 space-y-3">
                            <div>
                                <h3 class="text-base sm:text-xl font-black text-dark-navy mb-1">Bukti Fisik Semester {{ $semKey }}</h3>
                                <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Wajib mengunggah scan halaman nilai rapor asli. Jika ada lebih dari satu halaman, anda bisa memilih banyak file sekaligus.</p>
                            </div>

                            <div id="preview-{{ $semKey }}" class="flex flex-wrap gap-2">
                                <!-- Existing Files -->
                                @php 
                                    $field = 'rapor'.$semKey;
                                    $uploadedFiles = ($berkas && $berkas->$field) ? json_decode($berkas->$field) : null;
                                @endphp
                                @if($uploadedFiles)
                                    @foreach(is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles] as $idx => $file)
                                    <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 text-blue-700 rounded-xl text-xs font-bold border border-blue-100 overflow-hidden shadow-sm">
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="flex items-center gap-2 max-w-[120px] truncate">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>File {{ $idx + 1 }}</span>
                                        </a>
                                        <button type="button" onclick="confirmDeleteFile('rapor{{ $semKey }}', '{{ $file }}')" class="text-red-400 hover:text-red-600 transition-colors p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRADES INPUT CARD -->
                <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-8 md:p-10 border border-gray-100 shadow-lg shadow-gray-200/30">
                    <div class="flex items-center justify-between mb-5 sm:mb-8">
                         <h3 class="text-base sm:text-xl font-black text-dark-navy flex items-center gap-3">
                            <span class="w-3 h-6 sm:h-8 bg-primary-gold rounded-full"></span>
                            Transkrip Nilai
                        </h3>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-3 py-1 rounded-lg">
                            Skala 0 - 100
                        </div>
                    </div>

                    <div class="space-y-3 pb-20">
                        <!-- CORE SUBJECTS -->
                        @foreach($matpels as $mp)
                        <div class="flex items-center gap-3 sm:gap-6 p-3 sm:p-4 rounded-2xl border border-gray-100 hover:shadow-md hover:border-blue-100 transition-all duration-300 bg-white">
                             <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center text-gray-500 font-bold border border-gray-200 flex-shrink-0">
                                {{ substr($mp->nama, 0, 1) }}
                            </div>
                            <div class="flex-grow min-w-0">
                                <h4 class="font-bold text-gray-800 text-sm sm:text-lg truncate">{{ $mp->nama }}</h4>
                                <p class="text-xs text-gray-400 font-medium">Wajib</p>
                            </div>
                            <div class="w-20 sm:w-32 flex-shrink-0">
                                @php $score = isset($existingNilai[$mp->id]) ? ($existingNilai[$mp->id]->where('semester', $semKey)->first()->nilai ?? '') : ''; @endphp
                                <input type="number" step="0.01" name="nilai[{{ $mp->id }}][{{ $semKey }}]" 
                                    value="{{ $score }}" 
                                    class="w-full text-center py-2.5 sm:py-3 rounded-xl font-black text-base sm:text-xl text-dark-navy bg-gray-50 border-2 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder-gray-300 shadow-inner"
                                    placeholder="0">
                            </div>
                        </div>
                        @endforeach

                        <!-- SUPPORTING SUBJECTS (2 slots per semester) -->
                        <div id="customContainerSemester{{ $semKey }}" class="space-y-4 pt-4 border-t border-gray-100 mt-6">
                            <h5 class="text-xs font-black text-orange-500 uppercase tracking-widest mb-4">Mata Pelajaran Pendukung (Semester {{ $semKey }})</h5>
                            
                            @for($slotIdx = 1; $slotIdx <= 2; $slotIdx++)
                            @php
                                $existing = isset($customNilaiBySemester[$semKey]) ? $customNilaiBySemester[$semKey]->values()->get($slotIdx - 1) : null;
                                $subjName = $existing ? $existing->matpel->nama : '';
                                $subjNilai = $existing ? $existing->nilai : '';
                            @endphp
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 p-4 rounded-2xl border-2 border-dashed border-orange-100 bg-orange-50/20 hover:border-orange-300 transition-all duration-300">
                                <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-500 font-bold flex-shrink-0">
                                    {{ $slotIdx }}
                                </div>
                                <div class="flex-grow w-full">
                                    <input type="text" name="custom_matpel[{{ $semKey }}][{{ $slotIdx }}][nama]" 
                                        value="{{ old("custom_matpel.$semKey.$slotIdx.nama", $subjName) }}"
                                        placeholder="Nama Mapel Pendukung {{ $slotIdx }} (contoh: Ekonomi)" 
                                        class="w-full bg-white px-4 py-2.5 rounded-xl border border-gray-200 font-bold text-gray-800 text-sm outline-none focus:border-orange-400 focus:ring-4 focus:ring-orange-400/10 transition-all">
                                </div>
                                <div class="w-full sm:w-32 flex-shrink-0">
                                    <input type="number" step="0.01" name="custom_matpel[{{ $semKey }}][{{ $slotIdx }}][nilai]"
                                        value="{{ old("custom_matpel.$semKey.$slotIdx.nilai", $subjNilai) }}"
                                        class="w-full text-center py-2.5 rounded-xl font-black text-lg text-dark-navy bg-white border border-gray-200 focus:border-orange-400 focus:ring-4 focus:ring-orange-400/10 transition-all outline-none"
                                        placeholder="0">
                                </div>
                            </div>
                            @endfor
                            <p class="text-[10px] text-gray-400 italic mt-2">*Kosongkan jika tidak ada mata pelajaran pendukung di semester ini.</p>
                        </div>
                    </div>
                </div>

            </div>
            @endfor
        </div>

        <!-- 5. FLOATING ACTIONS -->
        <div x-data class="fixed bottom-4 sm:bottom-6 inset-x-0 px-4 sm:px-0 mx-auto sm:w-max z-40 flex items-center gap-2 sm:gap-3 p-1.5 sm:p-2 bg-white/90 backdrop-blur-md rounded-2xl sm:rounded-full border border-gray-200 shadow-2xl shadow-dark-navy/20">
            <div class="px-6 py-3 text-dark-navy font-bold flex flex-col items-start leading-tight">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm">Input Nilai Akademik</span>
                </div>
                <span class="text-[10px] text-orange-600 font-black uppercase mt-1">WAJIB ISI MIN. 2 MAPEL PENDUKUNG</span>
            </div>
            <div class="w-px h-7 bg-gray-300"></div>
            <button type="submit" class="flex-1 sm:flex-none pl-3 sm:pl-5 pr-4 sm:pr-6 py-2.5 sm:py-3 bg-dark-navy hover:bg-black text-white font-bold rounded-xl sm:rounded-full transition-all flex items-center justify-center gap-2 sm:gap-3 shadow-lg">
                <span class="text-sm">Simpan Semua</span>
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
        </div>

    </form>

    {{-- Hidden Delete Form (Moved Outside to Fix Nested Forms) --}}
    <form id="deleteFileForm" action="{{ route('pendaftar.berkas.delete_file') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="field" id="deleteField">
        <input type="hidden" name="file_path" id="deleteFilePath">
    </form>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>

<script>
    // Track current active semester
    window.__activeSem = 1;
    function setActiveSem(i) {
        window.__activeSem = i;
    }

    function confirmDeleteFile(field, filePath = null) {
        Swal.fire({
            title: 'Hapus berkas ini?',
            text: "Berkas yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteField').value = field;
                document.getElementById('deleteFilePath').value = filePath || '';
                document.getElementById('deleteFileForm').submit();
            }
        })
    }

    function previewButaWarna(input) {
        const nameEl = document.getElementById('butaWarnaFileName');
        const textEl = document.getElementById('butaWarnaFileText');
        const boxEl = document.getElementById('butaWarnaBox');
        const iconEl = document.getElementById('butaWarnaIcon');
        
        if (input.files && input.files.length > 0) {
            const file = input.files[0];
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 10 * 1024 * 1024; // 10MB

            if (!allowedTypes.includes(file.type)) {
                Swal.fire({ icon: 'error', title: 'Format File Tidak Sesuai', text: 'Gunakan format PDF, JPG, PNG, atau WEBP.' });
                input.value = '';
                return;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Ukuran maksimal file adalah 10MB.' });
                input.value = '';
                return;
            }

            const isPdf = file.type === 'application/pdf';
            const iconHtml = isPdf 
                ? '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>'
                : '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';

            textEl.innerHTML = `<span class="bg-green-600 text-white text-[9px] px-1.5 py-0.5 rounded-[4px] mr-1 animate-pulse uppercase font-black tracking-tight">BARU</span> ${file.name}`;
            nameEl.classList.remove('hidden');
            
            // Highlight box
            boxEl.classList.remove('border-red-200', 'bg-red-50/50');
            boxEl.classList.add('border-green-400', 'bg-green-50/50', 'ring-8', 'ring-green-500/5');
            iconEl.classList.remove('bg-red-100', 'text-red-500');
            iconEl.classList.add('bg-green-100', 'text-green-500', 'animate-bounce');
            iconEl.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
        } else {
            nameEl.classList.add('hidden');
            boxEl.classList.add('border-red-200', 'bg-red-50/50');
            boxEl.classList.remove('border-green-400', 'bg-green-50/50', 'ring-8', 'ring-green-500/5');
            iconEl.classList.add('bg-red-100', 'text-red-500');
            iconEl.classList.remove('bg-green-100', 'text-green-500', 'animate-bounce');
            iconEl.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
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
        const label = input.closest('label');
        const labelText = label ? label.querySelector('p span') || label.querySelector('p') : null;
        let html = '';
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/webp'];
        const maxSize = 10 * 1024 * 1024; // 10MB

        if (input.files && input.files.length > 0) {
            const files = Array.from(input.files);
            for (let file of files) {
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({ icon: 'error', title: 'Format File Tidak Sesuai', text: `File "${file.name}" bukan PDF/Gambar. Gunakan PDF, JPG, PNG, atau WEBP.` });
                    input.value = '';
                    if (labelText) labelText.innerHTML = '<span class="text-blue-600">Klik untuk upload</span> rapor';
                    if (label) { label.classList.remove('border-green-400', 'bg-green-50/50'); label.classList.add('border-gray-200', 'bg-gray-50/50'); }
                    return;
                }
                if (file.size > maxSize) {
                    Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: `File "${file.name}" melebihi 10MB.` });
                    input.value = '';
                    if (labelText) labelText.innerHTML = '<span class="text-blue-600">Klik untuk upload</span> rapor';
                    if (label) { label.classList.remove('border-green-400', 'bg-green-50/50'); label.classList.add('border-gray-200', 'bg-gray-50/50'); }
                    return;
                }

                const isPdf = file.type === 'application/pdf';
                const iconPath = isPdf 
                    ? 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'
                    : 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z';

                html += `<div class="flex items-center gap-2 px-3 py-2 bg-green-50 text-green-700 rounded-xl text-[10px] font-bold border border-green-200 animate-pulse shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"/></svg>
                    <span class="truncate max-w-[220px]">
                        <span class="bg-green-600 text-white px-1.5 py-0.5 rounded-[4px] mr-1 text-[8px] uppercase tracking-tighter">BARU</span>
                        ${file.name}
                    </span>
                </div>`;
            }
            
            // Success Feedback
            const iconWrap = label ? label.querySelector('.bg-white.rounded-full') : null;
            if (iconWrap) {
                iconWrap.classList.remove('text-blue-500');
                iconWrap.classList.add('text-green-500', 'animate-bounce');
                iconWrap.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
            }
            if (labelText) labelText.innerHTML = `<span class="text-green-600 font-black">✅ ${input.files.length} File Terpilih</span>`;
            if (label) {
                label.classList.remove('border-gray-200', 'bg-gray-50/50');
                label.classList.add('border-green-400', 'bg-green-50/50', 'ring-8', 'ring-green-500/5');
            }
        } else {
            if (labelText) labelText.innerHTML = '<span class="text-blue-600">Klik untuk upload</span> rapor';
            if (label) {
                label.classList.remove('border-green-400', 'bg-green-50/50', 'ring-8', 'ring-green-500/5');
                label.classList.add('border-gray-200', 'bg-gray-50/50');
            }
        }
        
        let c = previewEl.querySelector('.new-files-preview');
        if (!c) {
            c = document.createElement('div');
            c.className = 'new-files-preview flex flex-wrap gap-2 w-full mt-2';
            previewEl.appendChild(c);
        }
        c.innerHTML = html;
    }


    // Form submit validation
    const mainForm = document.getElementById('mainNilaiForm');
    if (mainForm) {
        mainForm.addEventListener('submit', function(e) {
        const prodi = document.getElementById('prodiSelect').value;
        if (!prodi) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Program Studi Belum Dipilih',
                text: 'Silakan pilih Program Studi terlebih dahulu sebelum menyimpan.',
                confirmButtonColor: '#0B1221',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Check if at least 2 mata pelajaran pendukung are added across all semesters
        let totalCustomFilled = 0;
        document.querySelectorAll('input[name^="custom_matpel"][name$="[nama]"]').forEach(input => {
            const name = input.value.trim();
            const nilaiInput = document.querySelector(`input[name="${input.name.replace('[nama]', '[nilai]')}"]`);
            const nilai = nilaiInput ? nilaiInput.value.trim() : '';
            if (name !== '' && nilai !== '') {
                totalCustomFilled++;
            }
        });
        
        if (totalCustomFilled < 2) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Mata Pelajaran Pendukung Wajib!',
                html: 'Anda harus mengisi minimal <strong>2 Mata Pelajaran Pendukung</strong> (Nama & Nilai) di antara semua semester.',
                confirmButtonColor: '#0B1221',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Show loading state
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading()
        });
        });
    }
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-down { animation: fadeInDown 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes bounceShort { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-3px); } }
    .animate-bounce-short { animation: bounceShort 0.5s ease-in-out infinite; }
</style>
@endsection

