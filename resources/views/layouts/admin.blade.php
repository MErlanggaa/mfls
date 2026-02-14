<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - {{ config('app.name', 'MFLS') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('icon/loog.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('icon/loog.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon/loog.jpeg') }}">

    <!-- Open Graph / Facebook / WhatsApp / Instagram -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Admin Dashboard - {{ config('app.name', 'MFLS') }}">
    <meta property="og:description" content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta property="og:image" content="{{ asset('icon/loog.jpeg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ config('app.name', 'MFLS') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Admin Dashboard - {{ config('app.name', 'MFLS') }}">
    <meta name="twitter:description" content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta name="twitter:image" content="{{ asset('icon/loog.jpeg') }}">

    <!-- Fonts & Scripts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-primary-orange: #F97316;
            --color-primary-blue: #2563EB;
            --color-dark-navy: #111827;
            --font-jakarta: "Plus Jakarta Sans", sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="font-jakarta antialiased bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">
        <!-- Sidebar Admin (Light Theme: White/Orange/Blue) -->
        <aside class="w-72 bg-white border-r border-slate-200 flex flex-col fixed h-full z-30 shadow-xl shadow-slate-200/50">
            <div class="p-8 pb-4">
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform">
                        M
                    </div>
                    <div>
                        <span class="block font-black tracking-tight text-xl text-slate-800">MFLS <span class="text-orange-500">Admin</span></span>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Management Panel</span>
                    </div>
                </a>
            </div>
            
            <nav class="flex-grow px-4 pb-4 space-y-1 overflow-y-auto mt-4">
                <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">Main Menu</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 text-orange-600 shadow-sm ring-1 ring-orange-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="iconify text-xl {{ request()->routeIs('admin.dashboard') ? 'text-orange-600' : 'text-slate-400' }}" data-icon="solar:chart-square-bold"></span> Dashboard
                </a>

                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'akademik')
                <a href="{{ route('admin.beasiswa.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.beasiswa.*') ? 'bg-orange-50 text-orange-600 shadow-sm ring-1 ring-orange-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="iconify text-xl {{ request()->routeIs('admin.beasiswa.*') ? 'text-orange-600' : 'text-slate-400' }}" data-icon="solar:cup-star-bold"></span> Database Beasiswa
                </a>
                @endif

                <div class="px-4 py-2 mt-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Master Data</div>
                
                @if(auth()->user()->role !== 'mentor')
                <a href="{{ route('admin.pendaftar.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.pendaftar.index') ? 'bg-blue-50 text-blue-600 shadow-sm ring-1 ring-blue-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="iconify text-xl {{ request()->routeIs('admin.pendaftar.index') ? 'text-blue-600' : 'text-slate-400' }}" data-icon="solar:shield-check-bold"></span> Seleksi Administrasi
                </a>

                <a href="{{ route('admin.hasil_ujian.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.hasil_ujian.*') ? 'bg-blue-50 text-blue-600 shadow-sm ring-1 ring-blue-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="iconify text-xl {{ request()->routeIs('admin.hasil_ujian.*') ? 'text-blue-600' : 'text-slate-400' }}" data-icon="solar:document-text-bold"></span> Hasil Ujian
                </a>
                @endif

                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'mentor')
                <a href="{{ route('admin.penilaian.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.penilaian.index') ? 'bg-blue-50 text-blue-600 shadow-sm ring-1 ring-blue-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="iconify text-xl {{ request()->routeIs('admin.penilaian.index') ? 'text-blue-600' : 'text-slate-400' }}" data-icon="solar:user-id-bold"></span> Penilaian Mentor
                </a>
                @endif
                
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'akademik')
                <a href="{{ route('admin.penilaian.akademik.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.penilaian.akademik.*') ? 'bg-orange-50 text-orange-600 shadow-sm ring-1 ring-orange-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="iconify text-xl {{ request()->routeIs('admin.penilaian.akademik.*') ? 'text-orange-600' : 'text-slate-400' }}" data-icon="solar:medal-ribbon-bold"></span> Penilaian Akademik
                </a>
                @endif
                
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'akademik')
                <a href="{{ route('admin.soal.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.soal.index') ? 'bg-blue-50 text-blue-600 shadow-sm ring-1 ring-blue-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="iconify text-xl {{ request()->routeIs('admin.soal.index') ? 'text-blue-600' : 'text-slate-400' }}" data-icon="solar:pen-new-square-bold"></span> Bank Soal
                </a>
                @endif

                @if(auth()->user()->role === 'admin')
                <div class="px-4 py-2 mt-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Admin Control</div>
                <a href="{{ route('admin.mentor.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.mentor.index') ? 'bg-slate-100 text-slate-800 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="iconify text-xl {{ request()->routeIs('admin.mentor.index') ? 'text-slate-800' : 'text-slate-400' }}" data-icon="solar:settings-bold"></span> Manajemen User
                </a>
                <a href="{{ route('pengumuman') }}" target="_blank" class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all text-orange-500 hover:bg-orange-50 hover:text-orange-600">
                    <span class="iconify text-xl text-orange-500" data-icon="solar:eye-bold"></span> Live Pengumuman
                </a>
                @endif
            </nav>

            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-between w-full px-5 py-3 text-red-500 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-200 rounded-2xl font-bold transition-all shadow-sm group">
                        <span class="group-hover:translate-x-1 transition-transform">Keluar Sistem</span>
                        <span class="iconify text-xl" data-icon="solar:logout-2-bold"></span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-72 p-8 md:p-12 min-w-0">
            @yield('content')
        </main>
    </div>

    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#F97316',
                borderRadius: '1.5rem'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#ef4444',
                borderRadius: '1.5rem'
            });
        @endif
    </script>
</body>
</html>
