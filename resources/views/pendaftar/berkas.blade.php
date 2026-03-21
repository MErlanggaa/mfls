@extends('pendaftar.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 sm:p-10 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
            <div>
                <h1 class="text-xl sm:text-3xl font-black text-gray-900 mb-1 sm:mb-2">Upload Berkas</h1>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Unggah dokumen pendaftaran satu per satu</p>
            </div>
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-primary-gold/10 rounded-xl sm:rounded-2xl flex items-center justify-center text-primary-gold flex-shrink-0">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>

        <div class="p-4 sm:p-10 space-y-6 sm:space-y-10">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm text-green-700 font-semibold">{{ session('success') }}</p>
                </div>
            @endif
            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-2xl">
                    <p class="text-sm text-red-700 font-semibold mb-1">Terjadi kesalahan:</p>
                    <ul class="list-disc pl-5 text-xs text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Info Akademik --}}
            <div class="p-6 bg-blue-50/50 rounded-2xl border border-blue-100 flex items-start gap-4">
                <div class="mt-1 min-w-[32px] w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 mb-1">Info Status Akademik</h4>
                    <p class="text-sm text-blue-800">
                        Tahun Kelulusan Anda terbaca: <strong>{{ $peserta->daftar->tahun_lulus ?? 'Belum Diisi' }}</strong>
                    </p>
                    @php $tahunLulus = (int) ($peserta->daftar->tahun_lulus ?? 2026); @endphp
                    @if($tahunLulus < 2026)
                        <div class="mt-2">
                            <span class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full border border-purple-200">✅ Kategori: ALUMNI</span>
                            <p class="text-xs text-purple-600 mt-2 font-medium">Wajib mengunggah Rapor Semester 1 sampai 6.</p>
                        </div>
                    @else
                        <div class="mt-2">
                            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">🎓 Kategori: SISWA KELAS 12 / GAP YEAR 2026</span>
                            <p class="text-xs text-blue-600 mt-2 font-medium">Wajib mengunggah Rapor Semester 1 sampai 5.</p>
                        </div>
                    @endif
                    <p class="text-[10px] text-gray-400 mt-3 italic border-t border-blue-100 pt-2">
                        *Jika tahun lulus salah, silakan perbaiki di menu <strong>Biodata Diri</strong>.
                    </p>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- DOKUMEN UTAMA — setiap berkas punya form sendiri               --}}
            {{-- ============================================================ --}}
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-primary-gold/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    Dokumen Utama
                </h3>

                @php
                    $inputFiles = [
                        ['name' => 'foto',    'label' => 'Pas Foto 4x6',      'desc' => 'Latar belakang merah, JPG/PNG',         'multiple' => false, 'optional' => false],
                        ['name' => 'rapor1',  'label' => 'Rapor Semester 1',   'desc' => 'Scan PDF/JPG (Bisa > 1 file)',          'multiple' => true,  'optional' => false],
                        ['name' => 'rapor2',  'label' => 'Rapor Semester 2',   'desc' => 'Scan PDF/JPG (Bisa > 1 file)',          'multiple' => true,  'optional' => false],
                        ['name' => 'rapor3',  'label' => 'Rapor Semester 3',   'desc' => 'Scan PDF/JPG (Bisa > 1 file)',          'multiple' => true,  'optional' => false],
                        ['name' => 'rapor4',  'label' => 'Rapor Semester 4',   'desc' => 'Scan PDF/JPG (Bisa > 1 file)',          'multiple' => true,  'optional' => false],
                        ['name' => 'rapor5',  'label' => 'Rapor Semester 5',   'desc' => 'Scan PDF/JPG (Bisa > 1 file)',          'multiple' => true,  'optional' => false],
                    ];

                    if ($tahunLulus < 2026) {
                        $inputFiles[] = ['name' => 'rapor6', 'label' => 'Rapor Semester 6', 'desc' => 'Wajib bagi lulusan sebelum 2026', 'multiple' => true, 'optional' => false];
                    }

                    $inputFiles[] = ['name' => 'ijazah', 'label' => 'Ijazah / SKL', 'desc' => 'Jika sudah ada (Opsional)', 'multiple' => false, 'optional' => true];
                @endphp

                @foreach($inputFiles as $file)
                @php
                    $fieldName  = $file['name'];
                    $isMultiple = $file['multiple'];
                    $isUploaded = $berkas && $berkas->{$fieldName};
                    if ($isUploaded) {
                        $decoded  = json_decode($berkas->{$fieldName}, true);
                        $fileCount = is_array($decoded) ? count($decoded) : 1;
                    }
                @endphp
                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data"
                      class="mb-3" onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="{{ $fieldName }}">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 sm:p-6 bg-gray-50 rounded-2xl sm:rounded-[2rem] border border-gray-100 hover:border-primary-gold/50 transition-all {{ $file['optional'] ? 'bg-blue-50/30' : '' }}">
                        {{-- Info berkas --}}
                        <div class="flex items-center gap-3 sm:gap-6 min-w-0">
                            <div class="w-11 h-11 sm:w-14 sm:h-14 bg-white rounded-xl sm:rounded-2xl flex items-center justify-center text-{{ $isUploaded ? 'green-500' : 'gray-400' }} transition-colors shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-bold text-sm sm:text-base text-gray-900">{{ $file['label'] }}</h4>
                                    @if($file['optional'])
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Opsional</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded-full">Wajib</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 font-medium">{{ $file['desc'] }}</p>
                                @if($isUploaded)
                                    <p class="text-xs text-green-600 font-bold mt-0.5">✓ {{ $fileCount }} File terunggah</p>
                                @else
                                    <p class="text-xs {{ $file['optional'] ? 'text-blue-500' : 'text-red-400' }} font-medium mt-0.5">
                                        {{ $file['optional'] ? 'Belum diunggah (Tidak wajib)' : 'Belum diunggah' }}
                                    </p>
                                @endif
                                <p class="text-xs text-primary-gold font-medium mt-0.5 hidden" id="preview-{{ $fieldName }}"></p>
                            </div>
                        </div>

                        {{-- Tombol pilih & simpan --}}
                        <div class="flex items-center gap-2 sm:flex-shrink-0">
                            <input type="file"
                                   name="{{ $fieldName }}{{ $isMultiple ? '[]' : '' }}"
                                   class="hidden"
                                   id="file-{{ $fieldName }}"
                                   {{ $isMultiple ? 'multiple' : '' }}
                                   onchange="onFileSelected(this, '{{ $fieldName }}')">
                            <label for="file-{{ $fieldName }}"
                                   class="flex-1 sm:flex-none cursor-pointer bg-dark-navy text-white text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-gray-700 transition-all text-center">
                                {{ $isUploaded ? 'Pilih Ulang' : 'Pilih File' }}
                            </label>
                            <button type="submit"
                                    id="btn-save-{{ $fieldName }}"
                                    class="hidden flex-1 sm:flex-none bg-primary-gold text-dark-navy text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-primary-gold/80 transition-all text-center">
                                💾 Simpan
                            </button>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>

            {{-- ============================================================ --}}
            {{-- BUKTI FOLLOW MEDIA SOSIAL                                      --}}
            {{-- ============================================================ --}}
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-pink-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </div>
                    Bukti Follow Media Sosial
                </h3>

                @php
                    $sosmedFollows = [
                        ['name' => 'bukti_follow_ig_beasiswamncu',    'label' => 'Follow IG @beasiswamncu',      'desc' => 'Screenshot bukti follow Instagram @beasiswamncu'],
                        ['name' => 'bukti_follow_ig_mncu',           'label' => 'Follow IG @mncuniversity',     'desc' => 'Screenshot bukti follow Instagram @mncuniversity'],
                        ['name' => 'bukti_follow_tiktok_beasiswamncu','label' => 'Follow TikTok @beasiswamncu',  'desc' => 'Screenshot bukti follow TikTok @beasiswamncu'],
                        ['name' => 'bukti_follow_tiktok_mncu',        'label' => 'Follow TikTok @mncuniversity', 'desc' => 'Screenshot bukti follow TikTok @mncuniversity'],
                    ];
                @endphp

                @foreach($sosmedFollows as $sosmed)
                @php
                    $fieldName  = $sosmed['name'];
                    $isUploaded = $berkas && $berkas->{$fieldName};
                @endphp
                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data"
                      class="mb-3" onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="{{ $fieldName }}">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 sm:p-6 bg-gray-50 rounded-2xl sm:rounded-[2rem] border border-gray-100 hover:border-primary-gold/50 transition-all">
                        <div class="flex items-center gap-3 sm:gap-6 min-w-0">
                            <div class="w-11 h-11 sm:w-14 sm:h-14 bg-white rounded-xl sm:rounded-2xl flex items-center justify-center text-{{ $isUploaded ? 'green-500' : 'gray-400' }} transition-colors shadow-sm flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-bold text-sm sm:text-base text-gray-900">{{ $sosmed['label'] }}</h4>
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded-full">Wajib</span>
                                </div>
                                <p class="text-xs text-gray-500 font-medium">{{ $sosmed['desc'] }}</p>
                                @if($isUploaded)
                                    <p class="text-xs text-green-600 font-bold mt-0.5">✓ Uploaded</p>
                                    <a href="{{ Storage::url($berkas->{$fieldName}) }}" target="_blank" class="text-[10px] text-blue-600 hover:underline">Lihat Bukti →</a>
                                @else
                                    <p class="text-xs text-red-400 font-medium mt-0.5">Belum diunggah</p>
                                @endif
                                <p class="text-xs text-primary-gold font-medium mt-0.5 hidden" id="preview-{{ $fieldName }}"></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 sm:flex-shrink-0">
                            <input type="file"
                                   name="{{ $fieldName }}"
                                   class="hidden"
                                   id="file-{{ $fieldName }}"
                                   accept="image/*"
                                   onchange="onFileSelected(this, '{{ $fieldName }}')">
                            <label for="file-{{ $fieldName }}"
                                   class="flex-1 sm:flex-none cursor-pointer bg-dark-navy text-white text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-gray-700 transition-all text-center">
                                {{ $isUploaded ? 'Pilih Ulang' : 'Pilih File' }}
                            </label>
                            <button type="submit"
                                    id="btn-save-{{ $fieldName }}"
                                    class="hidden flex-1 sm:flex-none bg-primary-gold text-dark-navy text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-primary-gold/80 transition-all text-center">
                                💾 Simpan
                            </button>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>

            {{-- ============================================================ --}}
            {{-- SERTIFIKAT PRESTASI — form sendiri                            --}}
            {{-- ============================================================ --}}
            <div>
                <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    Sertifikat Prestasi
                </h3>

                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data"
                      onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="sertifikat">
                    <div class="p-4 sm:p-6 bg-blue-50/50 rounded-2xl sm:rounded-[2rem] border border-blue-100">
                        <p class="text-xs sm:text-sm text-gray-600 mb-3">Unggah sertifikat prestasi Anda. Anda dapat memilih banyak file sekaligus (gunakan CTRL+Klik).</p>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                            <input type="file" name="sertifikat[]" multiple id="file-sertifikat"
                                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   onchange="onFileSelected(this, 'sertifikat')"/>
                            <button type="submit" id="btn-save-sertifikat"
                                    class="hidden w-full sm:w-auto bg-primary-gold text-dark-navy text-xs font-bold px-5 py-2.5 sm:py-3 rounded-xl hover:bg-primary-gold/80 transition-all">
                                💾 Simpan Sertifikat
                            </button>
                        </div>

                        @if($sertifikats->count() > 0)
                        <div class="mt-4">
                            <h5 class="font-bold text-sm text-gray-800 mb-2">Sertifikat Terunggah:</h5>
                            <ul class="list-disc pl-5 text-xs text-gray-600">
                                @foreach($sertifikats as $s)
                                    <li>{{ $s->nama }} ({{ $s->tahun }}) <a href="{{ Storage::url($s->file) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ============================================================ --}}
            {{-- PERSONAL STATEMENT                                             --}}
            {{-- ============================================================ --}}
            <div>
                <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    Personal Statement
                </h3>

                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data"
                      onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="personal_statement">
                    <div class="p-4 sm:p-6 bg-green-50/50 rounded-2xl sm:rounded-[2rem] border border-green-100">
                        {{-- Desc + Download --}}
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                            <div class="flex-1">
                                <p class="text-xs sm:text-sm text-gray-600 mb-2">
                                    <strong class="text-gray-900">Personal Statement</strong> adalah esai singkat tentang diri Anda, motivasi, dan rencana masa depan.
                                    Silakan download template, isi, dan upload kembali dalam format PDF.
                                </p>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">📝 Wajib</span>
                                    <span class="text-xs text-gray-500">Format: PDF | Max: 5MB</span>
                                </div>
                            </div>
                            <a href="{{ asset('icon/Personal Statement MFLS 2026.pdf') }}" download
                               class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-md flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Download Template
                            </a>
                        </div>
                        {{-- Upload Row --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 sm:p-5 bg-white rounded-xl sm:rounded-2xl border border-green-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-xl flex items-center justify-center text-{{ $berkas && $berkas->personal_statement ? 'green-600' : 'gray-400' }} flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm sm:text-base text-gray-900">Upload Personal Statement (PDF)</h4>
                                    @if($berkas && $berkas->personal_statement)
                                        <p class="text-xs text-green-600 font-bold mt-0.5">✓ File terunggah</p>
                                        <a href="{{ Storage::url($berkas->personal_statement) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat File →</a>
                                    @else
                                        <p class="text-xs text-red-400 font-medium mt-0.5">Belum diunggah</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="file" name="personal_statement" class="hidden" id="file-personal_statement" accept=".pdf,.doc,.docx"
                                       onchange="onFileSelected(this, 'personal_statement')">
                                <label for="file-personal_statement" class="flex-1 sm:flex-none cursor-pointer bg-dark-navy text-white text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-gray-700 transition-all text-center">
                                    {{ $berkas && $berkas->personal_statement ? 'Pilih Ulang' : 'Pilih File' }}
                                </label>
                                <button type="submit" id="btn-save-personal_statement"
                                        class="hidden flex-1 sm:flex-none bg-primary-gold text-dark-navy text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-primary-gold/80 transition-all text-center">
                                    💾 Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ============================================================ --}}
            {{-- STUDY PLAN                                                     --}}
            {{-- ============================================================ --}}
            <div>
                <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    Study Plan
                </h3>

                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data"
                      onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="study_plan">
                    <div class="p-4 sm:p-6 bg-blue-50/50 rounded-2xl sm:rounded-[2rem] border border-blue-100">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                            <div class="flex-1">
                                <p class="text-xs sm:text-sm text-gray-600 mb-2">
                                    <strong class="text-gray-900">Study Plan</strong> adalah rencana studi Anda selama menempuh pendidikan di universitas.
                                    Silakan download template, isi, dan upload kembali dalam format PDF.
                                </p>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">📝 Wajib</span>
                                    <span class="text-xs text-gray-500">Format: PDF | Max: 5MB</span>
                                </div>
                            </div>
                            <a href="{{ asset('icon/Study Plan MFLS 2026_2.pdf') }}" download
                               class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-md flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Download Template
                            </a>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 sm:p-5 bg-white rounded-xl sm:rounded-2xl border border-blue-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-xl flex items-center justify-center text-{{ $berkas && $berkas->study_plan ? 'blue-600' : 'gray-400' }} flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm sm:text-base text-gray-900">Upload Study Plan (PDF)</h4>
                                    @if($berkas && $berkas->study_plan)
                                        <p class="text-xs text-green-600 font-bold mt-0.5">✓ File terunggah</p>
                                        <a href="{{ Storage::url($berkas->study_plan) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat File →</a>
                                    @else
                                        <p class="text-xs text-red-400 font-medium mt-0.5">Belum diunggah</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="file" name="study_plan" class="hidden" id="file-study_plan" accept=".pdf,.doc,.docx"
                                       onchange="onFileSelected(this, 'study_plan')">
                                <label for="file-study_plan" class="flex-1 sm:flex-none cursor-pointer bg-dark-navy text-white text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-gray-700 transition-all text-center">
                                    {{ $berkas && $berkas->study_plan ? 'Pilih Ulang' : 'Pilih File' }}
                                </label>
                                <button type="submit" id="btn-save-study_plan"
                                        class="hidden flex-1 sm:flex-none bg-primary-gold text-dark-navy text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-primary-gold/80 transition-all text-center">
                                    💾 Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ============================================================ --}}
            {{-- SURAT REKOMENDASI SEKOLAH                                      --}}
            {{-- ============================================================ --}}
            @if($tahunLulus >= 2026)
            <div>
                <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    Surat Rekomendasi Sekolah
                </h3>

                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data"
                      onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="surat_rekomendasi_sekolah">
                    <div class="p-4 sm:p-6 bg-orange-50/50 rounded-2xl sm:rounded-[2rem] border border-orange-100">
                        {{-- Desc + Download --}}
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                            <div class="flex-1">
                                <p class="text-xs sm:text-sm text-gray-600 mb-2">
                                    <strong class="text-gray-900">Surat Rekomendasi Sekolah</strong> adalah surat pernyataan dukungan dari pihak sekolah.
                                    Silakan download template, isi, and upload kembali dalam format PDF.
                                </p>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">📝 Wajib</span>
                                    <span class="text-xs text-gray-500">Format: PDF | Max: 5MB</span>
                                </div>
                            </div>
                            <a href="{{ asset('icon/Surat Rekomendasi MFLS_2.pdf') }}" download
                               class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-md flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Download Template
                            </a>
                        </div>
                        {{-- Upload Row --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 sm:p-5 bg-white rounded-xl sm:rounded-2xl border border-orange-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-xl flex items-center justify-center text-{{ $berkas && $berkas->surat_rekomendasi_sekolah ? 'orange-600' : 'gray-400' }} flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm sm:text-base text-gray-900">Upload Surat Rekomendasi (PDF)</h4>
                                    @if($berkas && $berkas->surat_rekomendasi_sekolah)
                                        <p class="text-xs text-green-600 font-bold mt-0.5">✓ File terunggah</p>
                                        <a href="{{ Storage::url($berkas->surat_rekomendasi_sekolah) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat File →</a>
                                    @else
                                        <p class="text-xs text-red-400 font-medium mt-0.5">Belum diunggah</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="file" name="surat_rekomendasi_sekolah" class="hidden" id="file-surat_rekomendasi_sekolah" accept=".pdf,.doc,.docx"
                                       onchange="onFileSelected(this, 'surat_rekomendasi_sekolah')">
                                <label for="file-surat_rekomendasi_sekolah" class="flex-1 sm:flex-none cursor-pointer bg-dark-navy text-white text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-gray-700 transition-all text-center">
                                    {{ $berkas && $berkas->surat_rekomendasi_sekolah ? 'Pilih Ulang' : 'Pilih File' }}
                                </label>
                                <button type="submit" id="btn-save-surat_rekomendasi_sekolah"
                                        class="hidden flex-1 sm:flex-none bg-primary-gold text-dark-navy text-xs font-bold px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-primary-gold/80 transition-all text-center">
                                    💾 Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            {{-- ============================================================ --}}
            {{-- LINK VIDEO MOTIVASI — form sendiri                             --}}
            {{-- ============================================================ --}}
            <div>
                <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    Link Video - Membuat Video Motivasi
                </h3>

                <form action="{{ route('pendaftar.berkas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="upload_field" value="motivasi_video">
                    <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-[2rem] border border-purple-200">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Link Video - Membuat Video Motivasi (Instagram/TikTok/YouTube)</label>
                        <div class="relative mb-3">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            </div>
                            <input type="url" name="motivasi_video"
                                   value="{{ old('motivasi_video', $berkas->motivasi_video ?? '') }}"
                                   placeholder="https://instagram.com/reel/..."
                                   class="w-full pl-12 pr-3 py-3 sm:py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/20 outline-none transition-all text-sm">
                        </div>
                        <p class="text-xs text-gray-500 mb-3">💡 Bisa dari Instagram Reels, TikTok, atau YouTube. Pastikan video bisa diakses publik!</p>
                        @if($berkas && $berkas->motivasi_video)
                            <div class="mb-3 p-3 bg-green-50 rounded-xl border border-green-100">
                                <p class="text-xs text-green-700 font-bold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Link video sudah tersimpan
                                </p>
                                <a href="{{ $berkas->motivasi_video }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block break-all">
                                    {{ Str::limit($berkas->motivasi_video, 50) }} →
                                </a>
                            </div>
                        @endif
                        <button type="submit"
                                class="w-full sm:w-auto bg-primary-gold text-dark-navy text-sm font-bold px-8 py-3 rounded-xl hover:bg-primary-gold/80 transition-all">
                            💾 Simpan Link Video
                        </button>
                    </div>
                </form>

        </div>
    </div>
</div>


<script>
/**
 * Dipanggil saat file dipilih. Tampilkan tombol Simpan dan nama file.
 */
function onFileSelected(input, fieldName) {
    const btn = document.getElementById('btn-save-' + fieldName);
    const preview = document.getElementById('preview-' + fieldName);
    
    if (input.files.length > 0) {
        // Tampilkan tombol simpan
        if (btn) btn.classList.remove('hidden');
        
        // Tampilkan nama file
        if (preview) {
            const names = Array.from(input.files).map(f => f.name).join(', ');
            preview.textContent = '📎 ' + names;
            preview.classList.remove('hidden');
        }
    } else {
        if (btn) btn.classList.add('hidden');
        if (preview) {
            preview.textContent = '';
            preview.classList.add('hidden');
        }
    }
}

/**
 * Validasi ukuran file sebelum submit. Max 5MB per file.
 */
function validateSingleForm(form) {
    const maxSize = 5 * 1024 * 1024; // 5MB
    const fileInputs = form.querySelectorAll('input[type="file"]');
    
    for (let input of fileInputs) {
        for (let file of input.files) {
            if (file.size > maxSize) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'File Terlalu Besar!',
                        html: `File <strong>"${file.name}"</strong> melebihi batas maksimal <strong>5MB</strong>.<br><br>Silakan kompres atau kurangi ukuran file terlebih dahulu.`,
                        icon: 'error',
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'OK, Mengerti'
                    });
                } else {
                    alert(`File "${file.name}" melebihi batas 5MB.`);
                }
                return false;
            }
        }
    }
    return true;
}
</script>
@endsection
