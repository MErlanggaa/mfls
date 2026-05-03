@extends('layouts.admin')

@section('content')
<div class="space-y-8 font-sans">
    <!-- HERO SECTION -->
    <div class="relative overflow-hidden bg-white p-10 md:p-12 rounded-[2.5rem] shadow-xl shadow-slate-200/60 border border-slate-100">
        <div class="absolute top-0 right-0 w-80 h-80 bg-orange-100 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/3 opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-100 rounded-full blur-[60px] translate-y-1/3 -translate-x-1/4 opacity-60"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-50 border border-orange-100 rounded-full text-[10px] font-black uppercase tracking-widest text-orange-600 mb-4">
                    <span class="iconify" data-icon="solar:history-bold"></span>
                    Activity Monitoring
                </div>
                <h1 class="text-3xl md:text-5xl font-black mb-3 tracking-tight text-slate-800">Log Aktivitas <span class="text-orange-500">.</span></h1>
                <p class="text-slate-500 font-medium max-w-lg text-lg leading-relaxed">
                    Pantau setiap tindakan yang dilakukan di sistem untuk menjaga keamanan dan transparansi data.
                </p>
            </div>
            
            <div class="flex gap-4">
                <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm text-center min-w-[140px]">
                    <div class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1">TOTAL LOG</div>
                    <div class="text-4xl font-black text-slate-800">{{ $riwayats->total() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERS -->
    <div class="bg-white p-6 rounded-[2rem] shadow-lg shadow-slate-200/40 border border-slate-100">
        <form action="{{ route('admin.activity_log.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="relative group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Cari Deskripsi/User</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 iconify text-slate-400" data-icon="solar:magnifer-bold"></span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari..." 
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all font-bold text-slate-700">
                </div>
            </div>

            <!-- Activity Type -->
            <div class="relative group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Jenis Aktivitas</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 iconify text-slate-400" data-icon="solar:filter-bold"></span>
                    <select name="aksi" 
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all font-bold text-slate-700 appearance-none">
                        <option value="">Semua Aktivitas</option>
                        @foreach($activities as $activity)
                            <option value="{{ $activity }}" {{ request('aksi') == $activity ? 'selected' : '' }}>{{ $activity }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Date -->
            <div class="relative group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Tanggal</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 iconify text-slate-400" data-icon="solar:calendar-bold"></span>
                    <input type="date" name="date" value="{{ request('date') }}" 
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all font-bold text-slate-700">
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-black py-3.5 rounded-2xl transition-all shadow-lg shadow-orange-500/25 flex items-center justify-center gap-2">
                    <span class="iconify text-xl" data-icon="solar:filter-bold"></span>
                    Filter
                </button>
                <a href="{{ route('admin.activity_log.index') }}" class="w-14 h-[54px] bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-2xl flex items-center justify-center transition-all">
                    <span class="iconify text-2xl" data-icon="solar:refresh-bold"></span>
                </a>
            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Waktu</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Pelaku</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Aktivitas</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($riwayats as $log)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-slate-700">{{ $log->created_at->translatedFormat('d M Y') }}</div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mt-0.5">{{ $log->created_at->format('H:i:s') }} ({{ $log->created_at->diffForHumans() }})</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600 font-black text-sm flex-shrink-0">
                                    {{ strtoupper(substr($log->pelaku->nama ?? 'S', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-slate-800 truncate">{{ $log->pelaku->nama ?? 'System' }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $log->pelaku->role ?? 'Bot' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest 
                                {{ str_contains(strtolower($log->aksi), 'hapus') ? 'bg-rose-50 text-rose-600 border border-rose-100' : 
                                   (str_contains(strtolower($log->aksi), 'tambah') || str_contains(strtolower($log->aksi), 'daftar') ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 
                                   'bg-blue-50 text-blue-600 border border-blue-100') }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ str_contains(strtolower($log->aksi), 'hapus') ? 'bg-rose-500' : (str_contains(strtolower($log->aksi), 'tambah') || str_contains(strtolower($log->aksi), 'daftar') ? 'bg-emerald-500' : 'bg-blue-500') }}"></span>
                                {{ $log->aksi }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm text-slate-600 leading-relaxed max-w-md">{{ $log->deskripsi }}</p>
                            @if($log->target_tipe && $log->target_id)
                                <div class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Target: {{ class_basename($log->target_tipe) }} #{{ $log->target_id }}</div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-3xl bg-slate-50 flex items-center justify-center text-slate-300">
                                    <span class="iconify text-5xl" data-icon="solar:history-bold"></span>
                                </div>
                                <div class="text-slate-400 font-bold">Tidak ada riwayat aktivitas ditemukan.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
            {{ $riwayats->links() }}
        </div>
    </div>
</div>

<style>
    /* Custom style for pagination focus */
    .pagination > .active > span {
        background-color: #F97316 !important;
        border-color: #F97316 !important;
    }
</style>
@endsection
