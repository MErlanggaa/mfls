@extends('pendaftar.layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 sm:space-y-10 font-sans" x-data="{ activeTab: 1 }">
    
    <!-- 1. HEADER SECTION -->
    <div class="relative overflow-hidden bg-[#0B1221] rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-10 md:p-14 text-white shadow-2xl">
        <div class="absolute top-0 right-0 w-80 h-80 bg-primary-gold/20 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-600/20 rounded-full blur-[80px] translate-y-1/3 -translate-x-1/3"></div>
        
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight mb-2 sm:mb-3">Input Nilai Rapor</h1>
            <p class="text-gray-400 text-sm sm:text-base font-medium max-w-2xl leading-relaxed">
                Silahkan input nilai pengetahuan (Knowledge) skala 0-100 dan unggah bukti fisik rapor asli anda per semester.
            </p>
        </div>
    </div>



    <form action="{{ route('pendaftar.nilai.store') }}" method="POST" enctype="multipart/form-data">
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
                            @php $prodis = ['Sains Komunikasi', 'Desain Komunikasi Visual (DKV)', 'Manajemen', 'Akuntansi', 'Sistem Informasi', 'Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Sistem Informasi', 'Ilmu Komputer']; @endphp
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
                     <div class="relative bg-red-50/50 border-2 border-dashed border-red-200 rounded-xl p-4 flex items-center gap-3 transition-all hover:border-red-300">
                        <div class="shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-red-100 text-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <div class="flex-grow min-w-0">
                            <p class="text-sm font-bold text-gray-800">Surat Keterangan Tidak Buta Warna</p>
                            <label class="cursor-pointer">
                                <span class="text-red-500 hover:text-red-700 text-xs font-bold underline decoration-2 underline-offset-2">Pilih File (PDF/JPG)</span>
                                <input type="file" name="surat_buta_warna" class="hidden">
                            </label>
                             @if($berkas && $berkas->surat_buta_warna)
                                <a href="{{ asset('storage/' . $berkas->surat_buta_warna) }}" target="_blank" class="ml-2 text-[10px] px-2 py-1 bg-green-100 text-green-700 rounded-md font-bold hover:bg-green-200 transition-colors">Lihat File</a>
                            @endif
                        </div>
                     </div>
                </div>
            </div>
        </div>

        <!-- 3. TABS NAVIGATION -->
        <div class="sticky top-4 z-30 bg-gray-50/90 backdrop-blur-lg p-1.5 sm:p-2 rounded-[1.5rem] border border-gray-200 shadow-lg flex items-center gap-1 sm:gap-2 overflow-x-auto scrollbar-hide">
             @for ($i = 1; $i <= 5; $i++)
            <button type="button" @click="activeTab = {{ $i }}" 
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
                                    <p class="text-xs text-gray-400 font-medium">PDF/JPG (Max 5MB)</p>
                                </div>
                                <input type="file" name="rapor{{ $semKey }}[]" multiple class="hidden" onchange="previewFiles(this, 'preview-{{ $semKey }}')" />
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
                                    @foreach(is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles] as $file)
                                    <a href="{{ asset('storage/' . $file) }}" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-blue-50 text-blue-700 rounded-xl text-xs font-bold border border-blue-100 hover:bg-blue-100 transition-colors">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>File Tersimpan</span>
                                    </a>
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

                    <div class="space-y-3">
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

                        <!-- CUSTOM SUBJECTS (Dynamic) -->
                        <div id="customContainerSemester{{ $semKey }}" class="space-y-3">
                             @foreach($customMatpels as $index => $cmp)
                             <div class="custom-subject-old-{{ $cmp->id }} flex items-center gap-3 sm:gap-6 p-3 sm:p-4 rounded-2xl border-2 border-dashed border-gray-200 hover:border-orange-300 hover:bg-orange-50/10 transition-all duration-300">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 font-bold border border-orange-100 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                </div>
                                <div class="flex-grow min-w-0">
                                    @if($semKey == 1)
                                        <input type="text" name="custom_matpel[old_{{ $index }}][nama]" value="{{ $cmp->nama }}" class="w-full bg-transparent font-bold text-gray-800 text-sm sm:text-lg outline-none" readonly>
                                    @else
                                        <div class="font-bold text-gray-800 text-sm sm:text-lg truncate">{{ $cmp->nama }}</div>
                                    @endif
                                    <p class="text-xs text-orange-400 font-bold uppercase tracking-wide">Tambahan</p>
                                </div>
                                <div class="w-20 sm:w-32 flex-shrink-0">
                                     @php $score = isset($existingNilai[$cmp->id]) ? ($existingNilai[$cmp->id]->where('semester', $semKey)->first()->nilai ?? '') : ''; @endphp
                                     <input type="number" step="0.01" name="custom_matpel[old_{{ $index }}][nilai][{{ $semKey }}]" 
                                        value="{{ $score }}"
                                        class="w-full text-center py-2.5 sm:py-3 rounded-xl font-black text-base sm:text-xl text-dark-navy bg-white border-2 border-gray-100 focus:border-orange-400 focus:ring-4 focus:ring-orange-400/10 transition-all outline-none placeholder-gray-300">
                                </div>
                                <button type="button" onclick="removeOldSubject({{ $cmp->id }})" class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all flex-shrink-0" title="Hapus Mapel">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                             </div>
                             @endforeach
                        </div>
                    </div>
                </div>

            </div>
            @endfor
        </div>

        <!-- 5. FLOATING ACTIONS -->
        <div class="fixed bottom-4 sm:bottom-6 inset-x-0 px-4 sm:px-0 mx-auto sm:w-max z-40 flex items-center gap-2 sm:gap-3 p-1.5 sm:p-2 bg-white/90 backdrop-blur-md rounded-2xl sm:rounded-full border border-gray-200 shadow-2xl shadow-dark-navy/20">
             <button type="button" @click="addCustomSubject()" class="flex-1 sm:flex-none pl-3 sm:pl-4 pr-3 sm:pr-5 py-2.5 sm:py-3 bg-gray-100 hover:bg-gray-200 text-dark-navy font-bold rounded-xl sm:rounded-full transition-all flex items-center justify-center gap-2">
                <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-white flex items-center justify-center shadow-sm">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <span class="text-sm">Mapel Tambahan</span>
            </button>
            <div class="w-px h-7 bg-gray-300"></div>
            <button type="submit" class="flex-1 sm:flex-none pl-3 sm:pl-5 pr-4 sm:pr-6 py-2.5 sm:py-3 bg-dark-navy hover:bg-black text-white font-bold rounded-xl sm:rounded-full transition-all flex items-center justify-center gap-2 sm:gap-3 shadow-lg">
                <span class="text-sm">Simpan Semua</span>
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
        </div>
        
        <!-- Hidden Params -->
        <div id="deletedParamsContainer"></div>
    </form>
