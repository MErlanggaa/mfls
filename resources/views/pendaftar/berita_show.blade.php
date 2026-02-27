@extends('layouts.user')

@section('content')
<div class="py-24 bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ url('/') }}#berita" class="inline-flex items-center gap-2 text-primary-yellow font-bold hover:gap-3 transition-all mb-8">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>

        <!-- Article Header -->
        <div class="mb-12">
            <div class="flex items-center gap-2 text-primary-yellow font-semibold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>{{ $berita->created_at->format('d M Y') }}</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-dark-navy leading-tight mb-8">{{ $berita->judul }}</h1>

            @if($berita->thumbnail)
            <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-auto max-h-[500px] object-cover rounded-3xl shadow-xl">
            @endif
        </div>

        <!-- Article Content -->
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed font-medium">
            {!! $berita->konten !!}
        </div>
    </div>
</div>
@endsection
