<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MFLS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-primary-blue: #023681;
            --color-primary-blue-hover: #012659;
            --color-primary-yellow: #fcdb2f;
            --color-primary-yellow-hover: #e3c51a;
            --color-dark-navy: #023681;
            --font-jakarta: "Plus Jakarta Sans", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            --font-caveat: "Caveat", cursive;
        }
        @layer base {
            body {
                @apply font-jakarta text-gray-800 bg-white antialiased;
            }
        }
    </style>
</head>
<body class="font-jakarta antialiased">
    <div class="min-h-screen flex flex-col bg-white">
        <!-- Navbar -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center gap-2">
                            <img src="{{ asset('icon/loog.jpeg') }}" alt="Logo MFLS" class="h-12 w-auto">
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="text-sm font-semibold text-gray-600 hover:text-primary-yellow transition-colors">Home</a>
                        <a href="#" class="text-sm font-semibold text-gray-600 hover:text-primary-yellow transition-colors">Tentang Kami</a>
                        <a href="#" class="text-sm font-semibold text-gray-600 hover:text-primary-yellow transition-colors">Panduan</a>
                        <a href="#" class="text-sm font-semibold text-gray-600 hover:text-primary-yellow transition-colors">Kontak</a>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex items-center gap-4">
                        <a href="/login" class="bg-primary-yellow hover:bg-primary-yellow-hover text-dark-navy px-8 py-3 rounded-full text-sm font-bold shadow-md shadow-primary-yellow/10 transition-all hover:scale-105 active:scale-95">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-dark-navy text-gray-400 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <!-- Brand Info -->
                    <div class="col-span-1 md:col-span-1">
                        <a href="/" class="flex items-center gap-2 mb-6">
                            <img src="{{ asset('icon/loog.jpeg') }}" alt="Logo MFLS" class="h-10 w-auto">
                        </a>
                        <p class="text-sm leading-relaxed mb-6">
                            Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.
                        </p>
                    </div>

                    <!-- Links 1 -->
                    <div>
                        <h4 class="text-white font-bold mb-6">Halaman</h4>
                        <ul class="space-y-4 text-sm">
                            <li><a href="#" class="hover:text-primary-yellow transition-colors">Beranda</a></li>
                            <li><a href="#" class="hover:text-primary-yellow transition-colors">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-primary-yellow transition-colors">Program Beasiswa</a></li>
                        </ul>
                    </div>

                    <!-- Links 2 -->
                    <div>
                        <h4 class="text-white font-bold mb-6">Bantuan</h4>
                        <ul class="space-y-4 text-sm">
                            <li><a href="#" class="hover:text-primary-yellow transition-colors">Pusat Bantuan</a></li>
                            <li><a href="#" class="hover:text-primary-yellow transition-colors">FAQ</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="text-white font-bold mb-6">Hubungi Kami</h4>
                        <ul class="space-y-4 text-sm">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-primary-yellow shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Jakarta, Indonesia</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
