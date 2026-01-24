@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Verifikasi Sosial Media</h2>
        <p class="text-gray-500">Aktivitas Digital: {{ $user->nama }}</p>
    </div>
    <a href="{{ route('admin.sosmed.index') }}" class="text-blue-600 font-bold hover:underline">← Kembali</a>
</div>

<div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
    <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-2">
        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm">📱</span>
        Monitoring Sosial Media
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Instagram -->
        <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-gradient-to-tr from-yellow-400 to-purple-600 text-white rounded-[1.5rem] flex items-center justify-center text-4xl shadow-2xl mb-6">📸</div>
            <h4 class="text-xl font-black text-slate-800 mb-2">Instagram</h4>
            <p class="text-slate-500 font-semibold mb-6">Profil & Postingan Twibbon</p>
            @if($user->peserta->link_ig)
                <a href="{{ $user->peserta->link_ig }}" target="_blank" class="w-full py-4 bg-white border border-slate-200 rounded-2xl text-sm font-black text-slate-700 shadow-sm hover:bg-slate-100 transition-all uppercase tracking-widest">KUNJUNGI PROFIL ↗</a>
            @else
                <div class="w-full py-4 bg-slate-100 border border-dashed border-slate-300 rounded-2xl text-xs font-black text-slate-400 uppercase tracking-widest">TIDAK DILAMPIRKAN</div>
            @endif
        </div>

        <!-- TikTok -->
        <div class="p-8 bg-black rounded-[2.5rem] flex flex-col items-center text-center text-white shadow-2xl shadow-black/20">
            <div class="w-20 h-20 bg-white text-black rounded-[1.5rem] flex items-center justify-center text-4xl shadow-2xl mb-6">🎵</div>
            <h4 class="text-xl font-black mb-2">TikTok</h4>
            <p class="text-white/50 font-semibold mb-6">Konten Video Kreatif</p>
            @if($user->peserta->link_tiktok)
                <a href="{{ $user->peserta->link_tiktok }}" target="_blank" class="w-full py-4 bg-white rounded-2xl text-sm font-black text-black hover:bg-gray-100 transition-all uppercase tracking-widest">LIHAT VIDEO ↗</a>
            @else
                <div class="w-full py-4 bg-white/10 border border-dashed border-white/20 rounded-2xl text-xs font-black text-white/50 uppercase tracking-widest">TIDAK DILAMPIRKAN</div>
            @endif
        </div>

        <!-- Twibbon -->
        <div class="p-8 bg-blue-600 rounded-[2.5rem] flex flex-col items-center text-center text-white shadow-2xl shadow-blue-600/20">
            <div class="w-20 h-20 bg-yellow-400 text-blue-900 rounded-[1.5rem] flex items-center justify-center text-4xl shadow-2xl mb-6">🔖</div>
            <h4 class="text-xl font-black mb-2">Twibbon</h4>
            <p class="text-white/60 font-semibold mb-6">Kampanye MFLS 2026</p>
            @if($user->peserta->link_twibbon)
                <a href="{{ $user->peserta->link_twibbon }}" target="_blank" class="w-full py-4 bg-yellow-400 rounded-2xl text-sm font-black text-blue-900 hover:bg-yellow-300 transition-all uppercase tracking-widest">CEK TWIBBON ↗</a>
            @else
                <div class="w-full py-4 bg-white/10 border border-dashed border-white/20 rounded-2xl text-xs font-black text-white/50 uppercase tracking-widest">BELUM DIPOSTING</div>
            @endif
        </div>
    </div>
</div>
@endsection
