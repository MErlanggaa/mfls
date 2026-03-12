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
            --color-primary-gold: #F2B451;
            --color-primary-gold-hover: #e0a340;
            --color-dark-navy: #111827;
            --font-jakarta: "Plus Jakarta Sans", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
        @layer base {
            body {
                @apply font-jakarta text-gray-800 bg-white antialiased;
            }
        }
    </style>
</head>
<body class="font-jakarta antialiased bg-gray-50/50">
    <div class="flex min-h-screen">
        <!-- Sidebar - Hidden on mobile, visible on desktop -->
        <div class="hidden lg:block">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col min-w-0 w-full">
            <!-- Top Header -->
            <header class="h-16 lg:h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 px-4 lg:px-8 flex items-center justify-between sticky top-0 z-40">
                <!-- Mobile Menu Button -->
                <button id="mobile-sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <h2 class="text-sm lg:text-lg font-bold text-gray-900 flex items-center gap-2 truncate">
                    <span class="hidden sm:inline">Selamat Datang,</span> {{ Str::limit(Auth::user()->nama ?? 'Pendaftar', 15) }}! 
                    <span class="iconify text-yellow-500 hidden sm:inline" data-icon="solar:hand-shake-bold"></span>
                </h2>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-gray-900 uppercase tracking-wider">Jalur Seleksi</p>
                        <p class="text-[10px] text-primary-gold font-bold">Beasiswa Prestasi</p>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-4 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden hidden">
        <div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white transform -translate-x-full transition-transform duration-300 ease-in-out">
            @include('layouts.sidebar')
        </div>
    </div>

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
                    confirmButtonColor: '#F2B451',
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
                    confirmButtonColor: '#F2B451',
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
                    confirmButtonColor: '#F2B451',
                    confirmButtonText: '<span class="px-4">Mengerti</span>',
                    customClass: {
                        popup: 'premium-swal-popup',
                        confirmButton: 'rounded-xl font-bold uppercase tracking-widest text-[10px]'
                    }
                });
            @endif
        });
    </script>
</body>
</html>
