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
    <meta property="og:description"
        content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta property="og:image" content="{{ asset('icon/loog.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ config('app.name', 'MFLS') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Dashboard Pendaftar - {{ config('app.name', 'MFLS') }}">
    <meta name="twitter:description"
        content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta name="twitter:image" content="{{ asset('icon/loog.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

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

</body>

</html>