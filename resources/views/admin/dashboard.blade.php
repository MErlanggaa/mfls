@extends('layouts.admin')

@section('content')
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

<div class="space-y-8 font-sans">
    <!-- 1. HERO SECTION (Light Theme) -->
    <div class="relative overflow-hidden bg-white p-10 md:p-12 rounded-[2.5rem] shadow-xl shadow-slate-200/60 border border-slate-100">
        <!-- Background Decorations -->
        <div class="absolute top-0 right-0 w-80 h-80 bg-orange-100 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/3 opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-100 rounded-full blur-[60px] translate-y-1/3 -translate-x-1/4 opacity-60"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-50 border border-orange-100 rounded-full text-[10px] font-black uppercase tracking-widest text-orange-600 mb-4">
                    <span class="iconify animate-pulse" data-icon="carbon:dot-mark" style="color: #f97316;"></span>
                    Live Dashboard
                </div>
                <h1 class="text-3xl md:text-5xl font-black mb-3 tracking-tight text-slate-800">Admin Portal <span class="text-orange-500">.</span></h1>
                <p class="text-slate-500 font-medium max-w-lg text-lg leading-relaxed">
                    Pantau statistik pendaftar, verifikasi berkas, dan kelola seleksi beasiswa dalam satu panel terintegrasi.
                </p>
            </div>
            
            <!-- Quick Date/Time or Mini Stat -->
            <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-sm text-center min-w-[180px]">
                <div class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1">HARI INI</div>
                <div class="text-4xl font-black text-slate-800">{{ $todayPendaftar }}</div>
                <div class="flex items-center justify-center gap-1 text-xs font-bold {{ $growth >= 0 ? 'text-emerald-500' : 'text-rose-500' }} mt-1">
                    <span class="iconify" data-icon="{{ $growth >= 0 ? 'lucide:trending-up' : 'lucide:trending-down' }}"></span>
                    <span>{{ round(abs($growth)) }}%</span> <span class="text-slate-400 font-medium">vs Kemarin</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total -->
        <div class="bg-white p-8 rounded-[2rem] shadow-lg shadow-slate-200/40 border border-slate-100 group hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="iconify text-2xl" data-icon="solar:users-group-rounded-bold"></span>
                </div>
                <span class="px-2 py-1 bg-slate-50 rounded-lg text-[10px] font-black text-slate-400 uppercase tracking-wide">Total</span>
            </div>
            <div class="text-4xl font-black text-slate-900 mb-1">{{ $totalPendaftar }}</div>
            <div class="text-sm font-bold text-slate-400">Pendaftar Terdaftar</div>
        </div>

        <!-- Card 2: Berkas (Gradient Orange) -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-8 rounded-[2rem] shadow-lg shadow-orange-500/20 text-white relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-8 -mt-8"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-white backdrop-blur-sm">
                        <span class="iconify text-2xl" data-icon="solar:folder-check-bold"></span>
                    </div>
                </div>
                <div class="text-4xl font-black mb-1">{{ $totalLengkap }}</div>
                <div class="text-sm font-bold opacity-90">Dokumen Lengkap</div>
            </div>
        </div>

        <!-- Card 3: Lulus Beasiswa -->
        <div class="bg-white p-8 rounded-[2rem] shadow-lg shadow-slate-200/40 border border-slate-100 group hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <span class="iconify text-2xl" data-icon="solar:medal-star-bold"></span>
                </div>
                <span class="px-2 py-1 bg-slate-50 rounded-lg text-[10px] font-black text-slate-400 uppercase tracking-wide">Lolos Seleksi</span>
            </div>
            <div class="text-4xl font-black text-slate-900 mb-1">{{ \App\Models\Daftar::where('status', 'lulus')->count() }}</div>
            <div class="text-sm font-bold text-slate-400">Penerima Beasiswa</div>
        </div>
    </div>

    <!-- WEBSITE ANALYTICS SECTION -->
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-indigo-500/20 text-white relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
        <div class="absolute left-0 bottom-0 w-48 h-48 bg-white/5 rounded-full blur-2xl -ml-12 -mb-12"></div>
        
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-[10px] font-black uppercase tracking-widest mb-3">
                        <span class="iconify animate-pulse" data-icon="carbon:dot-mark"></span>
                        Website Insights
                    </div>
                    <h2 class="text-2xl md:text-3xl font-black">Statistik Pengunjung Website</h2>
                    <p class="text-white/80 font-medium mt-2">Real-time analytics dan performa website</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Views -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <span class="iconify text-xl" data-icon="solar:eye-bold"></span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider opacity-80">Total Views</span>
                    </div>
                    <div class="text-3xl font-black mb-1">{{ number_format($totalViews) }}</div>
                    <div class="text-xs opacity-70">Semua waktu</div>
                </div>

                <!-- Today Views -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <span class="iconify text-xl" data-icon="solar:calendar-bold"></span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider opacity-80">Hari Ini</span>
                    </div>
                    <div class="text-3xl font-black mb-1">{{ number_format($todayViews) }}</div>
                    <div class="flex items-center gap-1 text-xs">
                        <span class="iconify" data-icon="{{ $viewsGrowth >= 0 ? 'lucide:trending-up' : 'lucide:trending-down' }}"></span>
                        <span>{{ round(abs($viewsGrowth)) }}%</span>
                        <span class="opacity-70">vs kemarin</span>
                    </div>
                </div>

                <!-- Unique Visitors -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <span class="iconify text-xl" data-icon="solar:user-bold"></span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider opacity-80">Unique Visitors</span>
                    </div>
                    <div class="text-3xl font-black mb-1">{{ number_format($uniqueVisitorsToday) }}</div>
                    <div class="text-xs opacity-70">Hari ini</div>
                </div>

                <!-- Avg per Day -->
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 hover:bg-white/15 transition-all">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <span class="iconify text-xl" data-icon="solar:chart-bold"></span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider opacity-80">Rata-rata/Hari</span>
                    </div>
                    <div class="text-3xl font-black mb-1">{{ $dailyViewsTrend->count() > 0 ? number_format($dailyViewsTrend->avg('total')) : 0 }}</div>
                    <div class="text-xs opacity-70">7 hari terakhir</div>
                </div>
            </div>

            <!-- Top Pages -->
            <div class="mt-8 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6">
                <h3 class="text-lg font-black mb-4 flex items-center gap-2">
                    <span class="iconify" data-icon="solar:document-bold"></span>
                    Halaman Paling Banyak Dikunjungi
                </h3>
                <div class="space-y-3">
                    @foreach($topPages as $index => $page)
                    <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl hover:bg-white/10 transition-all">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center font-black text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-bold truncate">{{ parse_url($page->url, PHP_URL_PATH) ?: '/' }}</div>
                                <div class="text-xs opacity-70 truncate">{{ $page->url }}</div>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="font-black text-lg">{{ number_format($page->views) }}</div>
                            <div class="text-xs opacity-70">views</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- 3. MAIN CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Chart -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-lg shadow-slate-200/40">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800">Analitik Pendaftaran</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Data 7 Hari Terakhir</p>
                </div>
                <button class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-orange-600 hover:bg-orange-50 transition-all">
                    <span class="iconify text-xl" data-icon="solar:menu-dots-bold"></span>
                </button>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="regChart"></canvas>
            </div>
        </div>

        <!-- Right: Recent Activity (Light Theme) -->
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-lg shadow-slate-200/40 flex flex-col relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50/50 rounded-full blur-3xl -mr-10 -mt-10"></div>
            
            <h3 class="text-xl font-black text-slate-800 mb-6 relative z-10 flex items-center gap-2">
                <span class="iconify text-orange-500" data-icon="solar:history-bold"></span>
                Log Aktivitas
            </h3>
            
            <div class="flex-grow space-y-6 overflow-y-auto max-h-[350px] relative z-10 pr-2 scrollbar-hide">
                @foreach($riwayats as $log)
                <div class="flex gap-4 group">
                    <div class="flex flex-col items-center">
                        <div class="w-2 h-2 rounded-full bg-slate-300 group-hover:bg-orange-500 group-hover:scale-125 transition-all"></div>
                        <div class="w-0.5 h-full bg-slate-100 my-1 group-last:hidden"></div>
                    </div>
                    <div class="pb-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ $log->created_at->diffForHumans() }}</p>
                        <p class="text-sm font-bold text-slate-700 group-hover:text-orange-600 transition-colors">{{ $log->aksi }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $log->pelaku->nama ?? 'System' }} • <span class="text-slate-500">{{ $log->deskripsi }}</span></p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <a href="#" class="mt-4 py-3 bg-slate-50 rounded-xl text-center text-xs font-black uppercase tracking-widest text-slate-400 hover:bg-orange-50 hover:text-orange-600 transition-all">
                Lihat Semua Log
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('regChart').getContext('2d');
    
    // Gradient Orange
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(249, 115, 22, 0.2)'); // Orange-500
    gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

    const chartData = @json($dailyTrend);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(d => {
                const date = new Date(d.date);
                return date.toLocaleDateString('id-ID', { weekday: 'short' });
            }),
            datasets: [{
                label: 'Pendaftar',
                data: chartData.map(d => d.total),
                borderColor: '#F97316', // Orange-500
                borderWidth: 4,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#F97316',
                pointBorderWidth: 3,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#1e293b',
                    bodyColor: '#475569',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: false,
                    titleFont: { family: 'Plus Jakarta Sans', weight: 'bold' },
                    bodyFont: { family: 'Plus Jakarta Sans' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#F1F5F9', borderDash: [5, 5] },
                    ticks: { font: { weight: 'bold', family: 'Plus Jakarta Sans' }, color: '#94a3b8' },
                    border: { display: false }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: 'bold', family: 'Plus Jakarta Sans' }, color: '#94a3b8' },
                    border: { display: false }
                }
            }
        }
    });
});
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
