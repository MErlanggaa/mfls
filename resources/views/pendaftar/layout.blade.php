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
                <h2 class="text-lg font-bold text-gray-900">Selamat Datang, {{ Auth::user()->nama ?? 'Pendaftar' }}! 👋</h2>
                <div class="flex items-center gap-4">
                    <button class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-primary-gold transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </button>
                    <div class="h-8 w-[1px] bg-gray-100"></div>
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-gray-900 uppercase tracking-wider">Status Akun</p>
                        <p class="text-[10px] text-emerald-500 font-bold">Terverifikasi</p>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
