@extends('layouts.admin')

@push('styles')
<style>
    @media print {
        /* Sembunyikan Sidebar dan Elemen UI */
        aside, header, nav, .flex.gap-2, a[href*="index"], button {
            display: none !important;
        }

        /* Reset Layout ke Full Width */
        main {
            margin-left: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        body {
            background: white !important;
            font-size: 12pt !important;
        }

        /* Rapihkan Kontainer */
        .grid {
            display: block !important;
        }
        
        .lg\:col-span-2, .space-y-8, .space-y-6 {
            width: 100% !important;
        }

        .bg-white, .bg-slate-50, .bg-blue-50, .bg-emerald-50, .bg-dark-navy {
            background-color: white !important;
            color: black !important;
            border: 1px solid #eee !important;
            box-shadow: none !important;
            border-radius: 1rem !important;
            padding: 20px !important;
            margin-bottom: 20px !important;
        }

        .text-white, .text-slate-400, .text-blue-600, .text-emerald-600 {
            color: black !important;
        }

        /* Paksa Page Break jika perlu */
        .page-break {
            page-break-before: always;
        }

        /* Khusus Header Raport agar tetap di atas */
        h2, p.text-gray-500 {
            display: block !important;
            text-align: center;
            margin-bottom: 30px;
        }
    }
</style>
@endpush

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Master Report Beasiswa</h2>
        <p class="text-gray-500">Rekapitulasi Final: {{ $user->nama }}</p>
    </div>
    <div class="flex gap-2">
        <button onclick="window.print()" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest flex items-center gap-2">
            <span>🖨️</span> Cetak Laporan
        </button>
        <a href="{{ route('admin.beasiswa.index') }}" class="px-6 py-3 bg-dark-navy text-white rounded-2xl text-xs font-black shadow-lg hover:bg-black transition-all uppercase tracking-widest">
            Kembali Ke Database
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Utama: Data Detail -->
    <div class="lg:col-span-2 space-y-8">
        <!-- 1. Identitas Global -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50/50 rounded-full translate-x-1/2 -translate-y-1/2"></div>
            <div class="flex items-center gap-8 mb-10 relative">
                <div class="w-24 h-24 bg-blue-600 text-white rounded-[1.5rem] flex items-center justify-center text-4xl font-black shadow-xl">
                    {{ substr($user->nama, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 mb-1">{{ $user->nama }}</h1>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $user->peserta->nisn }}</span>
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
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center text-xl">👨‍🏫</span>
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
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl">📚</span>
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
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">📝</span>
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
        <div class="bg-dark-navy p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full"></div>
            <h3 class="text-lg font-black mb-10 uppercase tracking-[0.2em] text-slate-400">Final Decision</h3>
            
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

                <button type="submit" class="w-full py-4 bg-yellow-400 text-blue-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-yellow-500 transition-all shadow-lg shadow-yellow-400/20">
                    SIMPAN CAPAIAN BEASISWA
                </button>
            </form>
        </div>

        <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm">
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 italic">Links Berkas & Media</h4>
            <div class="space-y-4">
                @if($user->peserta->link_ig)
                    <a href="{{ $user->peserta->link_ig }}" target="_blank" class="flex items-center gap-3 text-xs font-black text-slate-700 hover:text-blue-600 transition-all uppercase">📸 Profile Instagram ↗</a>
                @endif
                @if($user->peserta->link_tiktok)
                    <a href="{{ $user->peserta->link_tiktok }}" target="_blank" class="flex items-center gap-3 text-xs font-black text-slate-700 hover:text-blue-600 transition-all uppercase">🎵 Konten TikTok ↗</a>
                @endif
                @if($user->peserta->berkas && $user->peserta->berkas->motivasi_video)
                    <a href="{{ asset('storage/'.$user->peserta->berkas->motivasi_video) }}" target="_blank" class="flex items-center gap-3 text-xs font-black text-blue-600 uppercase border-t border-slate-50 pt-4">🎬 Video Motivasi ↗</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