</div>

<!-- Scripts -->
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function checkProdi() {
        const val = document.getElementById('prodiSelect').value;
        const section = document.getElementById('butaWarnaSection');
        if (val.includes('DKV') || val.includes('Desain')) {
            section.classList.remove('hidden');
            section.classList.add('animate-fade-in');
        } else {
            section.classList.add('hidden');
        }
    }

    function previewFiles(input, previewId) {
        const previewEl = document.getElementById(previewId);
        // Don't clear existing old files display (managed by blade), but maybe clear previous *new* previews?
        // Let's just append for now or simple replace behavior for new ones.
        // Actually, simple visual feedback:
        
        let newFilesContent = '';
        if (input.files) {
            Array.from(input.files).forEach(file => {
                newFilesContent += `
                    <div class="flex items-center gap-2 px-3 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-bold border border-indigo-100 animate-fade-in">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="truncate max-w-[150px]">${file.name}</span>
                    </div>
                `;
            });
        }
        
        // Append to container (keeping PHP generated ones)
        // Ideally we should separate "Old" and "New" containers to avoid duplication if user re-selects
        // Flexible approach: Find a specific 'new-files' container inside the preview div.
        let newContainer = previewEl.querySelector('.new-files-preview');
        if(!newContainer) {
            newContainer = document.createElement('div');
            newContainer.className = 'new-files-preview flex flex-wrap gap-2';
            previewEl.appendChild(newContainer);
        }
        newContainer.innerHTML = newFilesContent;
    }

    function addCustomSubject() {
        customSubjectCount++;
        for (let i = 1; i <= 5; i++) {
            const container = document.getElementById(`customContainerSemester${i}`);
            const div = document.createElement('div');
            div.className = `custom-subject-new-${customSubjectCount} flex items-center gap-3 sm:gap-6 p-3 sm:p-4 rounded-2xl border-2 border-dashed border-gray-200 hover:border-orange-300 hover:bg-orange-50/10 transition-all duration-300 animate-fade-in-down`;
            
            let nameInput = (i === 1) 
                ? `<input type="text" name="custom_matpel[new_${customSubjectCount}][nama]" placeholder="Nama Mapel (ex: Ekonomi)" class="w-full bg-white px-3 py-2 rounded-xl border border-gray-300 font-bold text-gray-800 text-sm outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all" oninput="syncName(${customSubjectCount}, this.value)" required autoFocus>`
                : `<input type="text" id="custom_name_${customSubjectCount}_sem_${i}" class="w-full bg-transparent font-bold text-gray-800 text-sm outline-none placeholder-gray-300" placeholder="(Nama Mapel)" readonly>`;

            div.innerHTML = `
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 font-bold border border-orange-100 flex-shrink-0">✨</div>
                <div class="flex-grow min-w-0">
                    ${nameInput}
                    <p class="text-xs text-orange-400 font-bold uppercase tracking-wide mt-1">Tambahan Baru</p>
                </div>
                <div class="w-20 sm:w-32 flex-shrink-0">
                    <input type="number" step="0.01" name="custom_matpel[new_${customSubjectCount}][nilai][${i}]" 
                        class="w-full text-center py-2.5 sm:py-3 rounded-xl font-black text-base sm:text-xl text-dark-navy bg-white border-2 border-gray-100 focus:border-orange-400 focus:ring-4 focus:ring-orange-400/10 transition-all outline-none placeholder-gray-300">
                </div>
                <button type="button" onclick="removeNewSubject(${customSubjectCount})" class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all flex-shrink-0" title="Batal">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
            container.appendChild(div);
        }
    }


    function removeNewSubject(id) {
        document.querySelectorAll(`.custom-subject-new-${id}`).forEach(el => el.remove());
    }

    function removeOldSubject(id) {
        if(!confirm('Hapus mata pelajaran ini beserta nilainya?')) return;
        document.querySelectorAll(`.custom-subject-old-${id}`).forEach(el => el.remove());
        const container = document.getElementById('deletedParamsContainer');
        const input = document.createElement('input');
        input.type = 'hidden'; type="name"; input.name = 'deleted_custom_matpels[]'; input.value = id;
        container.appendChild(input);
    }

    function syncName(id, val) {
        for (let i = 2; i <= 5; i++) {
            const el = document.getElementById(`custom_name_${id}_sem_${i}`);
            if(el) el.value = val;
        }
    }
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-down { animation: fadeInDown 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
</style>
@endsection
