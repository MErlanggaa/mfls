<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Pendaftar - {{ config('app.name', 'MFLS') }}</title>

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
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-grow flex flex-col min-w-0">
            <!-- Top Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 flex items-center justify-between sticky top-0 z-40">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    Selamat Datang, {{ Auth::user()->nama ?? 'Pendaftar' }}! 
                    <span class="iconify text-yellow-500" data-icon="solar:hand-shake-bold"></span>
                </h2>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-gray-900 uppercase tracking-wider">Jalur Seleksi</p>
                        <p class="text-[10px] text-primary-gold font-bold">Beasiswa Prestasi</p>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </main>
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
        });
    </script>
</body>
</html>
