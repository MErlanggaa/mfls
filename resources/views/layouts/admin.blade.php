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
            --color-primary-gold: #FFD700;
            --color-primary-gold-hover: #ECC900;
            --color-dark-navy: #0F172A;
            --color-blue-brand: #2563EB;
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
            
            <nav class="flex-grow p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl font-bold transition-all">
                    <span>🏠</span> Dashboard
                </a>

                <div class="pt-4 pb-2 px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Pendaftaran</div>
                <a href="{{ route('admin.pendaftar.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.pendaftar.index') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl font-bold transition-all">
                    <span>👥</span> Data Profil
                </a>
                
                @if(auth()->user()->role !== 'mentor')
                <a href="{{ route('admin.raport.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.raport.index') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl font-bold transition-all">
                    <span>📚</span> Nilai Raport
                </a>
                <a href="{{ route('admin.berkas.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.berkas.index') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl font-bold transition-all">
                    <span>📂</span> Verifikasi Berkas
                </a>
                <a href="{{ route('admin.sosmed.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.sosmed.index') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl font-bold transition-all">
                    <span>📱</span> Kontrol Sosmed
                </a>
                @endif

                <div class="pt-4 pb-2 px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Ujian & Seleksi</div>
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'akademik')
                <a href="{{ route('admin.soal.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.soal.index') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl font-bold transition-all">
                    <span>📝</span> Bank Soal
                </a>
                @endif
                
                <a href="{{ route('admin.penilaian.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.penilaian.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl font-bold transition-all">
                    <span>👨‍🏫</span> Penilaian Mentor
                </a>

                @if(auth()->user()->role === 'admin')
                <div class="pt-4 pb-2 px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Pengaturan</div>
                <a href="{{ route('admin.mentor.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.mentor.index') ? 'bg-blue-600 text-white shadow-lg' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl font-bold transition-all">
                    <span>🛡️</span> Manajemen Mentor
                </a>
                @endif
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
