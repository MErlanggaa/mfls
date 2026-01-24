@extends('layouts.admin')

@section('content')
<!-- Notifikasi Flash -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-500 text-white rounded-2xl shadow-lg shadow-green-200 flex items-center justify-between animate-bounce">
    <div class="flex items-center gap-3">
        <span>✅</span>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
        <div class="text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Total Pendaftar</div>
        <div class="text-4xl font-black text-slate-800">{{ $totalPendaftar }}</div>
        <div class="mt-2 text-[10px] text-slate-400 font-bold tracking-widest uppercase italic">Seluruh database</div>
    </div>
    
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 ring-2 ring-blue-500/10">
        <div class="text-blue-600 text-[10px] font-black mb-2 uppercase tracking-widest flex items-center gap-2">
            Pendaftar Hari Ini
            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-ping"></span>
        </div>
        <div class="text-4xl font-black text-blue-600">{{ $todayPendaftar }}</div>
        <div class="mt-2 text-[10px] {{ $growth >= 0 ? 'text-green-500' : 'text-red-500' }} font-black">
            {{ $growth >= 0 ? '↑' : '↓' }} {{ abs(round($growth)) }}% dibanding kemarin
        </div>
    </div>

    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
        <div class="text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Selesai Berkas</div>
        <div class="text-4xl font-black text-emerald-600">{{ \App\Models\Berkas::count() }}</div>
        <div class="mt-2 text-[10px] text-slate-400 font-bold tracking-widest uppercase">Dokumen lengkap</div>
    </div>

    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
        <div class="text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Lulus Seleksi</div>
        <div class="text-4xl font-black text-purple-600">{{ \App\Models\Daftar::where('status', 'lulus')->count() }}</div>
        <div class="mt-2 text-[10px] text-slate-400 font-bold tracking-widest uppercase">Penerima Beasiswa</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Chart Section -->
    <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden">
        <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
            <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm">📈</span>
            Tren Pendaftaran (7 Hari Terakhir)
        </h3>
        <div class="h-[300px]">
            <canvas id="regChart"></canvas>
        </div>
    </div>

    <!-- Active Admin / Staff Info -->
    <div class="bg-dark-navy p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden text-white">
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full"></div>
        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 italic">Status Sistem</h3>
        <div class="space-y-6 relative">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/20 text-green-500 rounded-2xl flex items-center justify-center text-xl animate-pulse">✓</div>
                <div>
                    <div class="font-black text-sm">Database Sinkron</div>
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Global Central Database</div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/20 text-blue-500 rounded-2xl flex items-center justify-center text-xl">🛡️</div>
                <div>
                    <div class="font-black text-sm">Reporting Monitoring</div>
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Otomasi PDF/Excel Aktif</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
    <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
        <span class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center text-sm">🕒</span>
        Riwayat Aktivitas Terbaru
    </h3>
    <div class="space-y-4">
        @foreach($riwayats as $log)
        <div class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-100">
            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center font-black text-slate-500 text-xs">
                {{ substr($log->pelaku->nama ?? 'S', 0, 1) }}
            </div>
            <div class="flex-grow">
                <div class="text-sm font-black text-slate-800">{{ $log->aksi }}</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $log->deskripsi }}</div>
            </div>
            <div class="text-right">
                <div class="text-[10px] font-black text-blue-600 uppercase">{{ $log->created_at->diffForHumans() }}</div>
                <div class="text-[9px] font-bold text-slate-300 uppercase">{{ $log->pelaku->nama ?? 'System' }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('regChart');
    const chartData = @json($dailyTrend);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(d => {
                const date = new Date(d.date);
                return date.toLocaleDateString('id-ID', { weekday: 'short' });
            }),
            datasets: [{
                label: 'Pendaftar Baru',
                data: chartData.map(d => d.total),
                borderColor: '#2563EB',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563EB',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: { font: { weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: 'bold' } }
                }
            }
        }
    });
});
</script>
@endsection
