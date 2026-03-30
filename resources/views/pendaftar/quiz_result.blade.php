@extends('layouts.user')

@push('styles')
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
    .markdown-ai p {
        margin-bottom: 1rem;
        font-size: 1.05rem;
        line-height: 1.7;
        color: #4b5563;
    }
    .markdown-ai p:last-child {
        margin-bottom: 0;
    }
    .markdown-ai strong {
        color: var(--color-dark-navy);
        font-weight: 800;
        background: linear-gradient(120deg, var(--color-primary-yellow) 0%, var(--color-primary-yellow) 100%);
        background-repeat: no-repeat;
        background-size: 100% 30%;
        background-position: 0 90%;
    }
</style>
@endpush

@section('content')
<div class="bg-gray-50/50 min-h-screen py-12 lg:py-20 relative overflow-hidden">
    <!-- Decorative Blurs -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary-yellow/10 rounded-full blur-[100px] -z-10 mix-blend-multiply"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-primary-blue/5 rounded-full blur-[100px] -z-10 mix-blend-multiply"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12 relative z-10">
            <span class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-white shadow-xl shadow-primary-yellow/20 text-primary-yellow mb-6 border border-gray-100 animate-float">
                <iconify-icon icon="solar:medal-ribbons-star-bold" class="text-4xl"></iconify-icon>
            </span>
            <h1 class="text-4xl lg:text-5xl font-black text-gray-900 mb-4 font-jakarta tracking-tight">Hasil Analisis Minat & Bakat</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Berdasarkan jawabanmu, ini adalah program studi yang paling cocok dengan kepribadian dan mimpimu.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <!-- 1st Match -->
            <div class="bg-gradient-to-br from-dark-navy to-blue-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-dark-navy/30 transform transition-transform hover:scale-[1.02]">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-primary-yellow/20 rounded-full blur-xl translate-y-1/2 -translate-x-1/2"></div>
                
                <div class="flex justify-between items-start mb-12 relative z-10">
                    <span class="px-3 py-1 bg-white/10 border border-white/20 rounded-full text-xs font-bold uppercase tracking-widest text-primary-yellow backdrop-blur-sm">Matching #1</span>
                    <span class="text-5xl font-black text-white/90">{{ $percent1 }}<span class="text-2xl text-white/70">%</span></span>
                </div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl font-black mb-2 text-white">{{ $top1 }}</h2>
                    <p class="text-blue-100/80 text-sm font-medium">Prioritas Tertinggi</p>
                </div>
                
                <div class="mt-8 flex items-center justify-between border-t border-white/10 pt-6">
                    <span class="text-xs text-white/60 font-medium">Relevansi Sangat Kuat</span>
                    <iconify-icon icon="solar:star-fall-minimalistic-2-bold" class="text-2xl text-primary-yellow"></iconify-icon>
                </div>
            </div>

            <!-- 2nd Match -->
            <div class="bg-white rounded-[2.5rem] p-8 text-gray-800 relative overflow-hidden shadow-xl shadow-gray-200/50 border border-gray-100 transform transition-transform hover:scale-[1.02]">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                
                <div class="flex justify-between items-start mb-12 relative z-10">
                    <span class="px-3 py-1 bg-gray-50 border border-gray-100 rounded-full text-xs font-bold uppercase tracking-widest text-gray-500">Matching #2</span>
                    <span class="text-5xl font-black text-gray-800">{{ $percent2 }}<span class="text-2xl text-gray-400">%</span></span>
                </div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl font-black mb-2 text-dark-navy">{{ $top2 }}</h2>
                    <p class="text-gray-400 text-sm font-medium">Alternatif Pilihan</p>
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-gray-50 pt-6">
                    <span class="text-xs text-gray-400 font-medium">Relevansi Kuat</span>
                    <iconify-icon icon="solar:star-bold" class="text-2xl text-gray-300"></iconify-icon>
                </div>
            </div>
        </div>

        <!-- Arion AI Analysis Section -->
        <div class="bg-white rounded-[2.5rem] p-8 lg:p-12 shadow-sm border border-gray-100 relative overflow-hidden mb-12">
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-50">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <img src="{{ asset('icon/scholarr.png') }}" class="w-8 h-8 object-contain" alt="Arion Mascot">
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Analisis Arion AI</h3>
                    <p class="text-xs text-gray-500 font-medium">Generated based on your answers</p>
                </div>
            </div>

            <div class="markdown-ai">
                {!! Str::markdown($ai) !!}
            </div>
            
            <div class="mt-8 py-4 px-5 bg-yellow-50/50 rounded-2xl border border-yellow-100/50 flex items-start gap-3">
                <iconify-icon icon="solar:info-circle-bold" class="text-yellow-600 outline-none text-xl mt-0.5 flex-shrink-0"></iconify-icon>
                <p class="text-xs text-yellow-700/80 leading-relaxed font-medium">Hasil di atas merupakan rekomendasi sistem berbasis AI. Pilihlah jurusan dengan bijak dengan mempertimbangkan passion, kemampuan akademik, dan diskusi dengan orang tua.</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="w-full sm:w-auto text-center bg-primary-yellow text-dark-navy font-bold px-10 py-4 rounded-xl shadow-lg shadow-primary-yellow/20 hover:scale-105 transition-all text-lg flex items-center justify-center gap-2">
                Daftar Sekarang <iconify-icon icon="solar:arrow-right-bold" class="text-xl"></iconify-icon>
            </a>
            <a href="{{ route('quiz.show') }}" class="w-full sm:w-auto text-center bg-white border-2 border-gray-100 text-gray-600 font-bold px-10 py-4 rounded-xl hover:bg-gray-50 transition-all text-lg flex items-center justify-center gap-2">
                <iconify-icon icon="solar:restart-bold" class="text-xl"></iconify-icon> Coba Lagi
            </a>
        </div>
    </div>
</div>
@endsection
