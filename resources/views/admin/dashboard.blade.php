@extends('layouts.admin')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="text-gray-500 text-sm font-bold mb-2 uppercase tracking-wide">Total Pendaftar</div>
        <div class="text-4xl font-black text-dark-navy">{{ \App\Models\Akun::where('role', 'pendaftar')->count() }}</div>
        <div class="mt-2 text-xs text-green-500 font-bold">↑ +12 hari ini</div>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="text-gray-500 text-sm font-bold mb-2 uppercase tracking-wide">Sudah Finalisasi</div>
        <div class="text-4xl font-black text-emerald-600">0</div>
        <div class="mt-2 text-xs text-gray-400">Menunggu Submit</div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="text-gray-500 text-sm font-bold mb-2 uppercase tracking-wide">Total Mentor</div>
        <div class="text-4xl font-black text-primary-gold">{{ \App\Models\Akun::where('role', 'mentor')->count() }}</div>
        <div class="mt-2 text-xs text-gray-400">Aktif Membimbing</div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="text-gray-500 text-sm font-bold mb-2 uppercase tracking-wide">Akun Admin</div>
        <div class="text-4xl font-black text-purple-600">{{ \App\Models\Akun::where('role', 'admin')->count() }}</div>
        <div class="mt-2 text-xs text-gray-400">Pengelola Sistem</div>
    </div>
</div>

<!-- Recent Activity & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Users Table -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Pendaftar Terbaru</h3>
            <button class="text-primary-gold text-sm font-bold hover:underline">Lihat Semua</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Waktu Daftar</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Akun::where('role', 'pendaftar')->latest()->take(5)->get() as $user)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-800">{{ $user->nama }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $user->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Baru</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Activity Logs -->
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                Riwayat Aktivitas
            </h3>
            
            <div class="space-y-4">
                @forelse($riwayats as $riwayat)
                <div class="flex gap-3 items-start pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                    <div class="shrink-0 w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-xs">
                        @if($riwayat->aksi == 'Verifikasi Status') ✅ 
                        @elseif($riwayat->aksi == 'Menilai Peserta') ⭐
                        @elseif($riwayat->aksi == 'Tambah Soal') 📝
                        @else ⚙️ @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800 leading-tight">{{ $riwayat->deskripsi }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[10px] text-blue-600 font-black uppercase">{{ $riwayat->pelaku->nama }}</span>
                            <span class="text-[10px] text-slate-400">• {{ $riwayat->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 text-xs py-4 italic">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
