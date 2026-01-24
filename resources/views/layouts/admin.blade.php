<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - {{ config('app.name', 'MFLS') }}</title>

    <!-- Fonts & Scripts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-primary-gold: #F2B451;
            --color-primary-gold-hover: #e0a340;
            --color-dark-navy: #111827;
            --font-jakarta: "Plus Jakarta Sans", sans-serif;
        }
    </style>
</head>
<body class="font-jakarta antialiased bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar Admin -->
        <aside class="w-64 bg-dark-navy text-white flex flex-col fixed h-full z-30">
            <div class="p-6 border-b border-gray-700">
                <a href="#" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-primary-gold rounded flex items-center justify-center text-dark-navy font-black">A</div>
                    <span class="font-bold tracking-tight">Admin <span class="text-primary-gold">Panel</span></span>
                </a>
            </div>
            
            <nav class="flex-grow p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }} rounded-xl font-semibold">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('admin.pendaftar.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.pendaftar.index') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }} rounded-xl font-semibold transition-all">
                    <span>👥</span> Data Pendaftar
                </a>
                <a href="{{ route('admin.soal.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.soal.index') ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }} rounded-xl font-semibold transition-all">
                    <span>📝</span> Bank Soal
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-white/5 rounded-xl font-semibold transition-all">
                    <span>🎓</span> Manajemen Mentor
                </a>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl font-semibold transition-all">
                        <span>🚪</span> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->nama ?? 'Admin' }}</h2>
                    <p class="text-gray-500">Pantau perkembangan seleksi MFLS 2026 di sini.</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-4 py-2 bg-primary-gold/20 text-primary-gold font-bold rounded-full text-sm">
                        {{ ucfirst(Auth::user()->role ) }}
                    </span>
                </div>
            </header>

            @yield('content')
        </main>
    </div>
</body>
</html>
