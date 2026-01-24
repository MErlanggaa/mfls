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

    <!-- Quick Actions -->
    <div class="space-y-6">
        <div class="bg-dark-navy p-6 rounded-2xl text-white shadow-xl">
            <h3 class="font-bold text-xl mb-2">Shortcuts</h3>
            <p class="text-gray-400 text-sm mb-6">Akses cepat menu pengelolaan utama.</p>
            
            <div class="space-y-3">
                <button class="w-full flex items-center justify-between p-4 bg-white/10 hover:bg-white/20 rounded-xl transition-all">
                    <span class="font-semibold">Buka Pendaftaran</span>
                    <span>→</span>
                </button>
                <button class="w-full flex items-center justify-between p-4 bg-white/10 hover:bg-white/20 rounded-xl transition-all">
                    <span class="font-semibold">Export Data Excel</span>
                    <span>↓</span>
                </button>
                <button class="w-full flex items-center justify-between p-4 bg-white/10 hover:bg-white/20 rounded-xl transition-all">
                    <span class="font-semibold">Broadcast Email</span>
                    <span>✉</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
