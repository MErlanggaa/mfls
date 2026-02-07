@extends('layouts.admin')

@push('styles')
<style>
    @media print {
        /* Hide all UI elements */
        aside, header, nav, .flex.gap-2, a[href*="index"], button, .no-print {
            display: none !important;
        }

        /* Essential Reset */
        main {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background: white !important;
        }

        body {
            background: white !important;
            font-family: 'Times New Roman', serif; /* Classic formal look for print */
            color: black !important;
        }

        /* Report Header Styling */
        .grid { display: block !important; }
        .lg\:col-span-2, .space-y-8, .space-y-6, .space-y-4 { width: 100% !important; }

        /* Card conversions for print */
        .bg-white, .bg-slate-50, .bg-blue-50, .bg-emerald-50, .bg-dark-navy, .bg-orange-50 {
            background-color: transparent !important;
            border: 1px solid #ccc !important;
            border-radius: 8px !important;
            padding: 15px !important;
            margin-bottom: 15px !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }

        /* Color preservation for important text */
        .text-blue-600, .text-emerald-600, .text-orange-600, .text-slate-800, .text-slate-900 {
            color: black !important;
            font-weight: bold !important;
        }

        /* Photo sizing for print */
        .w-32.h-40 {
            width: 2.5cm !important;
            height: 3.5cm !important;
            border: 1px solid black !important;
        }

        /* Score boxes */
        .p-4.bg-slate-50, .p-4.bg-blue-50, .p-4.bg-emerald-50 {
            display: inline-block !important;
            width: 30% !important;
            margin-right: 2% !important;
            border: 1px solid #ddd !important;
        }

        /* Hidden decisions form in print, only show summary */
        form { display: none !important; }
        .decision-summary-print { display: block !important; }

        .page-break { page-break-before: always; }
        
        /* Signature Area */
        .print-only { display: block !important; }
        
        /* Official Header */
        .official-header {
            display: flex !important;
            align-items: center;
            justify-content: center;
            border-bottom: 3px double black;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
    }

    /* Web view styles for the signature and header (hidden by default) */
    .print-only, .official-header, .decision-summary-print { display: none; }

</style>
@endpush

@section('content')
<!-- Official Print Header -->
<div class="official-header flex-col text-center">
    <h1 class="text-2xl font-bold">MNC UNIVERSITY</h1>
    <h2 class="text-lg font-bold">FUTURE LEADER SCHOLARSHIP (MFLS) 2026</h2>
    <p class="text-sm">Jln. Panjang No. 37, Kedoya Utara, Kebon Jeruk, Jakarta Barat</p>
    <div class="mt-4 border-t-2 border-black w-full"></div>
    <h3 class="mt-4 text-xl font-black underline uppercase">LAPORAN HASIL SELEKSI FINAL</h3>
</div>

<div class="mb-8 flex items-center justify-between no-print">
    <div>
        <h2 class="text-2xl font-black text-slate-800">Master Report Beasiswa</h2>
        <p class="text-slate-500">Rekapitulasi Final: {{ $user->nama }}</p>
    </div>
    <div class="flex gap-2">
        <button onclick="window.print()" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest flex items-center gap-2">
            <span class="iconify" data-icon="solar:printer-bold"></span> Cetak Laporan
        </button>
        <a href="{{ route('admin.beasiswa.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-2xl text-xs font-black shadow-lg hover:bg-blue-700 transition-all uppercase tracking-widest flex items-center gap-2">
            <span class="iconify" data-icon="solar:arrow-left-bold"></span> Kembali Ke Database
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Utama: Data Detail -->
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
                        <span class="text-slate-300 font-bold">•</span>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-[10px] font-black uppercase tracking-widest italic">REF: {{ $user->peserta->daftar->kode_referral ?? 'TANPA KODE' }}</span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-slate-50">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Rata-Rata Akademik</label>
                    <div class="text-xl font-black text-slate-800">{{ number_format($rataRataAkademik, 2) }}</div>
                </div>
                <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                    <label class="block text-[8px] font-black text-blue-400 uppercase tracking-widest mb-1">Evaluasi Mentor</label>
                    <div class="text-xl font-black text-blue-600">{{ number_format($rataRataMentor, 2) }}</div>
                </div>
                <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <label class="block text-[8px] font-black text-emerald-400 uppercase tracking-widest mb-1">Status Berkas</label>
                    <div class="text-xs font-black text-emerald-600 uppercase">Verifikasi Selesai</div>
                </div>
            </div>
        </div>

        <!-- 2. CATATAN MENTOR (Penting!) -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center">
                    <span class="iconify text-2xl" data-icon="solar:user-id-bold"></span>
                </span>
                Evaluasi Kualitatif Mentor
            </h3>
            
            <div class="space-y-6">
                @forelse($user->peserta->penilaianMentors as $eval)
                    <div class="p-8 bg-slate-50 rounded-[2rem] border border-slate-200 relative">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-blue-600 shadow-sm border border-slate-100 text-sm">
                                    {{ substr($eval->mentor->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-800">{{ $eval->mentor->nama }}</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Penilai Aktif</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-black text-blue-600">{{ number_format($eval->nilai, 2) }}</div>
                                <div class="text-[8px] font-black text-slate-400 uppercase tracking-tighter">Total Score</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <div class="bg-white p-3 rounded-xl border border-slate-100 text-center">
                                <div class="text-[7px] font-black text-slate-400 uppercase mb-1">Kepemimpinan</div>
                                <div class="font-black text-slate-700">{{ round($eval->nilai_kepemimpinan) }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-100 text-center">
                                <div class="text-[7px] font-black text-slate-400 uppercase mb-1">Kepribadian</div>
                                <div class="font-black text-slate-700">{{ round($eval->nilai_kepribadian) }}</div>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-100 text-center">
                                <div class="text-[7px] font-black text-slate-400 uppercase mb-1">Keaktifan</div>
                                <div class="font-black text-slate-700">{{ round($eval->nilai_keaktifan) }}</div>
                            </div>
                        </div>

                        <div class="relative">
                            <span class="absolute -top-4 -left-2 text-4xl text-blue-200 opacity-50 font-serif">“</span>
                            <p class="text-sm font-medium text-slate-600 italic leading-relaxed pl-4">
                                {{ $eval->catatan ?: 'Tidak ada catatan tertulis dari mentor ini.' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="py-12 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] text-center text-slate-400 font-bold italic">
                        Belum ada evaluasi dari mentor untuk peserta ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 3. Rincian Akademik (Summary) -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <span class="iconify text-2xl" data-icon="solar:book-bold"></span>
                </span>
                Summary Akademik
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-center">
                    <thead>
                        <tr class="text-slate-400 font-black uppercase tracking-widest border-b border-slate-50">
                            <th class="py-4 text-left">Mata Pelajaran</th>
                            <th class="py-4">Rata-Rata S1-S6</th>
                            <th class="py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($user->peserta->nilais->pluck('matpel')->unique('id') as $mp)
                        @php
                            $avgMp = $user->peserta->nilais->where('matpel_id', $mp->id)->avg('nilai');
                        @endphp
                        <tr>
                            <td class="py-4 text-left font-black text-slate-700 uppercase tracking-tighter">{{ $mp->nama }}</td>
                            <td class="py-4 font-black text-slate-800 text-lg">{{ number_format($avgMp, 2) }}</td>
                            <td class="py-4">
                                @if($avgMp >= 90) <span class="text-green-500 font-black">EXCELLENT</span>
                                @elseif($avgMp >= 80) <span class="text-blue-500 font-black">GOOD</span>
                                @else <span class="text-slate-400 font-bold tracking-widest">AVERAGE</span> @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Hasil Ujian (Baru!) -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <span class="iconify text-2xl" data-icon="solar:pen-new-square-bold"></span>
                </span>
                Hasil Seleksi Online
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($user->peserta->nilaiUjians as $ujian)
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex justify-between items-center">
                    <div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $ujian->ujian->nama }}</div>
                        <div class="text-[14px] font-black text-slate-700 uppercase">Nilai Asli: {{ $ujian->skor_asli }} <span class="text-[10px] font-bold text-slate-400">POIN</span></div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase">{{ $ujian->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-black text-emerald-600">{{ number_format($ujian->skor_rata, 2) }}</div>
                        <div class="text-[8px] font-black text-slate-400 uppercase tracking-tighter">Final Score (100)</div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] text-center text-slate-400 font-bold italic">
                    Belum ada data pengerjaan ujian online.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar: Keputusan Final -->
    <div class="space-y-8">
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full"></div>
            <h3 class="text-lg font-black mb-10 uppercase tracking-[0.2em] text-orange-100">Final Decision</h3>
            
            <form action="{{ route('admin.beasiswa.update', $user->id) }}" method="POST" class="space-y-6 relative">
                @csrf
                <input type="hidden" name="status" value="lulus">
                
                <div class="p-6 bg-white/5 border border-white/10 rounded-[2rem] text-center">
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Eligibility Score</div>
                    <div class="text-5xl font-black text-yellow-400 mb-2">{{ number_format(($rataRataAkademik + $rataRataMentor)/2, 2) }}</div>
                </div>

                <div>
                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Capaian Beasiswa (%)</label>
                    <select name="nominal_beasiswa" class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white outline-none focus:border-yellow-400">
                        <option value="" class="text-slate-800">-- Pilih Persentase --</option>
                        <option value="25%" class="text-slate-800" {{ $user->peserta->daftar->nominal_beasiswa == '25%' ? 'selected' : '' }}>Beasiswa 25%</option>
                        <option value="50%" class="text-slate-800" {{ $user->peserta->daftar->nominal_beasiswa == '50%' ? 'selected' : '' }}>Beasiswa 50%</option>
                        <option value="75%" class="text-slate-800" {{ $user->peserta->daftar->nominal_beasiswa == '75%' ? 'selected' : '' }}>Beasiswa 75%</option>
                        <option value="100%" class="text-slate-800" {{ $user->peserta->daftar->nominal_beasiswa == '100%' ? 'selected' : '' }}>Beasiswa 100% (FULL)</option>
                    </select>
                </div>

                <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl">
                    <p class="text-[9px] font-bold text-emerald-400 text-center uppercase tracking-tighter">Peserta ini otomatis dinyatakan LULUS karena telah melewati seleksi berkas.</p>
                </div>

                <button type="button" onclick="confirmUpdate(this)" class="w-full py-4 bg-yellow-400 text-blue-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-yellow-500 transition-all shadow-lg shadow-yellow-400/20">
                    SIMPAN CAPAIAN BEASISWA
                </button>
            </form>
        </div>

        <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm">
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 italic">Links Berkas & Media</h4>
            <div class="space-y-4">
                @if($user->peserta->link_ig)
                    <a href="{{ $user->peserta->link_ig }}" target="_blank" class="flex items-center gap-3 text-xs font-black text-slate-700 hover:text-blue-600 transition-all uppercase">
                        <span class="iconify" data-icon="solar:camera-bold"></span> Profile Instagram ↗
                    </a>
                @endif
                @if($user->peserta->link_tiktok)
                    <a href="{{ $user->peserta->link_tiktok }}" target="_blank" class="flex items-center gap-3 text-xs font-black text-slate-700 hover:text-blue-600 transition-all uppercase">
                        <span class="iconify" data-icon="solar:music-note-bold"></span> Konten TikTok ↗
                    </a>
                @endif
                @if($user->peserta->berkas && $user->peserta->berkas->motivasi_video)
                    <a href="{{ $user->peserta->berkas->motivasi_video }}" target="_blank" class="flex items-center gap-3 text-xs font-black text-purple-600 uppercase border-t border-slate-50 pt-4">
                        <span class="iconify" data-icon="solar:videocamera-bold"></span> Video Motivasi ↗
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Print Only: Decision Summary & Signature Area -->
<div class="print-only mt-12">
    <div class="bg-white border border-black p-6 rounded-lg mb-10">
        <h3 class="text-lg font-bold border-b border-black pb-2 mb-4 uppercase">Keputusan Panitia Seleksi</h3>
        <div class="grid grid-cols-2 gap-8">
            <div>
                <p class="text-sm">Status Kelulusan: <strong>LULUS SELEKSI</strong></p>
                <p class="text-sm">Capaian Beasiswa: <strong>{{ $user->peserta->daftar->nominal_beasiswa ?? 'Menunggu Keputusan' }}</strong></p>
            </div>
            <div>
                <p class="text-sm">Skor Akhir: <strong>{{ number_format(($rataRataAkademik + $rataRataMentor)/2, 2) }}</strong></p>
                <p class="text-sm">Tanggal Sidang: <strong>{{ date('d F Y') }}</strong></p>
            </div>
        </div>
    </div>

    <div class="flex justify-between mt-20">
        <div class="text-center w-48">
            <p class="text-sm mb-20">Peserta Beasiswa,</p>
            <div class="border-b border-black w-full mb-1"></div>
            <p class="text-sm font-bold">{{ strtoupper($user->nama) }}</p>
        </div>
        <div class="text-center w-64">
            <p class="text-sm mb-20">Jakarta, {{ date('d F Y') }}<br>Ketua Panitia Seleksi MFLS,</p>
            <div class="border-b border-black w-full mb-1"></div>
            <p class="text-sm font-bold">DR. (HC) HARY TANOESOEDIBJO</p>
            <p class="text-[10px]">Chairman MNC Group</p>
        </div>
    </div>
</div>

<script>
function confirmUpdate(button) {
    const nominal = document.querySelector('select[name="nominal_beasiswa"]').value;
    if(!nominal) {
        Swal.fire({
            title: 'Oppss!',
            text: 'Harap pilih persentase beasiswa terlebih dahulu.',
            icon: 'error',
            confirmButtonColor: '#F97316'
        });
        return;
    }

    Swal.fire({
        title: 'Simpan Keputusan?',
        text: `Peserta akan diberikan beasiswa sebesar ${nominal}. Data ini akan menjadi acuan pengumuman final.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#F97316',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endsection
