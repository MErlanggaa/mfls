@extends('pendaftar.layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-10 pb-32">
    {{-- 1. STICKY BACK BUTTON --}}
    <div class="sticky top-6 z-40 px-2 lg:px-0">
        <a href="{{ url('/') }}#berita" class="inline-flex items-center gap-4 bg-white/90 backdrop-blur-2xl px-6 py-4 rounded-2xl border border-slate-100 shadow-xl text-slate-800 font-black text-[10px] uppercase tracking-[0.2em] transform active:scale-95 transition-all hover:bg-slate-900 hover:text-white hover:border-slate-900 group">
            <span class="iconify text-xl group-hover:-translate-x-2 transition-transform" data-icon="solar:alt-arrow-left-bold-duotone"></span>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    {{-- 2. ARTICLE HEADER --}}
    <div class="space-y-10">
        <div class="space-y-6">
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 bg-slate-900 text-primary-gold rounded-lg text-[9px] font-black uppercase tracking-widest border border-white/10 leading-none">Official Update</span>
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="iconify text-lg" data-icon="solar:calendar-bold-duotone"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $berita->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-[1.1] tracking-tighter">{{ $berita->judul }}</h1>
        </div>

        @if($berita->thumbnail)
        <div class="relative group">
            <div class="absolute -inset-4 bg-primary-gold/5 rounded-[4rem] blur-3xl opacity-50"></div>
            <div class="relative aspect-video rounded-[2.5rem] overflow-hidden shadow-2xl border border-slate-100">
                <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-[2s]">
            </div>
        </div>
        @endif
    </div>

    {{-- 3. CONTENT SANCTUARY --}}
    <div class="bg-white rounded-[2.5rem] p-10 md:p-16 border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 p-12 opacity-[0.02] rotate-12">
            <span class="iconify text-[120px] text-slate-900" data-icon="solar:document-text-bold"></span>
        </div>
        
        <article class="prose prose-slate max-w-none prose-headings:font-black prose-headings:tracking-tight prose-strong:text-slate-900 prose-a:text-primary-gold prose-img:rounded-3xl text-slate-600 font-medium leading-[1.8] relative z-10 custom-article">
            {!! $berita->konten !!}
        </article>
    </div>

    {{-- 4. FOOTER NOTE --}}
    <div class="flex items-center justify-between px-8 py-10 border-t border-slate-50">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white">
                <span class="iconify text-xl" data-icon="solar:user-bold-duotone"></span>
            </div>
            <div class="space-y-0.5">
                <p class="text-[9px] font-black text-slate-900 uppercase tracking-widest">Admin MFLS</p>
                <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest italic leading-none">Official Publication</p>
            </div>
        </div>
        <div class="hidden sm:flex items-center gap-3">
            <span class="text-[8px] font-black text-slate-300 uppercase tracking-[0.4em]">Official Scholarship Portal</span>
        </div>
    </div>
</div>

<style>
    .custom-article p { margin-bottom: 2rem; }
    .custom-article h2, .custom-article h3 { color: #0f172a; margin-top: 3rem; margin-bottom: 1rem; }
</style>
@endsection
