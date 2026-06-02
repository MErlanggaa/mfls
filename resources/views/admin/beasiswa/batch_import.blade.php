@extends('layouts.admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-200 rounded-full mb-3">
            <span class="iconify text-emerald-500 text-sm" data-icon="solar:import-bold-duotone"></span>
            <span class="text-emerald-700 text-[10px] font-black uppercase tracking-widest">Batch Import</span>
        </div>
        <h2 class="text-2xl font-black text-slate-800 leading-tight">Import Seleksi Beasiswa</h2>
        <p class="text-slate-400 font-medium text-sm mt-1">Paste data tabel dari Excel/Sheets untuk auto-seleksi massal.</p>
    </div>
    <a href="{{ route('admin.beasiswa.index') }}"
        class="px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 hover:bg-slate-50 transition-all">
        <span class="iconify" data-icon="solar:arrow-left-bold"></span>
        Kembali ke Seleksi Beasiswa
    </a>
</div>

{{-- Success / Error Alerts --}}
@if(session('error'))
    <div class="mb-6 flex items-center gap-3 px-6 py-4 bg-red-50 border border-red-200 rounded-2xl">
        <span class="iconify text-red-500 text-xl" data-icon="solar:danger-triangle-bold-duotone"></span>
        <p class="text-red-700 font-bold text-sm">{{ session('error') }}</p>
    </div>
@endif

{{-- Import Results --}}
@if(session('import_matched') !== null)
    @php
        $matched  = session('import_matched', []);
        $notFound = session('import_notfound', []);
        $total    = session('import_total', 0);
    @endphp

    {{-- Summary Banner --}}
    <div class="mb-6 p-6 bg-emerald-50 border border-emerald-200 rounded-3xl flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-200">
            <span class="iconify text-white text-2xl" data-icon="solar:check-circle-bold"></span>
        </div>
        <div>
            <p class="text-emerald-800 font-black text-lg">Import Selesai!</p>
            <p class="text-emerald-700 text-sm font-medium mt-0.5">
                <span class="font-black">{{ count($matched) }}</span> dari <span class="font-black">{{ $total }}</span> kandidat berhasil diimport.
                @if(count($notFound) > 0)
                    <span class="text-red-600 ml-2 font-black">{{ count($notFound) }} tidak ditemukan.</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Matched Table --}}
    @if(count($matched) > 0)
    <div class="mb-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
            <span class="iconify text-emerald-500" data-icon="solar:check-circle-bold"></span>
            <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Berhasil Diproses ({{ count($matched) }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[9px] tracking-widest">
                    <tr>
                        <th class="px-5 py-3 text-left">No</th>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-left">Program Studi</th>
                        <th class="px-5 py-3 text-center">Kelas</th>
                        <th class="px-5 py-3 text-center">Beasiswa</th>
                        <th class="px-5 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($matched as $i => $m)
                    <tr class="hover:bg-slate-50/50 transition-all">
                        <td class="px-5 py-3 text-slate-400 font-black">{{ $i + 1 }}</td>
                        <td class="px-5 py-3 font-black text-slate-800 uppercase">{{ $m['nama'] }}</td>
                        <td class="px-5 py-3 text-slate-600 font-bold">{{ $m['prodi'] }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2 py-1 bg-blue-50 border border-blue-100 text-blue-700 rounded-lg text-[9px] font-black uppercase">{{ $m['kelas'] }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2 py-1 bg-amber-50 border border-amber-100 text-amber-700 rounded-lg text-[9px] font-black">{{ $m['beasiswa'] }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2 py-1 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-lg text-[9px] font-black flex items-center gap-1 justify-center w-fit mx-auto">
                                <span class="iconify" data-icon="solar:check-circle-bold"></span> Lulus
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Not Found Table --}}
    @if(count($notFound) > 0)
    <div class="mb-6 bg-white rounded-[2rem] border border-red-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100 flex items-center gap-2">
            <span class="iconify text-red-500" data-icon="solar:danger-triangle-bold"></span>
            <h3 class="font-black text-red-700 text-sm uppercase tracking-widest">Tidak Ditemukan di Database ({{ count($notFound) }})</h3>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($notFound as $i => $name)
            <div class="flex items-center gap-3 p-3 bg-red-50 border border-red-100 rounded-xl">
                <span class="w-6 h-6 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-[9px] font-black flex-shrink-0">{{ $i + 1 }}</span>
                <span class="text-red-700 font-bold text-xs uppercase">{{ $name }}</span>
            </div>
            @endforeach
        </div>
        <div class="px-6 pb-4">
            <p class="text-red-400 text-[10px] font-bold italic">* Nama-nama di atas tidak ditemukan di database. Periksa ejaan atau cari secara manual di halaman seleksi beasiswa.</p>
        </div>
    </div>
    @endif

    <div class="mb-8 border-t border-slate-100 pt-6">
        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest text-center">Import ulang atau tambah data baru di bawah ini</p>
    </div>
@endif

{{-- Import Form --}}
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2 mb-2">
        <span class="iconify text-xl text-emerald-500" data-icon="solar:clipboard-text-bold-duotone"></span>
        Paste Data Tabel
    </h3>
    <p class="text-slate-400 text-xs font-medium mb-6">Copy tabel dari Excel/Google Sheets lalu paste ke bawah. Format: <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-600">No | Nama | Sekolah | Prodi | Kelas | Beasiswa</code> (dipisah tab).</p>

    {{-- Format Example --}}
    <div class="mb-6 p-4 bg-slate-50 border border-slate-200 rounded-2xl overflow-x-auto">
        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Contoh Format</p>
        <table class="text-[10px] font-mono text-slate-600 w-full">
            <tr class="font-black text-slate-800 border-b border-slate-200">
                <td class="pr-6 pb-1">No.</td>
                <td class="pr-6 pb-1">Nama Lengkap</td>
                <td class="pr-6 pb-1">Asal Sekolah</td>
                <td class="pr-6 pb-1">Program Studi</td>
                <td class="pr-6 pb-1">Jenis Kelas</td>
                <td class="pb-1">Skema Beasiswa</td>
            </tr>
            <tr class="text-slate-500">
                <td class="pr-6 pt-1">1</td>
                <td class="pr-6 pt-1">Aelda Nurkhaila</td>
                <td class="pr-6 pt-1">SMKN 66 Jakarta</td>
                <td class="pr-6 pt-1">Manajemen</td>
                <td class="pr-6 pt-1">Exellent</td>
                <td class="pt-1">75%</td>
            </tr>
            <tr class="text-slate-500">
                <td class="pr-6">2</td>
                <td class="pr-6">Muhammad Faisal</td>
                <td class="pr-6">SMK Prima Unggul</td>
                <td class="pr-6">Akuntansi</td>
                <td class="pr-6">Reguler</td>
                <td>100%</td>
            </tr>
        </table>
    </div>

    <form action="{{ route('admin.beasiswa.import.batch') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Data Seleksi (Paste di sini)</label>
            <textarea name="data_input" id="data_input" rows="16"
                placeholder="Paste tabel dari Excel/Google Sheets di sini..."
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl text-xs font-mono text-slate-700 placeholder-slate-300 focus:border-emerald-400 focus:bg-white focus:outline-none transition-all resize-y"
                required>{{ old('data_input') }}</textarea>
            <p class="text-[10px] text-slate-400 font-medium mt-1.5 ml-1">Bisa paste banyak kelompok tabel sekaligus (misal 75% Reguler, 100% Reguler, 75% Exellent dalam 1 paste).</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <button type="submit" id="btnImport"
                class="px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 justify-center transition-all shadow-lg shadow-emerald-200">
                <span class="iconify text-base" data-icon="solar:import-bold"></span>
                Jalankan Import Sekarang
            </button>
            <button type="button" onclick="clearData()"
                class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 justify-center transition-all">
                <span class="iconify" data-icon="solar:close-circle-bold"></span>
                Bersihkan
            </button>
        </div>
    </form>
</div>

<script>
function clearData() {
    document.getElementById('data_input').value = '';
    document.getElementById('data_input').focus();
}
document.querySelector('form').addEventListener('submit', function() {
    const btn = document.getElementById('btnImport');
    btn.disabled = true;
    btn.innerHTML = '<span class="iconify animate-spin" data-icon="solar:refresh-bold"></span> Memproses...';
});
</script>
@endsection
