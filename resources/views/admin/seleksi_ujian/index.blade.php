@extends('layouts.admin')

@section('content')
<div class="mb-8 space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-2xl font-black text-gray-800">Seleksi Kelulusan Ujian CBT</h2>
            <p class="text-gray-500 font-medium">Panel keputusan manual kelulusan berdasarkan hasil kumulatif TBA, TBI, dan Pemetaan Diri.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <!-- Search Form -->
            <form action="{{ route('admin.seleksi_ujian.index') }}" method="GET" class="w-full sm:w-80 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta..." class="w-full pl-12 pr-6 py-4 bg-white border border-gray-100 rounded-3xl text-sm font-bold shadow-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                <span class="iconify absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-xl" data-icon="solar:magnifer-linear"></span>
            </form>

            <!-- Tombol Kirim Email Massal -->
            @php
                $adaYangLulus = $pesertas->filter(fn($p) => ($p->status_seleksi_ujian ?? 'menunggu') === 'lulus')->count();
            @endphp
            @if($adaYangLulus > 0)
            <form action="{{ route('admin.seleksi_ujian.kirim_massal') }}" method="POST"
                  onsubmit="return confirm('Kirim email notifikasi lolos seleksi ujian ke {{ $adaYangLulus }} peserta yang telah dinyatakan LULUS?');">
                @csrf
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black uppercase tracking-widest rounded-3xl shadow-md transition-all whitespace-nowrap">
                    <span class="iconify text-lg" data-icon="solar:letter-bold"></span>
                    Kirim Email Massal ({{ $adaYangLulus }} Lulus)
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-6 py-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 font-bold text-sm">
            <span class="iconify text-xl flex-shrink-0" data-icon="solar:check-circle-bold"></span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-6 py-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 font-bold text-sm">
            <span class="iconify text-xl flex-shrink-0" data-icon="solar:danger-circle-bold"></span>
            {{ session('error') }}
        </div>
    @endif

    {{-- Summary Stats --}}
    @php
        $totalPeserta = $pesertas->count();
        $totalLulus  = $pesertas->filter(fn($p) => ($p->status_seleksi_ujian ?? 'menunggu') === 'lulus')->count();
        $totalGagal  = $pesertas->filter(fn($p) => ($p->status_seleksi_ujian ?? 'menunggu') === 'tidak_lulus')->count();
        $totalMenunggu = $pesertas->filter(fn($p) => ($p->status_seleksi_ujian ?? 'menunggu') === 'menunggu')->count();
    @endphp
    @if($totalPeserta > 0)
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white border border-gray-100 rounded-2xl p-4 text-center shadow-sm">
            <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Pendaftar CBT</div>
            <div class="text-2xl font-black text-slate-800">{{ $totalPeserta }}</div>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 text-center shadow-sm">
            <div class="text-[9px] font-black text-amber-500 uppercase tracking-widest mb-1">⏳ Menunggu</div>
            <div class="text-2xl font-black text-amber-700">{{ $totalMenunggu }}</div>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 text-center shadow-sm">
            <div class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-1">✅ Lulus Seleksi</div>
            <div class="text-2xl font-black text-emerald-700">{{ $totalLulus }}</div>
        </div>
        <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 text-center shadow-sm">
            <div class="text-[9px] font-black text-rose-400 uppercase tracking-widest mb-1">❌ Gagal Seleksi</div>
            <div class="text-2xl font-black text-rose-600">{{ $totalGagal }}</div>
        </div>
    </div>
    @endif
</div>

