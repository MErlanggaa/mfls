<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>404 - Halaman Tidak Ditemukan | MFLS</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('icon/loog.png') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('icon/loog.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon/loog.png') }}">

    <!-- Open Graph / Facebook / WhatsApp / Instagram -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title') - {{ config('app.name', 'MFLS') }}">
    <meta property="og:description"
        content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta property="og:image" content="{{ asset('icon/loog.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ config('app.name', 'MFLS') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title') - {{ config('app.name', 'MFLS') }}">
    <meta name="twitter:description"
        content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta name="twitter:image" content="{{ asset('icon/loog.png') }}">

    <!-- Tailwind CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-primary-blue: #023681;
            --color-primary-yellow: #fcdb2f;
            --color-dark-navy: #011f4b;
            --font-jakarta: "Plus Jakarta Sans", sans-serif;
        }
    </style>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0.1;
                transform: scale(1.5);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse-slow 8s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#f8fafc] font-jakarta min-h-screen flex items-center justify-center overflow-hidden">

    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div
            class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary-blue/5 rounded-full blur-3xl animate-pulse-slow">
        </div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[50%] h-[50%] bg-primary-yellow/10 rounded-full blur-3xl animate-pulse-slow"
            style="animation-delay: -4s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <!-- 404 Visual -->
            <div class="relative inline-block mb-12">
                <h1 class="text-[12rem] md:text-[16rem] font-black text-primary-blue/10 leading-none select-none">404
                </h1>
                <div class="absolute inset-0 flex items-center justify-center">
                    <img src="{{ asset('icon/loog.png') }}" alt="MFLS Logo"
                        class="h-24 md:h-32 w-auto animate-float drop-shadow-2xl">
                </div>
            </div>

            <!-- Message -->
            <div class="max-w-2xl mx-auto">
                <h2 class="text-3xl md:text-5xl font-extrabold text-dark-navy mb-6 tracking-tight">
                    Waduh! Halaman <span class="text-primary-yellow">Tersesat.</span>
                </h2>
                <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                    Sepertinya halaman yang Anda cari telah pindah tugas atau tidak pernah ada.
                    Jangan khawatir, mari kita kembali ke jalur yang benar.
                </p>

                <!-- Action Button -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ url('/') }}"
                        class="w-full sm:w-auto bg-primary-blue hover:bg-dark-navy text-white px-10 py-4 rounded-full font-bold text-lg shadow-xl shadow-primary-blue/20 transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center gap-3 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali Beranda
                    </a>
                    /* <a href="{{ url('/pengumuman') }}"
                        class="w-full sm:w-auto bg-white hover:bg-gray-50 text-dark-navy border-2 border-gray-100 px-10 py-4 rounded-full font-bold text-lg transition-all duration-300 hover:shadow-lg flex items-center justify-center gap-3">
                        Cek Hasil Seleksi
                    </a> */
                </div>
            </div>

            <!-- Footer Small -->
            <div class="mt-20 text-sm text-gray-400 font-medium">
                © {{ date('Y') }} MFLS - MNC University Future Leader Scholarship
            </div>
        </div>
    </div>

    <!-- Interactive Mouse Element (Script for extra "wow") -->
    <script>
        document.addEventListener('mousemove', (e) => {
            const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
            const moveY = (e.clientY - window.innerHeight / 2) * 0.01;
            document.querySelector('.animate-float').style.transform = `translate(${moveX}px, ${moveY}px)`;
        });
    </script>
</body>

</html>