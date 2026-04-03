@extends('pendaftar.layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 pb-20">
    {{-- Hidden Delete Form --}}
    <form id="deleteFileForm" action="{{ route('pendaftar.berkas.delete_file') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="field" id="deleteField">
        <input type="hidden" name="file_path" id="deleteFilePath">
    </form>
    <form id="deleteSertifikatForm" action="" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Header Section -->
    <div class="relative overflow-hidden bg-[#001f3f] p-8 md:p-12 rounded-[2.5rem] lg:rounded-[3.5rem] shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-center md:text-left">
                <h1 class="text-2xl md:text-4xl font-black text-white mb-2 tracking-tight">Pusat <span class="text-orange-500 underline decoration-orange-500/30 underline-offset-8">Dokumen</span></h1>
                <p class="text-[10px] md:text-xs text-orange-200/60 font-bold max-w-lg leading-relaxed uppercase tracking-[0.2em]">Lengkapi seluruh berkas persyaratan beasiswa Anda dengan aman.</p>
            </div>
            <div class="hidden md:flex w-20 h-20 bg-white/10 rounded-[2rem] items-center justify-center text-orange-400 border border-white/10 backdrop-blur-sm">
                <span class="iconify text-4xl" data-icon="solar:cloud-upload-bold-duotone"></span>
            </div>
        </div>
    </div>

    {{-- Info Akademik --}}
    <div class="bg-white rounded-[2rem] border-2 border-[#001f3f]/5 p-6 md:p-8 shadow-sm flex flex-col md:flex-row items-start md:items-center gap-6">
        <div class="w-12 h-12 bg-[#001f3f] text-orange-400 rounded-xl flex items-center justify-center shrink-0 shadow-lg">
            <span class="iconify text-2xl" data-icon="solar:info-circle-bold"></span>
        </div>
        <div class="flex-1 space-y-3">
            <div class="flex flex-wrap items-center gap-3">
                <div class="px-3 py-1.5 bg-slate-50 border border-slate-100 rounded-lg">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Tahun Lulus</p>
                    <p class="text-xs font-black text-[#001f3f]">{{ $peserta->daftar->tahun_lulus ?? '2026' }}</p>
                </div>
                @php $tahunLulus = (int) ($peserta->daftar->tahun_lulus ?? 2026); @endphp
                <span class="px-3 py-1.5 {{ $tahunLulus < 2026 ? 'bg-slate-100 text-slate-600' : 'bg-orange-500 text-white' }} text-[10px] font-black rounded-lg border border-transparent uppercase tracking-widest shadow-sm">
                   {{ $tahunLulus < 2026 ? '✓ ALUMNI' : '🎓 SISWA KELAS 12' }}
                </span>
            </div>
            <p class="text-[10px] text-slate-400 font-bold italic leading-tight">
                *Kebutuhan Rapor otomatis menyesuaikan kategori kelulusan Anda.
            </p>
        </div>
    </div>

    {{-- Main Documents Grid --}}
    <div class="space-y-8">
        <div class="flex items-center gap-3 border-b-2 border-slate-50 pb-4">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-lg flex items-center justify-center shadow-lg shadow-orange-500/20">
                <span class="iconify" data-icon="solar:document-bold-duotone" data-width="20"></span>
            </div>
            <h3 class="text-xl font-extrabold text-[#001f3f] tracking-tight">Dokumen Utama</h3>
        </div>

        @php
            $inputFiles = [
                ['name' => 'foto',    'label' => 'Pas Foto 4x6',      'desc' => 'Latar merah, JPG/PNG format.', 'icon' => 'solar:user-circle-bold-duotone'],
            ];
            for ($i = 1; $i <= $maxSemester; $i++) {
                $inputFiles[] = ['name' => 'rapor'.$i,  'label' => 'Rapor Semester '.$i, 'desc' => 'Hasil Scan Berwarna.', 'multiple' => true, 'icon' => 'solar:checklist-bold-duotone'];
            }
            if ($peserta->pilihan_prodi == 'Desain Komunikasi Visual (DKV)') {
                $inputFiles[] = ['name' => 'surat_buta_warna', 'label' => 'Bebas Buta Warna', 'desc' => 'Hasil Medis (Wajib DKV).', 'icon' => 'solar:eye-scan-bold-duotone'];
            }
            if ($tahunLulus < 2026) {
                $inputFiles[] = ['name' => 'ijazah', 'label' => 'Ijazah Asli', 'desc' => 'Scan Ijazah asli.', 'icon' => 'solar:diploma-bold-duotone'];
            } else {
                $inputFiles[] = ['name' => 'ijazah', 'label' => 'SKL / Kartu Pelajar', 'desc' => 'Data identitas siswa.', 'icon' => 'solar:card-id-bold-duotone'];
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 pb-6">
            @foreach($inputFiles as $file)
            @php
                $fieldName  = $file['name'];
                $isMultiple = $file['multiple'] ?? false;
                $isUploaded = $berkas && $berkas->{$fieldName};
                if ($isUploaded) {
                    $decoded  = json_decode($berkas->{$fieldName}, true);
                }
            @endphp
            <div class="bg-white p-6 rounded-[2rem] border-2 border-slate-50 hover:border-orange-500/30 hover:shadow-xl hover:shadow-orange-100 transition-all duration-500">
                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="{{ $fieldName }}">
                    
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-12 h-12 {{ $isUploaded ? 'bg-[#001f3f] text-orange-400' : 'bg-slate-50 text-slate-300' }} rounded-xl flex items-center justify-center transition-all shadow-md">
                            <span class="iconify text-2xl" data-icon="{{ $file['icon'] }}"></span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-black text-[#001f3f] text-xs uppercase tracking-widest leading-none mb-1">{{ $file['label'] }}</h4>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest opacity-80">{{ $file['desc'] }}</p>
                        </div>
                        @if($isUploaded)
                            <span class="iconify text-orange-500" data-icon="solar:verified-check-bold" data-width="24"></span>
                        @endif
                    </div>

                    <div class="bg-slate-100/50 rounded-xl p-3 mb-4 border border-slate-100 min-h-[50px] flex flex-col justify-center">
                        @if($isUploaded)
                            <div class="flex flex-wrap gap-2">
                                @if(!$isMultiple)
                                    <div class="flex items-center justify-between w-full h-8 px-3 bg-white border border-slate-200 rounded-lg">
                                        <a href="{{ Storage::url($berkas->{$fieldName}) }}" target="_blank" class="text-[9px] font-black text-[#001f3f] hover:text-orange-500 uppercase tracking-widest flex items-center gap-2">
                                            <span class="iconify" data-icon="solar:eye-bold"></span> VIEW
                                        </a>
                                        <button type="button" onclick="confirmDeleteFile('{{ $fieldName }}')" class="text-[9px] font-black text-red-500 hover:text-red-700 uppercase tracking-widest">
                                            SKIP/DEL
                                        </button>
                                    </div>
                                @else
                                    @php $paths = isset($decoded) ? (is_array($decoded) ? $decoded : [$decoded]) : []; @endphp
                                    @foreach($paths as $idx => $p)
                                        <div class="flex items-center gap-2 px-2 py-1 bg-white border border-slate-200 rounded-lg group/file max-w-full">
                                            <a href="{{ Storage::url($p) }}" target="_blank" class="text-[9px] font-black text-slate-700 truncate max-w-[60px]">FILE {{ $idx+1 }}</a>
                                            <button type="button" onclick="confirmDeleteFile('{{ $fieldName }}', '{{ $p }}')" class="text-red-400 hover:text-red-600">
                                                <span class="iconify" data-icon="solar:close-circle-bold"></span>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @else
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic text-center">Belum ada file</p>
                        @endif
                        <p id="preview-{{ $fieldName }}" class="text-[9px] font-black text-orange-600 mt-2 hidden truncate bg-white p-2 rounded-lg border border-dashed border-orange-500/30"></p>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="file" name="{{ $fieldName }}{{ $isMultiple ? '[]' : '' }}" class="hidden" id="file-{{ $fieldName }}" {{ $isMultiple ? 'multiple' : '' }} onchange="onFileSelected(this, '{{ $fieldName }}')">
                        <label for="file-{{ $fieldName }}" class="flex-1 cursor-pointer bg-[#001f3f] text-white text-[10px] font-black uppercase tracking-widest px-4 py-3 rounded-xl hover:bg-black transition-all text-center border border-white/5">
                            {{ $isUploaded ? 'Replace' : 'Upload' }}
                        </label>
                        <button type="submit" id="btn-save-{{ $fieldName }}" class="hidden flex-1 bg-orange-500 text-white text-[10px] font-black uppercase tracking-widest px-4 py-3 rounded-xl hover:shadow-lg transition-all shadow-orange-500/20">
                           SIMPAN
                        </button>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Social Media Proof -->
    <div class="space-y-8 mt-12">
        <div class="flex items-center gap-3 border-b-2 border-slate-50 pb-4">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-lg flex items-center justify-center shadow-lg shadow-orange-500/20">
                <span class="iconify" data-icon="solar:link-bold-duotone" data-width="20"></span>
            </div>
            <h3 class="text-xl font-extrabold text-[#001f3f] tracking-tight">Social Media Proof</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $sosmedFollows = [
                    ['name' => 'bukti_follow_ig_beasiswamncu',    'label' => 'IG @beasiswamncu',      'icon' => 'solar:camera-bold'],
                    ['name' => 'bukti_follow_ig_mncu',           'label' => 'IG @mncuniversity',     'icon' => 'solar:camera-bold'],
                    ['name' => 'bukti_follow_tiktok_beasiswamncu','label' => 'TikTok @beasiswamncu',  'icon' => 'solar:videocamera-record-bold'],
                    ['name' => 'bukti_follow_tiktok_mncu',        'label' => 'TikTok @mncuniversity', 'icon' => 'solar:videocamera-record-bold'],
                ];
            @endphp

            @foreach($sosmedFollows as $sosmed)
            @php
                $fieldName  = $sosmed['name'];
                $isUploaded = $berkas && $berkas->{$fieldName};
            @endphp
            <div class="bg-white p-5 rounded-[1.5rem] border-2 border-slate-50 flex flex-col justify-between group hover:border-orange-500/30 transition-all">
                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="{{ $fieldName }}">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 {{ $isUploaded ? 'bg-[#001f3f] text-orange-400' : 'bg-slate-50 text-slate-300' }} rounded-xl flex items-center justify-center border border-current/5 shadow-sm">
                            <span class="iconify text-xl" data-icon="{{ $sosmed['icon'] }}"></span>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-tight truncate">{{ $sosmed['label'] }}</h4>
                            @if($isUploaded)
                                <div class="flex items-center gap-2">
                                    <a href="{{ Storage::url($berkas->{$fieldName}) }}" target="_blank" class="text-[8px] font-black text-orange-600 uppercase hover:text-orange-700">View</a>
                                    <button type="button" onclick="confirmDeleteFile('{{ $fieldName }}')" class="text-[8px] font-black text-red-500 uppercase">Del</button>
                                </div>
                            @else
                                <p class="text-[8px] font-bold text-slate-200 italic uppercase leading-none mt-0.5">Missing</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="file" name="{{ $fieldName }}" class="hidden" id="file-{{ $fieldName }}" accept="image/*" onchange="onFileSelected(this, '{{ $fieldName }}')">
                        <label for="file-{{ $fieldName }}" class="flex-1 h-9 bg-[#001f3f] text-white rounded-lg flex items-center justify-center cursor-pointer hover:bg-black transition-all text-[9px] font-black uppercase tracking-widest px-2">
                            {{ $isUploaded ? 'Replace' : 'Upload' }}
                        </label>
                        <button type="submit" id="btn-save-{{ $fieldName }}" class="hidden w-9 h-9 bg-orange-500 text-white rounded-lg flex items-center justify-center shadow-sm">
                            <span class="iconify text-xl" data-icon="solar:diskette-bold"></span>
                        </button>
                    </div>
                    <p id="preview-{{ $fieldName }}" class="text-[8px] font-black text-orange-600 mt-2 truncate hidden italic text-center"></p>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Achievement Certificates --}}
    <div class="space-y-8 mt-12">
        <div class="flex items-center gap-3 border-b-2 border-slate-50 pb-4">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-lg flex items-center justify-center shadow-lg shadow-orange-500/20">
                <span class="iconify" data-icon="solar:medal-star-bold-duotone" data-width="20"></span>
            </div>
            <h3 class="text-xl font-extrabold text-[#001f3f] tracking-tight">Sertifikat Prestasi</h3>
        </div>

        <div class="bg-white p-6 md:p-10 rounded-[2.5rem] border-2 border-slate-50 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 leading-relaxed mb-8 uppercase tracking-widest opacity-80 text-center">Unggah sertifikat prestasi terbaik Anda sebagai nilai tambah profil Anda.</p>
            
            <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSingleForm(this)">
                @csrf
                <input type="hidden" name="upload_field" value="sertifikat">
                <div class="relative mb-10">
                    <input type="file" name="sertifikat[]" multiple id="file-sertifikat" class="hidden" onchange="onFileSelected(this, 'sertifikat')"/>
                    <label for="file-sertifikat" class="flex flex-col items-center justify-center w-full py-10 border-4 border-dotted border-slate-100 rounded-[2rem] bg-slate-50/50 cursor-pointer hover:border-orange-500 hover:bg-orange-500/5 transition-all">
                        <span class="iconify text-5xl text-slate-300 mb-3" data-icon="solar:cloud-plus-bold-duotone"></span>
                        <span class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Pilih Banyak Sertifikat (PDF/JPG)</span>
                    </label>
                    <p id="preview-sertifikat" class="text-[10px] font-black text-orange-600 mt-4 text-center hidden bg-orange-50 py-2 rounded-xl"></p>
                    <button type="submit" id="btn-save-sertifikat" class="hidden w-full mt-6 bg-orange-500 text-white text-[11px] font-black py-5 rounded-2xl shadow-xl shadow-orange-500/20 uppercase tracking-widest">💾 Simpan Semua Sertifikat</button>
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($sertifikats as $s)
                    <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200/50 rounded-2xl hover:bg-white hover:border-orange-500/30 transition-all">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-10 h-10 bg-[#001f3f] text-orange-400 rounded-xl flex items-center justify-center shrink-0 shadow-md">
                                <span class="iconify text-xl" data-icon="solar:medal-ribbon-bold-duotone"></span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-black text-[#001f3f] truncate uppercase">{{ $s->nama }}</p>
                                <p class="text-[9px] font-black text-orange-500 uppercase tracking-widest">{{ $s->tahun }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ Storage::url($s->file) }}" target="_blank" class="w-9 h-9 bg-white border border-slate-200 text-[#001f3f] rounded-lg flex items-center justify-center shadow-sm hover:text-orange-500">
                                <span class="iconify" data-icon="solar:eye-linear"></span>
                            </a>
                            <button type="button" onclick="confirmDeleteSertifikat({{ $s->id }}, '{{ $s->nama }}')" class="w-9 h-9 bg-white border border-slate-200 text-red-500 rounded-lg flex items-center justify-center shadow-sm hover:text-red-700">
                                <span class="iconify" data-icon="solar:trash-bin-trash-linear"></span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-slate-50/50 rounded-3xl border-2 border-dashed border-slate-100">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Belum ada prestasi yang diunggah</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Essays & Academic Plans --}}
    <div class="space-y-8 mt-12">
        <div class="flex items-center gap-3 border-b-2 border-slate-50 pb-4">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-lg flex items-center justify-center shadow-lg shadow-orange-500/20">
                <span class="iconify" data-icon="solar:pen-new-square-bold-duotone" data-width="20"></span>
            </div>
            <h3 class="text-xl font-extrabold text-[#001f3f] tracking-tight">Essays & Academic Plans</h3>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @php
                $essays = [
                    [
                        'name' => 'personal_statement',
                        'label' => 'Personal Statement',
                        'desc' => 'Visi masa depan & alasan kelayakan.',
                        'template' => 'Personal Statement MFLS 2026.pdf',
                        'guide' => 'Tuliskan siapa diri Anda, apa motivasi terbesar Anda mengikuti beasiswa ini, dan bagaimana beasiswa ini akan merubah masa depan Anda dan keluarga.'
                    ],
                    [
                        'name' => 'study_plan',
                        'label' => 'Study Plan',
                        'desc' => 'Rencana studi akademik 4 tahun.',
                        'template' => 'Study Plan MFLS 2026_2.pdf',
                        'guide' => 'Jelaskan target IPK Anda setiap semester, mata kuliah apa yang paling ingin Anda dalami, dan kegiatan organisasi apa yang akan Anda ikuti untuk mendukung perkuliahan.'
                    ]
                ];
                if($tahunLulus >= 2026) {
                    $essays[] = [
                        'name' => 'surat_rekomendasi_sekolah',
                        'label' => 'Rekomendasi Sekolah',
                        'desc' => 'Dukungan resmi dari sekolah.',
                        'template' => 'Surat Rekomendasi MFLS_2.pdf',
                        'guide' => 'Mintalah surat ini kepada Wali Kelas, Guru BK, atau Kepala Sekolah yang mengenal baik prestasi dan karakter Anda di sekolah.'
                    ];
                }
            @endphp

            @foreach($essays as $essay)
            @php $isUploaded = $berkas && $berkas->{$essay['name']}; @endphp
            <div class="bg-white p-6 md:p-8 rounded-[2rem] border-2 border-slate-50 flex flex-col justify-between group hover:border-orange-500/30 transition-all shadow-sm">
                <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSingleForm(this)">
                    @csrf
                    <input type="hidden" name="upload_field" value="{{ $essay['name'] }}">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-12 h-12 {{ $isUploaded ? 'bg-[#001f3f] text-orange-400' : 'bg-slate-50 text-slate-300' }} rounded-xl flex items-center justify-center border border-current/5 shrink-0 shadow-md">
                            <span class="iconify text-2xl" data-icon="solar:document-add-bold-duotone"></span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-[12px] font-black text-[#001f3f] uppercase tracking-widest mb-1">{{ $essay['label'] }}</h4>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $essay['desc'] }}</p>
                        </div>
                    </div>

                    <div class="mb-6 p-4 bg-orange-500/[0.03] rounded-2xl border border-orange-500/10">
                        <div class="flex items-center gap-2 mb-3 text-orange-600">
                            <span class="iconify text-lg" data-icon="solar:magic-stick-3-bold-duotone"></span>
                            <span class="text-[9px] font-black uppercase tracking-widest">Digital Mentor Tips</span>
                        </div>
                        <ul class="space-y-2">
                            @if($essay['name'] == 'personal_statement')
                                <li class="text-[9px] font-bold text-slate-600 leading-tight">• Deskripsikan bakat unik & visi perubahan Anda.</li>
                                <li class="text-[9px] font-bold text-slate-500 italic leading-tight">Hint: Ceritakan latar belakang keluarga, ekonomi, atau tantangan hidup yang memotivasi Anda untuk kuliah.</li>
                            @elseif($essay['name'] == 'study_plan')
                                <li class="text-[9px] font-bold text-slate-600 leading-tight">• Rencanakan target IPK & kontribusi di kampus.</li>
                                <li class="text-[9px] font-bold text-slate-500 italic leading-tight">Hint: {{ $essay['guide'] }}</li>
                            @elseif($essay['name'] == 'surat_rekomendasi_sekolah')
                                <li class="text-[9px] font-bold text-slate-600 leading-tight">• Pastikan ada TTD & Cap Sekolah basah.</li>
                                <li class="text-[9px] font-bold text-slate-500 italic leading-tight">Hint: {{ $essay['guide'] }}</li>
                            @endif
                        </ul>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mb-6">
                        <a href="{{ asset('icon/'.$essay['template']) }}" download class="flex-1 min-w-[120px] py-3 bg-[#001f3f] text-white text-[9px] font-black uppercase tracking-[0.2em] rounded-xl text-center hover:bg-black transition-all shadow-md">
                             Template
                        </a>
                        <div class="px-3 py-3 bg-white border-2 border-slate-100 text-[#001f3f] text-[9px] font-black uppercase tracking-widest rounded-xl">
                            PDF
                        </div>
                    </div>

                    <div class="mt-auto space-y-4">
                        @if($isUploaded)
                            <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <a href="{{ Storage::url($berkas->{$essay['name']}) }}" target="_blank" class="text-[9px] font-black text-[#001f3f] hover:text-orange-600 uppercase tracking-widest flex items-center gap-2">
                                    <span class="iconify" data-icon="solar:eye-bold-duotone"></span> PREVIEW
                                </a>
                                <button type="button" onclick="confirmDeleteFile('{{ $essay['name'] }}')" class="text-[9px] font-black text-red-500 uppercase tracking-widest hover:text-red-700">DELETE</button>
                            </div>
                        @else
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic text-center mb-2">Unggah file PDF Anda</p>
                        @endif
                        <div class="flex items-center gap-2">
                            <input type="file" name="{{ $essay['name'] }}" class="hidden" id="file-{{ $essay['name'] }}" accept=".pdf" onchange="onFileSelected(this, '{{ $essay['name'] }}')">
                            <label for="file-{{ $essay['name'] }}" class="flex-1 cursor-pointer bg-orange-500 text-white text-[10px] font-black uppercase tracking-widest px-4 py-4 rounded-xl hover:bg-orange-600 transition-all text-center shadow-lg shadow-orange-500/20">
                                {{ $isUploaded ? 'Replace File' : 'Browse PDF' }}
                            </label>
                            <button type="submit" id="btn-save-{{ $essay['name'] }}" class="hidden flex-1 bg-[#001f3f] text-white text-[10px] font-black uppercase tracking-widest px-4 py-4 rounded-xl">
                                SAVE
                            </button>
                        </div>
                        <p id="preview-{{ $essay['name'] }}" class="text-[9px] font-black text-orange-600 text-center hidden truncate italic mt-2 bg-orange-50 py-2 rounded-lg"></p>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Motivational Video --}}
    <div class="space-y-8 mt-12 pb-24">
        <div class="flex items-center justify-between border-b-2 border-slate-50 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-orange-500 text-white rounded-lg flex items-center justify-center shadow-lg shadow-orange-500/20">
                    <span class="iconify" data-icon="solar:play-bold-duotone" data-width="20"></span>
                </div>
                <h3 class="text-xl font-extrabold text-[#001f3f] tracking-tight">Motivational Video</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border-2 border-slate-50 overflow-hidden shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="p-8 md:p-12 bg-[#001f3f] text-white flex flex-col justify-center border-r-2 border-white/10">
                    <h4 class="text-2xl font-black leading-tight mb-4 uppercase tracking-tighter">Video <span class="text-orange-400 italic">Guide</span></h4>
                    <p class="text-[11px] text-orange-100/60 font-bold uppercase tracking-[0.2em] leading-relaxed">Tunjukkan pesona dan semangat kepemimpinan Anda secara visual.</p>
                </div>
                <div class="p-8 md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-10 bg-slate-50/50">
                    <div class="space-y-4">
                        <h5 class="text-[11px] font-black text-[#001f3f] uppercase tracking-widest border-b border-[#001f3f]/10 pb-2">Script Point</h5>
                        <ul class="space-y-3">
                            <li class="text-[10px] font-bold text-slate-600 leading-tight">1. Sapaan & Nama Origin.</li>
                            <li class="text-[10px] font-bold text-slate-600 leading-tight">2. Alasan kuat memilih MNCU.</li>
                            <li class="text-[10px] font-bold text-slate-600 leading-tight">3. Kontribusi setelah lulus.</li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h5 class="text-[11px] font-black text-[#001f3f] uppercase tracking-widest border-b border-[#001f3f]/10 pb-2">Technical</h5>
                        <ul class="space-y-3">
                            <li class="text-[10px] font-bold text-slate-600 leading-tight">• Cahaya dari arah depan.</li>
                            <li class="text-[10px] font-bold text-slate-600 leading-tight">• Suara jernih (tanpa noise).</li>
                            <li class="text-[10px] font-bold text-slate-600 leading-tight">• Rasio 16:9 atau 9:16.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('pendaftar.berkas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="upload_field" value="motivasi_video">
            <div class="bg-[#001f3f] p-8 md:p-14 rounded-[3rem] shadow-2xl shadow-[#001f3f]/20 relative overflow-hidden">
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-12 items-center">
                    <div class="lg:col-span-2 space-y-10">
                        <div>
                            <p class="text-[10px] font-black text-orange-400 uppercase tracking-[0.4em] mb-4">🔗 Instagram Video Link</p>
                            <input type="url" name="motivasi_video" value="{{ old('motivasi_video', $berkas->motivasi_video ?? '') }}" placeholder="https://instagram.com/reel/..."
                                   class="w-full px-8 py-6 bg-white/5 border-2 border-white/10 rounded-2xl text-sm text-white focus:ring-2 focus:ring-orange-500 outline-none transition-all font-bold placeholder:text-white/20">
                            @if($berkas && $berkas->motivasi_video)
                                <a href="{{ $berkas->motivasi_video }}" target="_blank" class="text-[10px] font-black text-orange-400 uppercase tracking-widest mt-4 inline-flex items-center gap-2 hover:text-white transition-colors">
                                    <span class="iconify" data-icon="solar:play-stream-bold-duotone"></span> View on Instagram
                                </a>
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-orange-400 uppercase tracking-[0.4em] mb-4">🔗 TikTok Video Link</p>
                            <input type="url" name="motivasi_video_tiktok" value="{{ old('motivasi_video_tiktok', $berkas->motivasi_video_tiktok ?? '') }}" placeholder="https://tiktok.com/@user/video/..."
                                   class="w-full px-8 py-6 bg-white/5 border-2 border-white/10 rounded-2xl text-sm text-white focus:ring-2 focus:ring-orange-500 outline-none transition-all font-bold placeholder:text-white/20">
                             @if($berkas && $berkas->motivasi_video_tiktok)
                                <a href="{{ $berkas->motivasi_video_tiktok }}" target="_blank" class="text-[10px] font-black text-orange-400 uppercase tracking-widest mt-4 inline-flex items-center gap-2 hover:text-white transition-colors">
                                    <span class="iconify" data-icon="solar:videocamera-record-bold-duotone"></span> View on TikTok
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center p-8 bg-white/5 rounded-[2.5rem] border border-white/10 backdrop-blur-md">
                         <div class="w-24 h-24 bg-orange-500 text-white rounded-3xl flex items-center justify-center mb-8 shadow-xl shadow-orange-500/30">
                            <span class="iconify text-5xl" data-icon="solar:magic-stick-2-bold-duotone"></span>
                        </div>
                        <p class="text-[11px] font-bold text-white/40 uppercase tracking-[0.3em] mb-10 italic">"Inspire Your Future"</p>
                        <button type="submit" class="w-full bg-orange-500 text-white text-[11px] font-black uppercase tracking-[0.3em] py-6 rounded-2xl hover:bg-white hover:text-[#001f3f] transition-all shadow-xl shadow-orange-500/20 active:scale-95">
                            Submit Campaign
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeleteFile(field, filePath = null) {
    Swal.fire({
        title: 'Hapus Berkas?',
        text: "Pastikan Anda memiliki cadangan file ini.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#001f3f',
        confirmButtonText: 'YA, HAPUS',
        cancelButtonText: 'BATAL',
        customClass: { popup: 'rounded-[2rem]' }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteField').value = field;
            document.getElementById('deleteFilePath').value = filePath || '';
            document.getElementById('deleteFileForm').submit();
        }
    })
}

function confirmDeleteSertifikat(id, nama) {
    Swal.fire({
        title: 'Hapus Sertifikat?',
        text: nama,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#001f3f',
        confirmButtonText: 'YA, HAPUS',
        cancelButtonText: 'BATAL',
        customClass: { popup: 'rounded-[2rem]' }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteSertifikatForm');
            form.action = "{{ url('pendaftar/berkas/delete-sertifikat') }}/" + id;
            form.submit();
        }
    })
}

