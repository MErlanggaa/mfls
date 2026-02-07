@extends('layouts.admin')

@push('styles')
<style>
    @media print {
        @page {
            size: A4;
            margin: 1.5cm;
        }

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
            font-family: 'Times New Roman', serif;
            color: black !important;
            font-size: 9pt;
            line-height: 1.3;
        }

        /* Compact Layout */
        .grid { display: block !important; margin: 0 !important; }
        .lg\:col-span-2, .space-y-8, .space-y-6, .space-y-4 { width: 100% !important; margin: 0 !important; }

        .section-box {
            background-color: transparent !important;
            border: 1px solid #000 !important;
            border-radius: 0 !important;
            padding: 10px !important;
            margin-bottom: 15px !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }

        h3 { 
            font-size: 10pt !important; 
            margin-bottom: 8px !important;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            font-weight: bold;
            text-transform: uppercase;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 8pt !important;
        }
        
        table th, table td {
            border: 1px solid #000 !important;
            padding: 4px !important;
        }

        .bg-slate-50, .bg-blue-50, .bg-emerald-50, .bg-orange-50, .bg-slate-50, .bg-white {
            background: transparent !important;
        }

        .text-blue-600, .text-orange-600, .text-emerald-600, .text-yellow-400 {
            color: black !important;
        }

        form { display: none !important; }
        .print-only { display: block !important; }
        
        .official-header {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            border-bottom: 3px double black;
            padding-bottom: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
    }

    .print-only { display: none; }
</style>
@endpush

@section('content')
<!-- Official Print Header -->
<div class="official-header hidden flex-col text-center">
    <div class="mb-2">
        <h1 class="text-2xl font-black">MNC UNIVERSITY</h1>
        <p class="text-[10px] font-bold">FUTURE LEADER SCHOLARSHIP (MFLS) 2026</p>
        <p class="text-[9px]">Kompleks MNC Studios, Jl. Perjuangan, Kebon Jeruk, Jakarta Barat</p>
    </div>
    <div class="border-t-2 border-black w-full mb-1"></div>
    <div class="border-t border-black w-full mb-4"></div>
    <h3 class="text-lg font-black underline uppercase">REKAPITULASI HASIL SELEKSI FINAL BEASISWA</h3>
</div>