<div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[10px] tracking-[0.2em]">
                <tr>
                    <th class="px-6 py-5">Peserta</th>
                    <th class="px-6 py-5 text-center">Nilai TBA</th>
                    <th class="px-6 py-5 text-center">Nilai TBI</th>
                    <th class="px-6 py-5 text-center">Pemetaan Diri (AI)</th>
                    <th class="px-6 py-5 text-center">Status Seleksi</th>
                    <th class="px-6 py-5 text-right">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($pesertas as $peserta)
                @php
                    $status = $peserta->status_seleksi_ujian ?? 'menunggu';
                    $asalSekolah = $peserta->daftar->asal_sekolah ?? ($peserta->nama_sekolah ?? '-');
                @endphp
                <tr class="hover:bg-slate-50/50 transition-all">
                    {{-- Peserta Info --}}
                    <td class="px-6 py-4">
                        <div class="font-black text-slate-800 uppercase">{{ $peserta->nama }}</div>
                        <div class="text-[10px] font-bold text-blue-500 uppercase">NISN: {{ $peserta->nisn }}</div>
                        <div class="text-[10px] font-semibold text-slate-400 mt-0.5">🏫 {{ $asalSekolah }}</div>
                    </td>

                    {{-- TBA Score --}}
                    <td class="px-6 py-4 text-center">
                        @if($peserta->score_tba !== null)
                            <span class="text-lg font-black {{ $peserta->score_tba >= 70 ? 'text-blue-600' : 'text-amber-600' }}">
                                {{ number_format($peserta->score_tba, 2) }}
                            </span>
                        @else
                            <span class="px-2 py-1 bg-gray-50 text-gray-400 rounded text-[9px] font-bold uppercase tracking-wider">
                                Belum Mengerjakan
                            </span>
                        @endif
                    </td>

                    {{-- TBI Score --}}
                    <td class="px-6 py-4 text-center">
                        @if($peserta->score_tbi !== null)
                            <span class="text-lg font-black {{ $peserta->score_tbi >= 70 ? 'text-blue-600' : 'text-amber-600' }}">
                                {{ number_format($peserta->score_tbi, 2) }}
                            </span>
                        @else
                            <span class="px-2 py-1 bg-gray-50 text-gray-400 rounded text-[9px] font-bold uppercase tracking-wider">
                                Belum Mengerjakan
                            </span>
                        @endif
                    </td>

                    {{-- Pemetaan Diri AI analysis --}}
                    <td class="px-6 py-4 text-center">
                        @if(!empty($peserta->analisis_pemetaan))
                            <button type="button" 
                                    onclick="openAiModal('{{ addslashes($peserta->nama) }}', '{{ rawurlencode($peserta->analisis_pemetaan) }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest border border-purple-100 cursor-pointer shadow-sm transition-all">
                                <span class="iconify" data-icon="solar:psychology-bold"></span>
                                Lihat Analisis 🧠
                            </button>
                        @else
                            <span class="px-2 py-1 bg-gray-50 text-gray-400 rounded text-[9px] font-bold uppercase tracking-wider">
                                Belum Mengerjakan
                            </span>
                        @endif
                    </td>

                    {{-- Status Seleksi Ujian --}}
                    <td class="px-6 py-4 text-center">
                        @if($status === 'lulus')
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[9px] font-black uppercase tracking-widest rounded-full border border-emerald-200">
                                ✅ Lulus Seleksi
                            </span>
                        @elseif($status === 'tidak_lulus')
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 text-rose-600 text-[9px] font-black uppercase tracking-widest rounded-full border border-rose-100">
                                ❌ Gagal Seleksi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 text-amber-700 text-[9px] font-black uppercase tracking-widest rounded-full border border-amber-200">
                                ⏳ Menunggu
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 flex-wrap items-center">
                            {{-- Aksi Manual Kelulusan --}}
                            <div class="inline-flex rounded-xl border border-slate-100 bg-slate-50 p-1 gap-1">
                                <form action="{{ route('admin.seleksi_ujian.update_status', $peserta->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status_seleksi_ujian" value="lulus">
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all {{ $status === 'lulus' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-700' }}" title="Set Lulus">
                                        Lolos 👍
                                    </button>
                                </form>
                                <form action="{{ route('admin.seleksi_ujian.update_status', $peserta->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status_seleksi_ujian" value="tidak_lulus">
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all {{ $status === 'tidak_lulus' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-700' }}" title="Set Gagal">
                                        Gagal 👎
                                    </button>
                                </form>
                            </div>

                            <a href="{{ route('admin.beasiswa.show', $peserta->akun_id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[9px] font-black hover:bg-blue-600 hover:text-white transition-all shadow-sm uppercase tracking-widest">
                                Report 📑
                            </a>

                            {{-- Tombol Kirim Email (hanya untuk yang lulus manual) --}}
                            @if($status === 'lulus')
                            <form action="{{ route('admin.seleksi_ujian.kirim_email', $peserta->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Kirim email notifikasi lolos seleksi ujian ke {{ $peserta->nama }}?');">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-[9px] font-black hover:bg-emerald-600 hover:text-white transition-all shadow-sm uppercase tracking-widest animate-bounce">
                                    <span class="iconify" data-icon="solar:letter-bold"></span> Email
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($pesertas->isEmpty())
                <tr>
                    <td colspan="6" class="py-20 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-6">
                                <span class="iconify text-4xl text-slate-400" data-icon="solar:document-cross-bold"></span>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 mb-2">Belum Ada Data Peserta</h3>
                            <p class="text-slate-500 font-medium">Belum ada peserta yang lulus tahap administrasi.</p>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- ================= AI ANALISIS MODAL ================= -->
<div id="aiModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-all duration-300">
    <div class="bg-white rounded-[2rem] w-full max-w-2xl mx-4 overflow-hidden border border-slate-100 shadow-2xl flex flex-col max-h-[85vh] scale-95 transition-all duration-300" id="aiModalContent">
        <!-- Modal Header -->
        <div class="p-6 bg-purple-900 text-white flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-purple-700 flex items-center justify-center shadow-lg">
                    <span class="iconify text-2xl text-white" data-icon="solar:psychology-bold"></span>
                </div>
                <div>
                    <h3 class="font-black text-lg uppercase tracking-wide leading-tight">Analisis Psikologi AI</h3>
                    <p class="text-[10px] text-purple-200 font-bold uppercase tracking-wider" id="modalCandidateName"></p>
                </div>
            </div>
            <button onclick="closeAiModal()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-purple-800 text-purple-100 hover:bg-purple-700 hover:text-white transition-all cursor-pointer">
                <span class="iconify text-xl" data-icon="solar:close-circle-bold"></span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-8 overflow-y-auto flex-grow prose max-w-none text-slate-600 font-medium text-sm leading-relaxed" id="modalBodyText">
        </div>

        <!-- Modal Footer -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button onclick="closeAiModal()" class="px-6 py-3 bg-purple-900 hover:bg-purple-950 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-md cursor-pointer transition-all">
                Tutup Analisis
            </button>
        </div>
    </div>
</div>

<script>
    function openAiModal(name, encodedContent) {
        const modal = document.getElementById('aiModal');
        const content = document.getElementById('aiModalContent');
        const nameEl = document.getElementById('modalCandidateName');
        const bodyEl = document.getElementById('modalBodyText');

        nameEl.innerText = "Hasil Pemetaan Diri: " + name;
        
        // Decode content
        let decoded = decodeURIComponent(encodedContent);
        
        // Convert newlines to breaks or beautiful paragraphs
        bodyEl.innerHTML = decoded.replace(/\n/g, '<br>');

        // Animation
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 50);
    }

    function closeAiModal() {
        const modal = document.getElementById('aiModal');
        const content = document.getElementById('aiModalContent');

        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