function onFileSelected(input, fieldName) {
    const btn = document.getElementById('btn-save-' + fieldName);
    const preview = document.getElementById('preview-' + fieldName);
    const label = document.querySelector('label[for="file-' + fieldName + '"]');
    
    if (input.files.length > 0) {
        if (btn) btn.classList.remove('hidden');
        if (label) {
            label.innerHTML = `✓ ${input.files.length} FILE TERPILIH`;
            label.classList.remove('bg-[#001f3f]', 'bg-orange-500');
            label.classList.add('bg-green-600', 'animate-pulse');
        }
        if (preview) {
            const names = Array.from(input.files).map(f => f.name).join(', ');
            preview.textContent = 'Selected: ' + (names.length > 40 ? names.substring(0, 40) + '...' : names);
            preview.classList.remove('hidden');
        }
    } else {
        if (btn) btn.classList.add('hidden');
        if (label) {
            label.innerHTML = 'BROWSE FILE';
            label.classList.add('bg-[#001f3f]');
            label.classList.remove('bg-green-600', 'animate-pulse');
        }
        if (preview) {
            preview.textContent = '';
            preview.classList.add('hidden');
        }
    }
}

function validateSingleForm(form) {
    const maxSize = 10 * 1024 * 1024; 
    const fileInputs = form.querySelectorAll('input[type="file"]');
    for (let input of fileInputs) {
        for (let file of input.files) {
            if (file.size > maxSize) {
                Swal.fire({
                    title: 'File Terlalu Besar!',
                    html: `File <strong>"${file.name}"</strong> melebihi 10MB.`,
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'MENGERTI',
                    customClass: { popup: 'rounded-[2rem]' }
                });
                return false;
            }
        }
    }
    Swal.fire({
        title: 'Sedang Mengunggah...',
        text: 'Mohon tunggu sebentar.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); },
        customClass: { popup: 'rounded-[2rem]' }
    });
    return true;
}
</script>
@endsection