<div class="mb-8 flex items-center justify-between no-print">
    <div>
        <h2 class="text-2xl font-black text-slate-800">Master Report Beasiswa</h2>
        <p class="text-slate-500 font-medium">Rekapitulasi Data & Penilaian: {{ $user->nama }}</p>
    </div>
    <div class="flex gap-3">
        <button onclick="window.print()" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black shadow-xl shadow-slate-200 hover:scale-105 transition-all uppercase tracking-[0.2em] flex items-center gap-2">
            <span class="iconify" data-icon="solar:printer-bold"></span> Cetak PDF / Laporan
        </button>
        <a href="{{ route('admin.beasiswa.index') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-700 rounded-2xl text-[10px] font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-[0.2em] flex items-center gap-2">
            <span class="iconify" data-icon="solar:arrow-left-bold"></span> Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <!-- 1. Identitas Global -->
        <div class="section-box bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex gap-8 items-center">
            @php
                $fotoPath = $user->peserta->berkas->foto ?? null;
                $fotoUrl = $fotoPath ? asset('storage/' . $fotoPath) : "https://ui-avatars.com/api/?name=".urlencode($user->nama)."&background=0F172A&color=fff";
            @endphp
            <div class="w-28 h-36 rounded-2xl overflow-hidden shadow-xl border-4 border-white ring-1 ring-slate-100 flex-shrink-0">
                <img src="{{ $fotoUrl }}" class="w-full h-full object-cover" alt="Foto">
            </div>
            <div class="flex-grow">
                <h1 class="text-2xl font-black text-slate-900 mb-1 uppercase tracking-tight">{{ $user->nama }}</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-4">{{ $user->peserta->nama_sekolah }} | NISN: {{ $user->peserta->nisn }}</p>
                
                <div class="grid grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-[8px] font-black text-slate-400 uppercase mb-1">Rata Raport</div>
                        <div class="text-sm font-black text-slate-800">{{ number_format($rataRataAkademik, 2) }}</div>
                    </div>
                    <div class="text-center p-3 bg-blue-50/50 rounded-2xl border border-blue-100">
                        <div class="text-[8px] font-black text-blue-400 uppercase mb-1">Skor Mentor</div>
                        <div class="text-sm font-black text-blue-600">{{ number_format($rataRataMentor, 2) }}</div>
                    </div>
                    <div class="text-center p-3 bg-orange-50/50 rounded-2xl border border-orange-100">
                        <div class="text-[8px] font-black text-orange-400 uppercase mb-1">Interview</div>
                        <div class="text-sm font-black text-orange-600">{{ number_format($rataRataAkademikFinal, 2) }}</div>
                    </div>
                    @php $ujianAvg = $user->peserta->nilaiUjians->avg('skor_rata') ?? 0; @endphp
                    <div class="text-center p-3 bg-emerald-50/50 rounded-2xl border border-emerald-100">
                        <div class="text-[8px] font-black text-emerald-400 uppercase mb-1">Skor CBT</div>
                        <div class="text-sm font-black text-emerald-600">{{ number_format($ujianAvg, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Rincian Nilai Raport -->
        <div class="section-box bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <h3 class="text-sm font-black text-slate-800 mb-6 uppercase tracking-widest flex items-center gap-3">
                <span class="iconify text-xl text-blue-600" data-icon="solar:notebook-bold"></span>
                Rincian Nilai Raport (Semester 1-5)
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-100">
                            <th class="p-3 text-left font-black uppercase text-slate-400">Mata Pelajaran</th>
                            <th class="p-3 text-center font-black uppercase text-slate-400">S1</th>
                            <th class="p-3 text-center font-black uppercase text-slate-400">S2</th>
                            <th class="p-3 text-center font-black uppercase text-slate-400">S3</th>
                            <th class="p-3 text-center font-black uppercase text-slate-400">S4</th>
                            <th class="p-3 text-center font-black uppercase text-slate-400">S5</th>
                            <th class="p-3 text-center font-black uppercase text-slate-700 bg-slate-100">AVG</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($user->peserta->nilais->pluck('matpel')->unique('id') as $mp)
                        <tr>
                            <td class="p-3 font-bold text-slate-700 uppercase">{{ $mp->nama }}</td>
                            @php $mpSum = 0; $mpCount = 0; @endphp
                            @for($s=1;$s<=5;$s++)
                                @php 
                                    $n = $user->peserta->nilais->where('matpel_id', $mp->id)->where('semester', $s)->first()->nilai ?? 0;
                                    if($n > 0) { $mpSum += $n; $mpCount++; }
                                @endphp
                                <td class="p-3 text-center font-medium {{ $n > 0 ? 'text-slate-600' : 'text-slate-200' }}">{{ $n > 0 ? $n : '-' }}</td>
                            @endfor
                            <td class="p-3 text-center font-black bg-slate-50 text-blue-600">{{ $mpCount > 0 ? number_format($mpSum/$mpCount, 1) : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Review Interview Detail -->
        <div class="section-box bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <h3 class="text-sm font-black text-slate-800 mb-6 uppercase tracking-widest text-center">Rekapitulasi Penilaian Interview</h3>
            
            @foreach($user->peserta->penilaianAkademiks as $eval)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Dosen -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b-2 border-orange-50 pb-2">
                        <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest">I. Penilaian Prodi (Dosen)</span>
                        <div class="px-3 py-1 bg-orange-500 text-white text-[10px] font-black rounded-lg">SUBTOTAL: {{ number_format($eval->total_dosen, 2) }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-[10px]">
                        <div class="flex justify-between p-2 bg-slate-50 rounded-xl"><span>Kompetensi</span><span class="font-black">{{ $eval->dosen_kompetensi }}</span></div>
                        <div class="flex justify-between p-2 bg-slate-50 rounded-xl"><span>Motivasi</span><span class="font-black">{{ $eval->dosen_motivasi }}</span></div>
                        <div class="flex justify-between p-2 bg-slate-50 rounded-xl"><span>Wawasan</span><span class="font-black">{{ $eval->dosen_wawasan }}</span></div>
                        <div class="flex justify-between p-2 bg-slate-50 rounded-xl"><span>Karir</span><span class="font-black">{{ $eval->dosen_karir }}</span></div>
                        <div class="col-span-2 flex justify-between p-2 bg-slate-50 rounded-xl"><span>Integritas</span><span class="font-black">{{ $eval->dosen_integritas }}</span></div>
                    </div>
                </div>

                <!-- Mhs -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b-2 border-blue-50 pb-2">
                        <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">II. Penilaian Kemahasiswaan</span>
                        <div class="px-3 py-1 bg-blue-500 text-white text-[10px] font-black rounded-lg">SUBTOTAL: {{ number_format($eval->total_mhs, 2) }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-[10px]">
                        <div class="flex justify-between p-2 bg-slate-50 rounded-xl"><span>Leadership</span><span class="font-black">{{ $eval->mhs_leadership }}</span></div>
                        <div class="flex justify-between p-2 bg-slate-50 rounded-xl"><span>Organisasi</span><span class="font-black">{{ $eval->mhs_organisasi }}</span></div>
                        <div class="flex justify-between p-2 bg-slate-50 rounded-xl"><span>Etika</span><span class="font-black">{{ $eval->mhs_etika }}</span></div>
                        <div class="flex justify-between p-2 bg-slate-50 rounded-xl"><span>Adaptasi</span><span class="font-black">{{ $eval->mhs_adaptasi }}</span></div>
                        <div class="col-span-2 flex justify-between p-2 bg-slate-50 rounded-xl"><span>Komitmen</span><span class="font-black">{{ $eval->mhs_komitmen }}</span></div>
                    </div>
                </div>
            </div>
            <div class="mt-6 p-4 bg-slate-100 rounded-2xl flex justify-between items-center text-slate-800">
                <span class="text-[10px] font-black uppercase tracking-widest">Catatan Wawancara:</span>
                <span class="text-xs font-semibold italic">"{{ $eval->catatan ?: '-' }}"</span>
            </div>
            @endforeach
        </div>

        <div class="section-box bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <h3 class="text-sm font-black text-slate-800 mb-4 uppercase tracking-widest">Kesimpulan Evaluasi Mentor</h3>
            <div class="space-y-3">
                @forelse($user->peserta->penilaianMentors as $eval)
                <div class="p-4 bg-slate-50 rounded-2xl flex gap-4 items-start">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center font-black text-[10px] flex-shrink-0">M</div>
                    <div>
                        <p class="text-[10px] font-black text-blue-600 uppercase mb-1">{{ $eval->mentor->nama }} <span class="text-slate-400 ml-2">({{ number_format($eval->nilai, 2) }})</span></p>
                        <p class="text-xs text-slate-600 font-medium italic">"{{ $eval->catatan ?: 'Penilaian kuantitatif.' }}"</p>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400 font-bold italic">Belum ada evaluasi mentor.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Sidebar / Action -->
    <div class="space-y-6">
        <div class="no-print bg-slate-900 p-8 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-400/10 rounded-full translate-x-12 -translate-y-12"></div>
            
            <h3 class="text-[10px] font-black mb-8 uppercase tracking-[0.3em] text-slate-500 border-none">Panel Keputusan Final</h3>
            <form action="{{ route('admin.beasiswa.update', $user->id) }}" method="POST" class="space-y-6 relative">
                @csrf
                <input type="hidden" name="status" value="lulus">
                
                <div class="p-6 bg-white/5 border border-white/10 rounded-[2rem] text-center backdrop-blur-md">
                    <div class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">Final Weighted Eligibility</div>
                    @php
                        $finalScore = ($rataRataAkademik + $rataRataMentor + $rataRataAkademikFinal + $ujianAvg) / 4;
                    @endphp
                    <div class="text-5xl font-black text-yellow-400">{{ number_format($finalScore, 2) }}</div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-2">Grant Scheme</label>
                    <select name="nominal_beasiswa" required class="w-full bg-slate-800 border border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-white outline-none focus:border-yellow-400 appearance-none shadow-sm">
                        <option value="">-- Pilih Skema --</option>
                        <option value="25%" {{ $user->peserta->daftar->nominal_beasiswa == '25%' ? 'selected' : '' }}>Scholarship 25% (Silver)</option>
                        <option value="50%" {{ $user->peserta->daftar->nominal_beasiswa == '50%' ? 'selected' : '' }}>Scholarship 50% (Gold)</option>
                        <option value="75%" {{ $user->peserta->daftar->nominal_beasiswa == '75%' ? 'selected' : '' }}>Scholarship 75% (Platinum)</option>
                        <option value="100%" {{ $user->peserta->daftar->nominal_beasiswa == '100%' ? 'selected' : '' }}>Scholarship 100% (Diamond)</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-5 bg-yellow-400 text-slate-900 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-white hover:scale-105 active:scale-95 transition-all shadow-xl shadow-yellow-400/20">
                    SIMPAN HASIL SELEKSI
                </button>
            </form>
        </div>

        <div class="preview-decision print-only section-box bg-white p-6 rounded-2xl border-2 border-slate-900">
            <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Official Result Summary</h4>
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-[10px] font-bold text-slate-500">Skor Gabungan Akhir:</span>
                    <span class="text-xs font-black">{{ number_format($finalScore, 2) }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-[10px] font-bold text-slate-500">Kapasitas Beasiswa:</span>
                    <span class="text-xs font-black text-blue-600">{{ $user->peserta->daftar->nominal_beasiswa ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[10px] font-bold text-slate-500">Status Seleksi:</span>
                    <span class="text-xs font-black text-emerald-600 uppercase tracking-wider">Lulus Seleksi Final</span>
                </div>
            </div>
        </div>

        <div class="no-print bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Verification Resources</h4>
            <div class="space-y-4">
                @if($user->peserta->link_ig)
                    <a href="{{ $user->peserta->link_ig }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl group transition-all hover:bg-blue-50">
                        <span class="text-[10px] font-black text-slate-600 group-hover:text-blue-600 uppercase">Instagram Portfolio</span>
                        <span class="iconify" data-icon="solar:arrow-right-up-bold"></span>
                    </a>
                @endif
                @if($user->peserta->berkas && $user->peserta->berkas->motivasi_video)
                    <a href="{{ $user->peserta->berkas->motivasi_video }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl group transition-all hover:bg-purple-50">
                        <span class="text-[10px] font-black text-purple-600 uppercase">Pitch Deck / Video</span>
                        <span class="iconify" data-icon="solar:videocamera-bold"></span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Print Footer & Signature -->
<div class="print-only mt-12 px-10">
    <div class="flex justify-between items-end">
        <div class="text-center w-48">
            <p class="text-[9pt] mb-20 italic">Peserta Seleksi MFLS 2026,</p>
            <div class="border-b border-black w-full mb-1"></div>
            <p class="text-[9pt] font-bold uppercase">{{ $user->nama }}</p>
        </div>
        <div class="text-center w-64">
            <p class="text-[9pt] mb-20">Jakarta, {{ date('d F Y') }}<br>Mengetahui,<br>Panitia Beasiswa MFLS 2026</p>
            <div class="border-b border-black w-full mb-1"></div>
            <p class="text-[9pt] font-bold uppercase">MNC UNIVERSITY ADMISSION TEAM</p>
        </div>
    </div>
</div>
@endsection
