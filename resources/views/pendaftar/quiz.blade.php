@extends('layouts.user')

@push('styles')
<style>
    .quiz-option input:checked + div {
        background-color: var(--color-primary-yellow);
        border-color: var(--color-primary-yellow);
    }
    .quiz-option input:checked + div p {
        color: var(--color-dark-navy);
        font-weight: bold;
    }
    .quiz-option input:checked + div .icon-check {
        opacity: 1;
        transform: scale(1);
    }
</style>
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
@endpush

@section('content')
<div class="bg-gray-50/50 min-h-screen py-12 lg:py-20 relative overflow-hidden">
    <!-- Decorative Blur -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-yellow/20 rounded-full blur-[100px] -z-10 mix-blend-multiply"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-blue/10 rounded-full blur-[100px] -z-10 mix-blend-multiply"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-16 relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-yellow/20 text-primary-blue text-xs font-bold uppercase tracking-widest mb-4 border border-primary-yellow/30">
                <iconify-icon icon="solar:stars-bold" class="text-lg"></iconify-icon> AI Career Match
            </span>
            <h1 class="text-4xl lg:text-5xl font-black text-gray-900 mb-6 font-jakarta tracking-tight">Temukan <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-blue to-blue-500">Prodi Impianmu</span></h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Jawab {{ count($questions) }} pertanyaan singkat di bawah ini sesuai dengan kepribadianmu. Arion AI akan menganalisis minat dan bakatmu untuk merekomendasikan program studi yang paling cocok!
            </p>
        </div>

        @if(session('error'))
        <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 font-semibold relative z-10">
            <iconify-icon icon="solar:danger-circle-bold" class="text-2xl flex-shrink-0"></iconify-icon>
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('quiz.submit') }}" method="POST" id="quizForm" class="space-y-12 relative z-10">
            @csrf

            @foreach($questions as $index => $q)
            <div class="bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden transition-all hover:shadow-md group">
                <!-- Question Number -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center opacity-50 group-hover:bg-primary-yellow/10 transition-colors">
                    <span class="text-5xl font-black text-gray-200 group-hover:text-primary-yellow/40 transition-colors -translate-x-2 translate-y-2">{{ $index + 1 }}</span>
                </div>

                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-8 relative z-10 font-jakarta leading-snug">
                    <span class="text-primary-blue mr-2">{{ $index + 1 }}.</span> {{ $q['question'] }}
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10">
                    @foreach($q['options'] as $major => $text)
                    <label class="quiz-option cursor-pointer block relative">
                        <input type="radio" name="answers[{{ $index }}]" value="{{ $major }}" class="absolute opacity-0 w-0 h-0 appearance-none" required>
                        <div class="h-full p-5 sm:p-6 rounded-2xl border-2 border-gray-100 bg-gray-50/50 hover:bg-gray-50 hover:border-gray-200 transition-all flex items-start gap-4 user-select-none">
                            <div class="mt-1 flex-shrink-0 w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center relative bg-white">
                                <iconify-icon icon="solar:check-circle-bold" class="icon-check text-dark-navy w-full h-full text-[24px] absolute opacity-0 scale-50 transition-all duration-300"></iconify-icon>
                            </div>
                            <p class="text-gray-600 font-medium leading-relaxed">{{ $text }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach

            <!-- Submit Button -->
            <div class="text-center pt-8">
                <button type="submit" id="submitBtn" class="inline-flex items-center justify-center gap-3 bg-dark-navy text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-opacity-90 transition-all shadow-xl shadow-dark-navy/20 hover:-translate-y-1 active:translate-y-0 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                    <iconify-icon icon="solar:magic-stick-3-bold" class="text-2xl"></iconify-icon>
                    <span>Analisis Profil Saya</span>
                </button>
                <div class="mt-4 flex flex-col items-center justify-center gap-2">
                    <img src="{{ asset('icon/scholarr.png') }}" class="w-8 h-8 object-contain" alt="Arion Mascot">
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Powered by Arion AI</p>
                </div>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    document.getElementById('quizForm').addEventListener('submit', function(e) {
        const questionsCount = {{ count($questions) }};
        let answeredCount = 0;
        let firstUnanswered = null;

        for (let i = 0; i < questionsCount; i++) {
            const radios = document.querySelectorAll(`input[name="answers[${i}]"]`);
            let isAnswered = false;
            for (let radio of radios) {
                if (radio.checked) {
                    isAnswered = true;
                    answeredCount++;
                    break;
                }
            }
            if (!isAnswered && !firstUnanswered) {
                firstUnanswered = radios[0].closest('.bg-white');
            }
        }

        if (answeredCount < questionsCount) {
            e.preventDefault();
            firstUnanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstUnanswered.style.transition = 'all 0.3s ease';
            firstUnanswered.style.transform = 'scale(1.02)';
            firstUnanswered.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.2)';
            
            setTimeout(() => {
                firstUnanswered.style.transform = 'scale(1)';
                firstUnanswered.style.boxShadow = 'none';
            }, 1000);
        } else {
            // Show loading
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = `<iconify-icon icon="svg-spinners:180-ring" class="text-2xl"></iconify-icon> <span>AI Sedang Menganalisis...</span>`;
            btn.classList.add('opacity-80', 'cursor-not-allowed', 'pointer-events-none');
        }
    });

    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
@endsection
