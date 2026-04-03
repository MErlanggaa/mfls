@extends('layouts.admin')

@section('content')
<!-- Header Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-[2rem] p-6 text-white shadow-xl shadow-orange-500/20 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
        <h3 class="text-xs font-bold opacity-80 uppercase tracking-widest flex items-center gap-2">
            <span class="iconify" data-icon="solar:users-group-rounded-bold"></span> Total Pendaftar
        </h3>
        <p class="text-4xl font-black mt-2">{{ $pendaftars->count() }}</p>
        <div class="mt-4 text-xs font-bold bg-white/20 inline-block px-3 py-1 rounded-full">Mahasiswa Baru</div>
    </div>
    
    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-emerald-200 transition-colors">
        <div class="absolute right-0 top-0 w-20 h-20 bg-emerald-50 rounded-full blur-2xl -mr-5 -mt-5"></div>
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
            <span class="iconify text-emerald-500" data-icon="solar:check-circle-bold"></span> Sudah Diverifikasi
        </h3>
        <p class="text-4xl font-black text-slate-800 mt-2">
            {{ $pendaftars->filter(fn($p) => ($p->peserta->daftar->status ?? 'menunggu') != 'menunggu')->count() }}
        </p>
        <p class="text-xs font-bold text-emerald-600 mt-4">Dokumen Lengkap</p>
    </div>

    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-blue-200 transition-colors">
        <div class="absolute right-0 top-0 w-20 h-20 bg-blue-50 rounded-full blur-2xl -mr-5 -mt-5"></div>
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
            <span class="iconify text-blue-500" data-icon="solar:clock-circle-bold"></span> Perlu Tindakan
        </h3>
        <p class="text-4xl font-black text-slate-800 mt-2">
            {{ $pendaftars->filter(fn($p) => ($p->peserta->daftar->status ?? 'menunggu') == 'menunggu')->count() }}
        </p>
        <p class="text-xs font-bold text-blue-600 mt-4">Menunggu Review</p>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
    <!-- Toolbar -->
    <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Data Seleksi Administrasi</h2>
            <p class="text-slate-500 text-sm font-medium mt-1">Kelola dan verifikasi berkas pendaftar.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <form action="" method="GET" id="sortForm" class="flex items-center gap-2">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <!-- <select name="sort" onchange="this.form.submit()" class="pl-4 pr-10 py-3 bg-slate-50 border-transparent focus:bg-white focus:border-orange-200 focus:ring-4 focus:ring-orange-500/10 rounded-xl text-xs font-black uppercase tracking-widest outline-none transition-all cursor-pointer">
                        <option value="">Sortir: Default</option>
                        <option value="nilai_high" {{ request('sort') == 'nilai_high' ? 'selected' : '' }}>Nilai Tertinggi</option>
                        <option value="nilai_low" {{ request('sort') == 'nilai_low' ? 'selected' : '' }}>Nilai Terendah</option>
                    </select> -->
                </form>
            </div>
            <a href="{{ route('admin.export') }}" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-xs font-black shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all uppercase tracking-widest flex items-center gap-2">
                <span class="iconify text-lg" data-icon="solar:file-download-bold"></span>
                Export
            </a>
            <form method="GET" class="relative w-full md:w-auto">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <span class="iconify absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" data-icon="solar:magnifer-linear"></span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / Sekolah..." 
                    class="pl-12 pr-6 py-3 w-full md:w-64 bg-slate-50 border-transparent focus:bg-white focus:border-orange-200 focus:ring-4 focus:ring-orange-500/10 rounded-xl text-sm font-bold transition-all outline-none text-slate-600">
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-50">
                    <th class="px-8 py-6">Kandidat</th>
                    <th class="px-4 py-6 text-center">S1</th>
                    <th class="px-4 py-6 text-center">S2</th>
                    <th class="px-4 py-6 text-center">S3</th>
                    <th class="px-4 py-6 text-center">S4</th>
                    <th class="px-4 py-6 text-center">S5</th>
                    <th class="px-4 py-6 text-center">AVG</th>
                    <th class="px-6 py-6 text-left">Minat Prodi</th>
                    <th class="px-2 py-6 text-center">Video</th>
                    <th class="px-2 py-6 text-center">IG</th>
                    <th class="px-2 py-6 text-center">TikTok</th>
                    <th class="px-2 py-6 text-center">Twibbon</th>
                    <th class="px-6 py-6 text-center">Berkas</th>
                    <th class="px-6 py-6 text-center">Status</th>
                    <th class="px-8 py-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($pendaftars as $akun)
                @php
                    $peserta = $akun->peserta;
                    $daftar = $peserta->daftar;
                    $berkas = $peserta->berkas;
                    $sertifikats = $peserta->sertifikats;
                    
                    // Hitung kelengkapan (Termasuk buta warna jika DKV)
                    $isDKV = ($peserta->pilihan_prodi ?? '') == 'Desain Komunikasi Visual';
                    
                    // Check logic
                    $filesCheck = ['foto', 'rapor1', 'rapor2', 'rapor3', 'rapor4', 'rapor5', 'ijazah', 'motivasi_video', 'personal_statement'];
                    if($isDKV) {
                        $filesCheck[] = 'surat_buta_warna';
                    }
                    
                    $uploaded = 0;
                    $totalRequired = count($filesCheck);
                    
                    if($berkas) {
                        foreach($filesCheck as $f) {
                            if(!empty($berkas->$f)) $uploaded++;
                        }
                    }
                    
                    $percentage = $totalRequired > 0 ? round(($uploaded / $totalRequired) * 100) : 0;
                    $percentage = $percentage > 100 ? 100 : $percentage;
                @endphp
                <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 md:px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="relative w-12 h-12 rounded-2xl overflow-hidden shadow-sm border border-slate-100 group-hover:scale-105 transition-transform">
                                @if($berkas && $berkas->foto)
                                    <img src="{{ asset('storage/'.$berkas->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($akun->nama) }}&background=random&color=fff" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">{{ $akun->nama }}</div>
                                <div class="text-[10px] font-bold text-slate-400 mt-0.5 uppercase tracking-wide">{{ $peserta->nama_sekolah ?? $peserta?->nama_sekolah ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <!-- Semester Averages -->
                    @for($sem = 1; $sem <= 5; $sem++)
                    <td class="px-4 py-5 text-center">
                        @php
                            $avgSem = $daftar->{"avg_semester_{$sem}"} ?? 0;
                            $colorClass = $avgSem >= 90 ? 'bg-green-100 text-green-700' : 
                                         ($avgSem >= 80 ? 'bg-blue-100 text-blue-700' : 
                                         ($avgSem >= 70 ? 'bg-yellow-100 text-yellow-700' : 'bg-slate-100 text-slate-600'));
                        @endphp
                        <span class="inline-block px-2 py-1 {{ $colorClass }} rounded-lg text-[11px] font-black">
                            {{ number_format($avgSem, 1) }}
                        </span>
                    </td>
                    @endfor
                    <!-- Overall Average -->
                    <td class="px-4 py-5 text-center">
                        <span class="inline-block px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-black border border-orange-200">
                            {{ number_format($daftar->rata_rata_nilai ?? 0, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="font-bold text-slate-800 text-xs">{{ $peserta->pilihan_prodi ?? '-' }}</div>
                        @if($isDKV)
                            <div class="mt-1 flex items-center gap-1.5">
                                @if(!empty($berkas->surat_buta_warna))
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-md text-[9px] font-black flex items-center gap-1">
                                        <span class="iconify" data-icon="solar:eye-bold"></span> Buta Warna OK
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-red-100 text-red-600 rounded-md text-[9px] font-black flex items-center gap-1">
                                        <span class="iconify" data-icon="solar:close-circle-bold"></span> Buta Warna Missing
                                    </span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <!-- Video Motivation -->
                    <td class="px-2 py-5 text-center">
                        @if($berkas && $berkas->motivasi_video)
                            <a href="{{ $berkas->motivasi_video }}" target="_blank" class="w-8 h-8 inline-flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-600 hover:text-white transition-all shadow-sm" title="Video Motivasi">
                                <span class="iconify" data-icon="solar:videocamera-bold"></span>
                            </a>
                        @else
                            <span class="text-slate-200">-</span>
                        @endif
                    </td>
                    <!-- Instagram -->
                    <td class="px-2 py-5 text-center">
                        @if($peserta->link_ig)
                            <a href="{{ $peserta->link_ig }}" target="_blank" class="w-8 h-8 inline-flex items-center justify-center bg-orange-100 text-orange-600 rounded-lg hover:bg-orange-600 hover:text-white transition-all shadow-sm" title="Instagram">
                                <span class="iconify" data-icon="solar:gallery-bold"></span>
                            </a>
                        @else
                            <span class="text-slate-200">-</span>
                        @endif
                    </td>
                    <!-- TikTok -->
                    <td class="px-2 py-5 text-center">
                        @if($peserta->link_tiktok)
                            <a href="{{ $peserta->link_tiktok }}" target="_blank" class="w-8 h-8 inline-flex items-center justify-center bg-slate-100 text-slate-800 rounded-lg hover:bg-slate-900 hover:text-white transition-all shadow-sm" title="TikTok">
                                <span class="iconify" data-icon="solar:music-note-bold"></span>
                            </a>
                        @else
                            <span class="text-slate-200">-</span>
                        @endif
                    </td>
                    <!-- Twibbon -->
                    <td class="px-2 py-5 text-center">
                        @if($peserta->link_twibbon)
                            <a href="{{ $peserta->link_twibbon }}" target="_blank" class="w-8 h-8 inline-flex items-center justify-center bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-600 hover:text-white transition-all shadow-sm" title="Twibbon">
                                <span class="iconify" data-icon="solar:camera-bold"></span>
                            </a>
                        @else
                            <span class="text-slate-200">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-wrap gap-1 max-w-[120px] mx-auto">
                            <!-- Foto -->
                            <span class="px-1.5 py-0.5 rounded text-[8px] font-black {{ ($berkas && $berkas->foto) ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-slate-50 text-slate-300 border border-slate-100' }}">FOTO</span>
                            
                            <!-- Ijazah -->
                            <span class="px-1.5 py-0.5 rounded text-[8px] font-black {{ ($berkas && $berkas->ijazah) ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-slate-50 text-slate-300 border border-slate-100' }}">IJAZAH</span>
                            
                            <!-- PS -->
                            <span class="px-1.5 py-0.5 rounded text-[8px] font-black {{ ($berkas && $berkas->personal_statement) ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-slate-50 text-slate-300 border border-slate-100' }}">PS</span>
                            
                            <!-- Rapor -->
                            @php
                                $raporCount = 0;
                                foreach(['rapor1','rapor2','rapor3','rapor4','rapor5'] as $r) {
                                    if($berkas && !empty($berkas->$r)) $raporCount++;
                                }
                            @endphp
                            <span class="px-1.5 py-0.5 rounded text-[8px] font-black {{ $raporCount == 5 ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : ($raporCount > 0 ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-slate-50 text-slate-300 border border-slate-100') }}">
                                RAPOR({{ $raporCount }}/5)
                            </span>

                            <!-- Sertifikat -->
                            <span class="px-1.5 py-0.5 rounded text-[8px] font-black {{ $sertifikats->count() > 0 ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'bg-slate-50 text-slate-400 border border-slate-100' }}">
                                SRT({{ $sertifikats->count() }})
                            </span>

                            @if($isDKV)
                                <span class="px-1.5 py-0.5 rounded text-[8px] font-black {{ !empty($berkas->surat_buta_warna) ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-red-100 text-red-600 border border-red-200' }}">
                                    BW
                                </span>
                            @endif
                        </div>
                        <div class="text-[8px] text-slate-400 mt-2 text-center font-bold uppercase tracking-tighter">{{ $percentage }}% DONE</div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if(($daftar->status ?? 'menunggu') == 'lulus')
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-wide border border-emerald-100">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Lulus
                            </span>
                        @elseif(($daftar->status ?? 'menunggu') == 'tidak_lulus')
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-black uppercase tracking-wide border border-red-100">
                                Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-black uppercase tracking-wide border border-orange-100">
                                Menunggu
                            </span>
                        @endif
                    </td>
                    <td class="px-4 md:px-8 py-5 text-right">
                         <div class="flex items-center justify-end gap-2 transition-opacity md:opacity-0 md:group-hover:opacity-100">
                             @if(auth()->user()->role === 'admin' || in_array(auth()->user()->email, ['dept.adminis@mfls.com', 'info@beasiswamncu.com']))
                             <button type="button" onclick="confirmResetPassword({{ $akun->id }}, '{{ $akun->nama }}')" class="w-9 h-9 flex items-center justify-center bg-yellow-50 text-yellow-600 rounded-xl hover:bg-yellow-500 hover:text-white transition-all shadow-sm border border-yellow-100" title="Reset Password">
                                <span class="iconify" data-icon="solar:key-minimalistic-bold-duotone"></span>
                             </button>
                             <form action="{{ route('admin.pendaftar.destroy', $akun->id) }}" method="POST"
                                   onsubmit="return confirm('Yakin ingin menghapus peserta {{ $akun->nama }} beserta seluruh berkas dan nilainya? Tindakan ini tidak dapat dibatalkan!');"
                                   class="inline-block">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-100" title="Hapus Akun Peserta">
                                     <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                 </button>
                             </form>
                             @endif
                             <a href="{{ route('admin.pendaftar.download_zip', $akun->id) }}" class="w-9 h-9 flex items-center justify-center bg-slate-50 text-slate-600 rounded-xl hover:bg-slate-800 hover:text-white transition-all shadow-sm border border-slate-100" title="Download ZIP">
                                <span class="iconify" data-icon="solar:folder-with-files-bold"></span>
                            </a>
                            <form action="{{ route('admin.pendaftar.send_certificate', $akun->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Kirim sertifikat ke email {{ $akun->email }}?')" class="w-9 h-9 flex items-center justify-center bg-orange-50 text-orange-600 rounded-xl hover:bg-orange-500 hover:text-white transition-all shadow-sm border border-orange-100" title="Kirim Sertifikat via Email">
                                    <span class="iconify text-lg" data-icon="solar:letter-send-bold"></span>
                                </button>
                            </form>
                            <a href="{{ route('admin.pendaftar.show', $akun->id) }}" class="h-9 px-4 bg-blue-600 text-white rounded-xl text-[10px] font-black hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/20 flex items-center gap-2 border border-blue-500">
                                <span>VERIFIKASI</span>
                                <span class="iconify" data-icon="solar:pen-new-square-bold"></span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(count($pendaftars) == 0)
    <div class="p-10 text-center text-slate-400">
        <p class="text-sm font-bold">Belum ada data pendaftar.</p>
    </div>
    @endif
</div>
@if(auth()->user()->role === 'admin' || in_array(auth()->user()->email, ['dept.adminis@mfls.com', 'info@beasiswamncu.com']))
<form id="resetPasswordForm" method="POST" style="display:none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="password" id="resetPasswordInput">
</form>

<script>
function confirmResetPassword(userId, name) {
    Swal.fire({
        title: 'Konfirmasi Reset',
        text: `Apakah Anda benar-benar ingin mereset password untuk ${name}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f97316',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Reset Password',
                text: `Masukkan password baru untuk ${name}:`,
                input: 'password',
                inputPlaceholder: 'Minimal 6 karakter',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Reset Sekarang',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#f97316',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    if (!password || password.length < 6) {
                        Swal.showValidationMessage('Password minimal 6 karakter');
                        return false;
                    }
                    return password;
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((inputResult) => {
                if (inputResult.isConfirmed) {
                    const form = document.getElementById('resetPasswordForm');
                    form.action = `/admin/user/${userId}/reset-password`;
                    document.getElementById('resetPasswordInput').value = inputResult.value;
                    form.submit();
                }
            });
        }
    });
}
</script>
@endif
@endsection
