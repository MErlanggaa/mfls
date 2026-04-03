<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP - MFLS</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('icon/loog.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .otp-input:focus { border-color: #F97316; box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 md:p-10 border border-slate-100">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-8 text-center">
            <img src="{{ asset('icon/loog.png') }}" class="w-16 h-16 rounded-2xl shadow-lg mb-4" alt="Logo">
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Verifikasi Email</h1>
            <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                Kami telah mengirimkan kode OTP 6-digit ke <br>
                <span class="font-bold text-slate-700">{{ $email }}</span>
            </p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 text-sm font-medium animate-pulse">
            <span class="iconify text-xl" data-icon="solar:check-circle-bold"></span>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl flex items-center gap-3 text-sm font-medium">
            <span class="iconify text-xl" data-icon="solar:danger-bold"></span>
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('verify.otp.post') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div>
                <label for="otp" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Masukkan Kode OTP</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-orange-500 text-slate-400">
                        <span class="iconify text-xl" data-icon="solar:key-minimalistic-bold-duotone"></span>
                    </div>
                    <input type="text" name="otp" id="otp" maxlength="6" required
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none transition-all otp-input font-black text-2xl tracking-[0.5em] text-center text-slate-700 placeholder:text-slate-300 placeholder:tracking-normal"
                        placeholder="000000">
                </div>
                @error('otp')
                    <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-2xl font-extrabold text-sm transition-all shadow-lg shadow-orange-500/25 flex items-center justify-center gap-2 group active:scale-95">
                Verifikasi Sekarang
                <span class="iconify text-lg group-hover:translate-x-1 transition-transform" data-icon="solar:arrow-right-bold"></span>
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-slate-50 text-center">
            <p class="text-sm text-slate-500 font-medium mb-3">Tidak menerima kode?</p>
            <form action="{{ route('resend.otp') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" id="resendBtn" class="text-orange-600 font-extrabold text-sm hover:text-orange-700 transition-colors inline-flex items-center gap-2 group disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="iconify text-xl group-hover:rotate-180 transition-transform duration-500" data-icon="solar:restart-bold"></span>
                    Kirim Ulang Kode
                </button>
            </form>
            <div id="countdown" class="text-xs text-slate-400 mt-2 font-bold hidden">
                Kirim ulang dalam <span id="timer">60</span> detik
            </div>
        </div>

        <a href="{{ route('login') }}" class="mt-8 flex items-center justify-center gap-2 text-slate-400 hover:text-slate-600 transition-colors text-sm font-bold">
            <span class="iconify" data-icon="solar:arrow-left-bold"></span>
            Kembali ke Login
        </a>
    </div>

    <script>
        const resendBtn = document.getElementById('resendBtn');
        const countdown = document.getElementById('countdown');
        const timerSpan = document.getElementById('timer');
        let timeLeft = 60;

        resendBtn.addEventListener('click', function() {
            resendBtn.disabled = true;
            countdown.classList.remove('hidden');
            let counter = setInterval(() => {
                timeLeft--;
                timerSpan.innerText = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(counter);
                    resendBtn.disabled = false;
                    countdown.classList.add('hidden');
                    timeLeft = 60;
                }
            }, 1000);
        });

        // Auto focus
        document.getElementById('otp').focus();
    </script>
</body>
</html>
