@extends('layouts.user')

@section('content')
    <div class="bg-white min-h-screen">
        {{-- 1. HERO HEADER --}}
        <div class="relative pt-20 pb-16 md:pt-32 md:pb-24 overflow-hidden">
            <div class="absolute inset-0 bg-primary-blue/5 -z-10 bg-[radial-gradient(circle_at_top_right,rgba(252,219,47,0.1),transparent)]"></div>
            
            <div class="max-w-4xl mx-auto px-6 text-center">
                {{-- Breadcrumbs --}}
                <nav class="flex items-center justify-center gap-3 mb-8 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                    <a href="{{ url('/') }}" class="hover:text-primary-blue transition-colors">Beranda</a>
                    <span class="iconify text-xs" data-icon="solar:alt-arrow-right-bold"></span>
                    <a href="{{ url('/') }}#berita" class="hover:text-primary-blue transition-colors">Berita</a>
                    <span class="iconify text-xs" data-icon="solar:alt-arrow-right-bold text-primary-yellow"></span>
                    <span class="text-primary-blue">Detail</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-blue/10 text-primary-blue rounded-full text-[10px] font-black uppercase tracking-widest mb-6">
                    <span class="w-1.5 h-1.5 bg-primary-yellow rounded-full animate-pulse"></span>
                    Official Update
                </div>

                <h1 class="text-4xl md:text-6xl font-black text-dark-navy leading-[1.1] tracking-tighter mb-8">
                    {{ $berita->judul }}
                </h1>

                <div class="flex items-center justify-center gap-6 text-gray-500">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-primary-yellow/20 flex items-center justify-center">
                            <span class="iconify text-primary-blue" data-icon="solar:calendar-bold-duotone"></span>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-widest">{{ $berita->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="w-px h-4 bg-gray-200"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-primary-blue/10 flex items-center justify-center">
                            <span class="iconify text-primary-blue text-sm" data-icon="solar:user-bold-duotone"></span>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-widest">Admin MFLS</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. FEATURED IMAGE --}}
        <div class="max-w-5xl mx-auto px-6 -mt-12 md:-mt-20 relative z-20">
            @if($berita->thumbnail)
                <div class="relative group">
                    <div class="absolute -inset-4 bg-primary-blue/5 rounded-[3rem] blur-2xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative aspect-video md:aspect-[21/9] rounded-[2.5rem] overflow-hidden shadow-2xl border border-white">
                        <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}"
                            class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-[3s]">
                    </div>
                </div>
            @endif
        </div>

        {{-- 3. ARTICLE CONTENT --}}
        <div class="max-w-4xl mx-auto px-6 py-20">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-16 border border-gray-100 shadow-[0_32px_64px_-16px_rgba(2,54,129,0.05)] relative overflow-hidden">
                <div class="absolute top-0 right-0 p-12 opacity-[0.03] rotate-12">
                    <span class="iconify text-[180px] text-dark-navy" data-icon="solar:document-text-bold"></span>
                </div>

                <article class="prose prose-slate max-w-none prose-headings:text-dark-navy prose-headings:font-black prose-headings:tracking-tight prose-p:text-gray-600 prose-p:leading-[1.8] prose-p:mb-8 prose-strong:text-dark-navy prose-a:text-primary-blue prose-img:rounded-3xl relative z-10 custom-article">
                    {!! $berita->konten !!}
                </article>

                {{-- Footer Article --}}
                <div class="mt-16 pt-8 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-dark-navy rounded-2xl flex items-center justify-center text-white shadow-lg shadow-dark-navy/20">
                            <span class="iconify text-2xl text-primary-yellow" data-icon="solar:medal-star-bold-duotone"></span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-dark-navy uppercase tracking-widest">MNCU Future Leader Scholarship</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest italic leading-none">Generasi Emas Bangsa</p>
                        </div>
                    </div>
                    
                    <button onclick="window.print()" class="hidden sm:flex items-center gap-2 h-10 px-4 rounded-xl border border-gray-100 hover:bg-gray-50 text-gray-500 transition-colors">
                        <span class="iconify text-lg" data-icon="solar:printer-bold-duotone"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest">Cetak Berita</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- 4. LATEST NEWS SUGGESTION --}}
        @php
            $latest_beritas = \App\Models\Berita::where('id', '!=', $berita->id)
                ->where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        @endphp

        @if($latest_beritas->count() > 0)
            <div class="bg-gray-50/50 py-24">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="flex items-end justify-between mb-12">
                        <div>
                            <h3 class="font-caveat text-primary-blue text-2xl font-bold mb-2">Baca Juga</h3>
                            <h2 class="text-3xl md:text-4xl font-black text-dark-navy tracking-tight">Informasi Terbaru Lainnya</h2>
                        </div>
                        <a href="{{ url('/') }}#berita" class="group flex items-center gap-3 text-sm font-black text-primary-blue hover:text-dark-navy uppercase tracking-widest transition-all">
                            Lihat Semua
                            <span class="iconify text-xl group-hover:translate-x-2 transition-transform" data-icon="solar:alt-arrow-right-bold"></span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($latest_beritas as $item)
                        <div class="bg-white rounded-[2rem] border border-gray-100 p-4 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 group">
                            <div class="aspect-video rounded-2xl overflow-hidden mb-6">
                                @if($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-primary-blue/5 flex items-center justify-center">
                                        <span class="iconify text-4xl text-primary-blue/20" data-icon="solar:gallery-bold-duotone"></span>
                                    </div>
                                @endif
                            </div>
                            <div class="px-2">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="w-1.5 h-1.5 bg-primary-yellow rounded-full"></span>
                                    <span class="text-[10px] font-black tracking-widest uppercase text-gray-400">{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                                <h4 class="text-lg font-bold text-dark-navy mb-4 line-clamp-2 h-14 group-hover:text-primary-blue transition-colors">
                                    {{ $item->judul }}
                                </h4>
                                <a href="{{ route('berita.show', $item->slug) }}" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-primary-blue group-hover:gap-4 transition-all">
                                    Baca Selengkapnya
                                    <span class="iconify" data-icon="solar:alt-arrow-right-bold"></span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .custom-article {
            font-size: 1.1rem;
        }

        .custom-article h2 {
            font-size: 1.8rem;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            color: #023681;
        }

        .custom-article h3 {
            font-size: 1.4rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #023681;
        }

        .custom-article p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .custom-article blockquote {
            border-left: 4px solid #fcdb2f;
            background: #f9fafb;
            padding: 2rem;
            border-radius: 1rem;
            font-style: italic;
            color: #1f2937;
        }
    </style>
@endsection