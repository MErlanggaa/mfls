<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Pendaftar - {{ config('app.name', 'MFLS') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('icon/loog.png') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('icon/loog.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon/loog.png') }}">

    <!-- Open Graph / Facebook / WhatsApp / Instagram -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Dashboard Pendaftar - {{ config('app.name', 'MFLS') }}">
    <meta property="og:description" content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta property="og:image" content="{{ asset('icon/loog.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ config('app.name', 'MFLS') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Dashboard Pendaftar - {{ config('app.name', 'MFLS') }}">
    <meta name="twitter:description" content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta name="twitter:image" content="{{ asset('icon/loog.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-primary-orange: #f97316;
            --color-primary-orange-hover: #ea580c;
            --color-navy-mnc: #001f3f;
            --color-premium-dark: #001f3f;
            --font-jakarta: "Plus Jakarta Sans", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
        @layer base {
            body {
                @apply font-jakarta text-gray-800 bg-[#FAFBFF] antialiased;
            }
            /* Custom Scrollbar for Premium Feel */
            ::-webkit-scrollbar {
                @apply w-1.5;
            }
            ::-webkit-scrollbar-track {
                @apply bg-transparent;
            }
            ::-webkit-scrollbar-thumb {
                @apply bg-gray-200 rounded-full hover:bg-primary-orange transition-colors;
            }
            html {
                scroll-behavior: smooth;
            }
        }
        @layer utilities {
            .glass-card {
                @apply bg-white/70 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(31,38,135,0.07)];
            }
            .premium-shadow {
                @apply shadow-[0_20px_50px_rgba(0,0,0,0.05)];
            }
            .text-shadow-orange {
                text-shadow: 0 0 10px rgba(249, 115, 22, 0.3);
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            .animate-glow-pulse {
                animation: glow-pulse 3s infinite;
            }
            @keyframes glow-pulse {
                0%, 100% { opacity: 0.5; filter: blur(20px); }
                50% { opacity: 0.8; filter: blur(30px); }
            }
        }
    </style>
</head>
<body class="font-jakarta antialiased bg-gray-50/50">
    <div class="flex min-h-screen">
        @if(!isset($hideSidebar) || !$hideSidebar)
        <!-- Sidebar - Hidden on mobile, visible on desktop -->
        <div class="hidden lg:block">
            @include('layouts.sidebar')
        </div>
        @endif

        <!-- Main Content -->
        <main class="flex-grow flex flex-col min-w-0 w-full">
            <!-- Top Header -->
            <header class="h-20 lg:h-24 bg-white/90 backdrop-blur-md border-b border-gray-100 px-5 lg:px-12 flex items-center justify-between sticky top-0 z-40">
                @if(!isset($hideSidebar) || !$hideSidebar)
                <!-- Mobile Menu Button -->
                <button id="mobile-sidebar-toggle" class="lg:hidden p-2 rounded-xl bg-slate-50 text-slate-600 hover:bg-slate-100 transition-all active:scale-90 border border-slate-200">
                    <span class="iconify text-xl" data-icon="solar:hamburger-menu-linear"></span>
                </button>
                @else
                <!-- Logo for public view if sidebar is hidden -->
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('icon/loog.png') }}" alt="Logo" class="h-8 w-auto">
                    <span class="text-[10px] font-black text-navy-mnc uppercase tracking-widest hidden sm:block">MNCU Future Leader Scholarship Portal</span>
                </a>
                @endif
                
                <div class="flex flex-col ml-3 lg:ml-0">
                    <h2 class="text-sm lg:text-xl font-extrabold text-slate-900 tracking-tight leading-none flex items-center gap-2">
                        Selamat Datang, {{ explode(' ', optional(Auth::user())->nama ?? 'Future Leader')[0] }} <span class="text-orange-500 underline decoration-orange-500/30 underline-offset-4">{{ explode(' ', optional(Auth::user())->nama ?? '')[1] ?? '' }}</span>
                    </h2>
                    <p class="text-[9px] lg:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2 opacity-80 flex items-center gap-2">
                        <span class="iconify text-orange-500" data-icon="solar:verified-check-bold"></span>
                        Calon Penerima MNCU Future Leader Scholarship 2026
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    {{-- Notification hidden as requested --}}
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-4 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    @if(!isset($hideSidebar) || !$hideSidebar)
    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden hidden">
        <div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white transform -translate-x-full transition-transform duration-300 ease-in-out">
            @include('layouts.sidebar')
        </div>
    </div>
    @endif

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .premium-swal-popup {
            border-radius: 2rem !important;
            padding: 2rem !important;
            border: 1px solid #f3f4f6 !important;
        }
    </style>
    <script>
        // Mobile Sidebar Toggle
        const mobileToggle = document.getElementById('mobile-sidebar-toggle');
        const mobileOverlay = document.getElementById('mobile-sidebar-overlay');
        const mobileSidebar = document.getElementById('mobile-sidebar');

        if (mobileToggle && mobileOverlay && mobileSidebar) {
            mobileToggle.addEventListener('click', () => {
                mobileOverlay.classList.remove('hidden');
                setTimeout(() => {
                    mobileSidebar.classList.remove('-translate-x-full');
                }, 10);
            });

            mobileOverlay.addEventListener('click', (e) => {
                if (e.target === mobileOverlay) {
                    mobileSidebar.classList.add('-translate-x-full');
                    setTimeout(() => {
                        mobileOverlay.classList.add('hidden');
                    }, 300);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    title: '<span class="text-xl font-black text-slate-800">Berhasil!</span>',
                    html: '<p class="text-sm font-medium text-slate-500">{{ session("success") }}</p>',
                    icon: 'success',
                    iconColor: '#10b981',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: '<span class="px-4">Oke, Mengerti</span>',
                    customClass: {
                        popup: 'premium-swal-popup',
                        confirmButton: 'rounded-xl font-bold uppercase tracking-widest text-[10px]'
                    },
                    timer: 4000,
                    timerProgressBar: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutDown'
                    }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: '<span class="text-xl font-black text-slate-800">Upss!</span>',
                    html: '<p class="text-sm font-medium text-slate-500">{{ session("error") }}</p>',
                    icon: 'error',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: '<span class="px-4">Coba Lagi</span>',
                    customClass: {
                        popup: 'premium-swal-popup',
                        confirmButton: 'rounded-xl font-bold uppercase tracking-widest text-[10px]'
                    }
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    title: '<span class="text-xl font-black text-slate-800">Cek Kembali Berkas Anda!</span>',
                    html: '<div class="text-sm font-medium text-slate-500 text-left w-full max-h-48 overflow-y-auto mt-2 bg-red-50 p-4 rounded-xl border border-red-100"><ul class="list-disc pl-4 space-y-1 text-red-600">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>',
                    icon: 'error',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: '<span class="px-4">Mengerti</span>',
                    customClass: {
                        popup: 'premium-swal-popup',
                        confirmButton: 'rounded-xl font-bold uppercase tracking-widest text-[10px]'
                    }
                });
            @endif

            // PENUTUPAN PENDAFTARAN - Disable semua form di area konten utama
            const mainInputs = document.querySelectorAll('main form input, main form textarea, main form select');
            mainInputs.forEach(input => {
                input.setAttribute('disabled', 'disabled');
                input.setAttribute('readonly', 'readonly');
                input.classList.add('bg-gray-100', 'cursor-not-allowed', 'opacity-70');
                if (input.parentElement && input.parentElement.tagName === 'LABEL') {
                    input.parentElement.classList.add('pointer-events-none', 'opacity-70', 'cursor-not-allowed');
                }
            });

            const mainButtons = document.querySelectorAll('main form button[type="submit"]');
            mainButtons.forEach(button => {
                button.setAttribute('disabled', 'disabled');
                button.classList.add('opacity-50', 'cursor-not-allowed');
                button.innerHTML = '<span class="iconify" data-icon="solar:lock-bold"></span> Pendaftaran Ditutup';
            });

            const deleteButtons = document.querySelectorAll('main button[onclick*="Swal"], main a.bg-red-500, main a.bg-red-100, main button.bg-red-500');
            deleteButtons.forEach(btn => {
                btn.setAttribute('disabled', 'disabled');
                btn.style.pointerEvents = 'none';
                btn.classList.add('opacity-50');
            });
        });
    </script>
</body>
</html>
