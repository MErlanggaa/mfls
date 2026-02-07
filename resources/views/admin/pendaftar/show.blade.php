@extends('layouts.admin')

@section('content')
<!-- Notifikasi Flash -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-500 text-white rounded-2xl shadow-lg shadow-green-200 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <span class="iconify text-xl" data-icon="solar:check-circle-bold"></span>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
        <span class="iconify" data-icon="solar:close-circle-bold"></span>
    </button>
</div>
@endif

<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-black text-slate-800">Verifikasi Seleksi Administrasi</h2>
        <p class="text-slate-500">Cek Profil, Raport, dan Berkas Peserta: {{ $user->nama }}</p>
    </div>
    <a href="{{ route('admin.pendaftar.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest flex items-center gap-2">
        <span class="iconify" data-icon="solar:arrow-left-bold"></span> Kembali Ke List
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Utama -->
    <div class="lg:col-span-2 space-y-8">
        <!-- 1. Identitas Global dengan Foto 3x4 -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-orange-50/50 rounded-full translate-x-1/2 -translate-y-1/2"></div>
            <div class="flex items-start gap-8 mb-10 relative">
                @php
                    $fotoPath = $user->peserta->berkas->foto ?? null;
                    $fotoUrl = $fotoPath ? asset('storage/' . $fotoPath) : "https://ui-avatars.com/api/?name=".urlencode($user->nama)."&background=F97316&color=fff";
                @endphp
                <!-- Foto 3x4 -->
                <div class="w-32 h-40 rounded-2xl overflow-hidden shadow-xl border-4 border-white ring-2 ring-orange-100 flex-shrink-0">
                    <img src="{{ $fotoUrl }}" class="w-full h-full object-cover" alt="Foto {{ $user->nama }}">
                </div>
                <div class="flex-grow">
                    <h1 class="text-3xl font-black text-slate-900 mb-2">{{ $user->nama }}</h1>
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-orange-100">{{ $user->peserta->nisn }}</span>
                        <span class="text-slate-300 font-bold">•</span>
                        <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">{{ $user->peserta->nama_sekolah }}</span>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Email</label>
                            <div class="text-xs font-bold text-slate-700">{{ $user->email }}</div>
                        </div>
                        <div>
                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">WhatsApp</label>
                            <div class="text-xs font-bold text-slate-700">{{ $user->peserta->no_whatsapp }}</div>
                        </div>
                        <div>
                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Lahir</label>
                            <div class="text-xs font-bold text-slate-700">{{ \Carbon\Carbon::parse($user->peserta->tgl_lahir)->format('d M Y') }}</div>
                        </div>
                        <div>
                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Jenis Kelamin</label>
                            <div class="text-xs font-bold text-slate-700">{{ $user->peserta->jenis_kelamin }}</div>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Program Studi Pilihan</label>
                            <div class="text-xs font-black text-blue-600 uppercase">{{ $user->peserta->pilihan_prodi ?? 'Belum Memilih' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Rincian Raport -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <span class="iconify text-2xl" data-icon="solar:book-bold"></span>
                </span>
                Rincian Nilai Raport
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="text-slate-400 font-black uppercase tracking-widest border-b border-slate-50">
                            <th class="py-4 text-left">Mata Pelajaran</th>
                            @for($i=1;$i<=6;$i++) <th class="py-4 text-center">S{{$i}}</th> @endfor
                            <th class="py-4 text-center bg-slate-50">AVG</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php $totalNilai = 0; $totalCount = 0; @endphp
                        @foreach($user->peserta->nilais->pluck('matpel')->unique('id') as $mp)
                            <tr>
                                <td class="py-4 font-black uppercase">{{ $mp->nama }}</td>
                                @php $mpAvg = 0; $mpCount = 0; @endphp
                                @for($sem=1;$sem<=6;$sem++)
                                    @php 
                                        $val = $user->peserta->nilais->where('matpel_id', $mp->id)->where('semester', $sem)->first()->nilai ?? 0;
                                        if($val > 0) { $mpAvg += $val; $mpCount++; $totalNilai += $val; $totalCount++; }
                                    @endphp
                                    <td class="py-4 text-center font-bold {{ $val > 0 ? 'text-slate-700' : 'text-slate-200' }}">{{ $val > 0 ? $val : '-' }}</td>
                                @endfor
                                <td class="py-4 text-center font-black bg-slate-50 text-blue-600">{{ $mpCount > 0 ? number_format($mpAvg/$mpCount, 1) : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue-600 text-white font-black text-sm">
                            <td colspan="7" class="p-4 text-right rounded-bl-2xl">RATA-RATA GLOBAL (TOTAL SCORE)</td>
                            <td class="p-4 text-center rounded-br-2xl">{{ $totalCount > 0 ? number_format($totalNilai/$totalCount, 2) : '0' }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- 3. Berkas Dokumen -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <span class="iconify text-2xl" data-icon="solar:folder-with-files-bold"></span>
                </span>
                Checklist Berkas Fisik
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $berkasItems = [
                        'foto' => 'Foto 3x4',
                        'rapor1' => 'Raport Smst 1',
                        'rapor2' => 'Raport Smst 2',
                        'rapor3' => 'Raport Smst 3',
                        'rapor4' => 'Raport Smst 4',
                        'rapor5' => 'Raport Smst 5',
                        'ijazah' => 'Ijazah / SKL',
                        'surat_buta_warna' => 'Surat Buta Warna',
                        'personal_statement' => 'Personal Statement'
                    ];
                @endphp
                @foreach($berkasItems as $key => $label)
                @php 
                    $val = $user->peserta->berkas->$key ?? null; 
                    $files = json_decode($val, true);
                    if (!is_array($files)) {
                        $files = $val ? [$val] : [];
                    }
                @endphp
                <div class="p-6 {{ count($files) > 0 ? 'bg-emerald-50 border-emerald-100' : 'bg-slate-50 border-slate-100' }} rounded-3xl border flex flex-col justify-center min-h-[100px]">
                    <div class="flex items-center justify-between w-full mb-3">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $label }}</div>
                        <div class="text-xs font-bold {{ count($files) > 0 ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ count($files) > 0 ? count($files).' FILE' : 'KOSONG' }}
                        </div>
                    </div>
                    
                    @if(count($files) > 0)
                        <div class="flex flex-wrap gap-2">
                        @foreach($files as $idx => $path)
                            <a href="{{ asset('storage/' . $path) }}" target="_blank" class="px-3 py-2 bg-white text-emerald-600 rounded-xl border border-emerald-100 shadow-sm hover:scale-105 transition-all text-[10px] font-black flex items-center gap-1">
                                <span class="iconify" data-icon="solar:document-bold"></span> FILE {{ $idx + 1 }}
                            </a>
                        @endforeach
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-slate-300 font-bold text-xs">
                            <span class="iconify" data-icon="solar:close-circle-bold"></span> Tidak Ada Dokumen
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Sertifikat Terpisah karena Modelnya Berbeda -->
            <div class="mt-8 pt-8 border-t border-slate-50">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="iconify text-lg text-blue-500" data-icon="solar:medal-ribbons-star-bold"></span>
                    Sertifikat & Penghargaan ({{ $user->peserta->sertifikats->count() }})
                </h4>
                <div class="flex flex-wrap gap-3">
                    @forelse($user->peserta->sertifikats as $ser)
                        <a href="{{ asset('storage/' . $ser->file) }}" target="_blank" class="px-5 py-3 bg-blue-50 text-blue-700 rounded-2xl border border-blue-100 shadow-sm hover:scale-105 transition-all text-[11px] font-black flex items-center gap-2">
                            <span class="iconify text-lg" data-icon="solar:diploma-bold"></span>
                            {{ strtoupper($ser->nama) }}
                        </a>
                    @empty
                        <div class="w-full py-6 bg-slate-50 border-2 border-dashed border-slate-100 rounded-[2rem] text-center text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                            Belum ada sertifikat yang diunggah
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Dedicated Links Section -->
            <div class="mt-8 pt-8 border-t border-slate-50">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="iconify text-lg text-purple-500" data-icon="solar:link-bold"></span>
                    Media & Social Media Presence
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Video Motivasi -->
                    <div class="p-5 bg-purple-50 rounded-2xl border border-purple-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-600 text-white rounded-xl flex items-center justify-center">
                                <span class="iconify text-xl" data-icon="solar:videocamera-bold"></span>
                            </div>
                            <div>
                                <div class="text-[8px] font-black text-purple-400 uppercase tracking-widest">Video Motivasi</div>
                                @if($user->peserta->berkas->motivasi_video ?? null)
                                    <a href="{{ $user->peserta->berkas->motivasi_video }}" target="_blank" class="text-xs font-bold text-purple-700 hover:underline flex items-center gap-1">
                                        LINK VIDEO <span class="iconify text-[10px]" data-icon="solar:arrow-right-up-bold"></span>
                                    </a>
                                @else
                                    <div class="text-xs font-bold text-slate-300 italic uppercase">Not Set</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="p-5 bg-orange-50 rounded-2xl border border-orange-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-500 text-white rounded-xl flex items-center justify-center">
                                <span class="iconify text-xl" data-icon="solar:gallery-bold"></span>
                            </div>
                            <div>
                                <div class="text-[8px] font-black text-orange-400 uppercase tracking-widest">Instagram</div>
                                @if($user->peserta->link_ig)
                                    <a href="{{ $user->peserta->link_ig }}" target="_blank" class="text-xs font-bold text-orange-700 hover:underline flex items-center gap-1">
                                        VIEW PROFILE <span class="iconify text-[10px]" data-icon="solar:arrow-right-up-bold"></span>
                                    </a>
                                @else
                                    <div class="text-xs font-bold text-slate-300 italic uppercase">Not Set</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- TikTok -->
                    <div class="p-5 bg-slate-900 rounded-2xl border border-slate-800 flex items-center justify-between text-white">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white text-slate-900 rounded-xl flex items-center justify-center">
                                <span class="iconify text-xl" data-icon="solar:music-note-bold"></span>
                            </div>
                            <div>
                                <div class="text-[8px] font-black text-slate-400 uppercase tracking-widest">TikTok</div>
                                @if($user->peserta->link_tiktok)
                                    <a href="{{ $user->peserta->link_tiktok }}" target="_blank" class="text-xs font-bold text-white hover:underline flex items-center gap-1">
                                        VIEW PROFILE <span class="iconify text-[10px]" data-icon="solar:arrow-right-up-bold"></span>
                                    </a>
                                @else
                                    <div class="text-xs font-bold text-slate-600 italic uppercase">Not Set</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Twibbon -->
                    <div class="p-5 bg-pink-50 rounded-2xl border border-pink-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-pink-500 text-white rounded-xl flex items-center justify-center">
                                <span class="iconify text-xl" data-icon="solar:camera-bold"></span>
                            </div>
                            <div>
                                <div class="text-[8px] font-black text-pink-400 uppercase tracking-widest">Twibbon Link</div>
                                @if($user->peserta->link_twibbon)
                                    <a href="{{ $user->peserta->link_twibbon }}" target="_blank" class="text-xs font-bold text-pink-700 hover:underline flex items-center gap-1">
                                        VIEW IMAGE <span class="iconify text-[10px]" data-icon="solar:arrow-right-up-bold"></span>
                                    </a>
                                @else
                                    <div class="text-xs font-bold text-slate-300 italic uppercase">Not Set</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Verifikasi -->
    <div class="space-y-8">
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full"></div>
            <h3 class="text-lg font-black mb-10 uppercase tracking-[0.2em] text-orange-100">Decision Center</h3>
            
            <div class="mb-10 p-6 bg-white/10 border border-white/20 rounded-[2rem] text-center backdrop-blur-sm">
                <div class="text-[10px] font-black text-orange-100 uppercase tracking-widest mb-2">Administrasi Status</div>
                @if($user->peserta->daftar->status == 'lulus')
                    <div class="text-xl font-black text-white uppercase flex items-center justify-center gap-2">
                        <span class="iconify" data-icon="solar:check-circle-bold"></span> LOLOS BERKAS
                    </div>
                @elseif($user->peserta->daftar->status == 'tidak_lulus')
                    <div class="text-xl font-black text-red-200 uppercase flex items-center justify-center gap-2">
                        <span class="iconify" data-icon="solar:close-circle-bold"></span> DITOLAK
                    </div>
                @else
                    <div class="text-xl font-black text-yellow-200 animate-pulse uppercase flex items-center justify-center gap-2">
                        <span class="iconify" data-icon="solar:clock-circle-bold"></span> PENDING
                    </div>
                @endif
            </div>

            <div class="space-y-4 relative">
                <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="lulus">
                    <button type="button" onclick="confirmVerify(this, 'lulus', '{{ $user->nama }}')" class="w-full py-5 bg-white text-emerald-600 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-emerald-50 transition-all flex items-center justify-center gap-2">
                        <span class="iconify" data-icon="solar:check-circle-bold"></span> Setujui Berkas & Profil
                    </button>
                </form>
                <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="tidak_lulus">
                    <button type="button" onclick="confirmVerify(this, 'tidak_lulus', '{{ $user->nama }}')" class="w-full py-5 bg-white/10 border border-white/20 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-500/20 transition-all flex items-center justify-center gap-2">
                        <span class="iconify" data-icon="solar:close-circle-bold"></span> Tolak / Diskualifikasi
                    </button>
                </form>
                @if(($user->peserta->daftar->status ?? 'menunggu') != 'menunggu')
                <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="menunggu">
                    <button type="button" onclick="confirmVerify(this, 'menunggu', '{{ $user->nama }}')" class="w-full py-5 bg-white/10 text-white rounded-2xl font-black text-[9px] uppercase tracking-widest hover:bg-white/20 transition-all flex items-center justify-center gap-2">
                        <span class="iconify" data-icon="solar:restart-bold"></span> Batalkan Keputusan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function confirmVerify(button, status, name) {
    let title, text, icon, confirmButtonColor;
    if (status === 'lulus') { title = 'Setujui Administrasi?'; text = `Luluskan berkas dan profil ${name}?`; icon = 'success'; confirmButtonColor = '#10b981'; } 
    else if (status === 'tidak_lulus') { title = 'Tolak Administrasi?'; text = `Tolak pendaftaran ${name}?`; icon = 'warning'; confirmButtonColor = '#ef4444'; }
    else { title = 'Reset Keputusan?'; text = `Kembalikan ${name} ke status Menunggu?`; icon = 'info'; confirmButtonColor = '#F97316'; }

    Swal.fire({
        title: title, text: text, icon: icon,
        showCancelButton: true, confirmButtonColor: confirmButtonColor, cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lakukan!', cancelButtonText: 'Batal',
        borderRadius: '2rem',
        customClass: { title: 'font-black', content: 'font-semibold' }
    }).then((result) => { if (result.isConfirmed) { button.closest('form').submit(); } });
}
</script>
@endsection
