<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Survei Peserta - {{ config('app.name', 'MFLS') }}</title>

    <!-- Fonts -->
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('icon/loog.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('icon/loog.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon/loog.jpeg') }}">

    <!-- Open Graph / Facebook / WhatsApp / Instagram -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ config('app.name', 'MFLS') }} - Program Beasiswa">
    <meta property="og:description" content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta property="og:image" content="{{ asset('icon/loog.jpeg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ config('app.name', 'MFLS') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ config('app.name', 'MFLS') }} - Program Beasiswa">
    <meta name="twitter:description" content="Membangun generasi emas bangsa melalui program beasiswa unggulan dan pembinaan karakter yang berkelanjutan.">
    <meta name="twitter:image" content="{{ asset('icon/loog.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

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
<body class="font-jakarta antialiased bg-slate-50 min-h-screen py-10 px-4 flex items-center justify-center">

    <div class="max-w-3xl w-full bg-white border border-gray-100 shadow-xl shadow-slate-200/50 rounded-[2rem] overflow-hidden">
        <!-- Header -->
        <div class="p-8 md:p-10 border-b border-gray-50 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-2 tracking-tight">Quesioner Peserta 📝</h1>
                <p class="text-gray-500 font-medium">Mohon lengkapi survei ini untuk melanjutkan pendaftaran.</p>
            </div>
            <div class="w-12 h-12 bg-primary-gold rounded-xl flex items-center justify-center shadow-lg shadow-primary-gold/20 text-dark-navy font-bold text-xl">
                M
            </div>
        </div>

        <form action="/survey" method="POST" class="p-8 md:p-10 space-y-10">
            @csrf

            <!-- Question 1 -->
            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-900">
                    1. Darimanakah kamu mendapatkan informasi mengenai program MFLS 2026?
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @php
                        $sources = [
                            'Guru atau Sekolah', 'Forum OSIS Jawa Barat (FOJB)', 'Forum Komunikasi Pengurus OSIS Prov. DIY',
                            'Forum OSIS Jawa Tengah (FOSIS)', 'Forum Anak Jawa Tengah (FAN Jateng)', 'Himpunan Musyawarah OSIS SMA Jawa Timur',
                            'Forum Anak Jawa Timur (FA Jatim)', 'Forum OSIS DKI Jakarta (FOS DKI)', 'Himpunan Osis Banten',
                            'Instagram @beassiwamncu', 'Instagram @mncuniversity', 'Tiktok mncuniversity',
                             'Website MNC University', 'Teman',
                            'Poster/Brosur beasiswamncu', 'Sosialisasi Tim', 'Expo Campus', 'Lainnya'
                        ];
                    @endphp
                    @foreach($sources as $source)
                    <div class="relative">
                        <input type="radio" name="info_sumber" id="sumber_{{ \Illuminate\Support\Str::slug($source) }}" value="{{ $source }}" class="peer hidden" required>
                        <label for="sumber_{{ \Illuminate\Support\Str::slug($source) }}" 
                            class="block w-full p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-primary-gold hover:bg-yellow-50/30 transition-all font-semibold text-gray-600 peer-checked:bg-primary-gold peer-checked:text-dark-navy peer-checked:border-primary-gold peer-checked:shadow-lg peer-checked:shadow-primary-gold/20">
                            {{ $source }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <hr class="border-gray-50">

            <!-- Question 2 -->
            <div class="space-y-4">
                <label class="block text-lg font-bold text-gray-900">
                    2. Apa motivasi kamu mendaftar program Beasiswa MFLS?
                </label>
                <p class="text-sm text-gray-400 font-medium -mt-2 mb-3">*Boleh pilih lebih dari satu</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @php
                        $motivations = ['Biaya Kuliah (Beasiswa)', 'Akreditasi Kampus', 'Prospek Kerja', 'Fasilitas Pendidikan', 'Reputasi Universitas'];
                    @endphp
                    @foreach($motivations as $mot)
                    <div class="relative">
                        <input type="checkbox" name="motivasi[]" id="mot_{{ \Illuminate\Support\Str::slug($mot) }}" value="{{ $mot }}" class="peer hidden">
                        <label for="mot_{{ \Illuminate\Support\Str::slug($mot) }}" 
                            class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-emerald-500 hover:bg-emerald-50/10 transition-all font-semibold text-gray-600 peer-checked:bg-emerald-500 peer-checked:text-white peer-checked:border-emerald-500 peer-checked:shadow-lg peer-checked:shadow-emerald-500/20">
                            <span class="mr-2">✨</span> {{ $mot }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <hr class="border-gray-50">

            <!-- Binary Questions -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">3. Pertanyaan Tambahan</h3>
                
                @php
                    $binaryQuestions = [
                        ['id' => 'bersedia_informasi_lain', 'label' => 'Apakah kamu bersedia menerima informasi tentang jalur seleksi lainnya dari MNC University?', 'icon' => '📢'],
                        ['id' => 'daftar_beasiswa_lain', 'label' => 'Apakah kamu sedang mendaftar beasiswa lain?', 'icon' => '🎓'],
                        ['id' => 'daftar_univ_lain', 'label' => 'Apakah kamu sedang mendaftar di Universitas selain MNC University?', 'icon' => '🏛️'],
                        ['id' => 'mengikuti_osis', 'label' => 'Apakah kamu mengikuti OSIS?', 'icon' => '👔'],
                        ['id' => 'mengikuti_forum_osis', 'label' => 'Apakah kamu mengikuti Forum OSIS Daerah/Provinsi?', 'icon' => '🤝'],
                        ['id' => 'anggota_forum_anak', 'label' => 'Apakah Anggota Forum Anak?', 'icon' => '👶'],
                        ['id' => 'sudah_diterima_kampus_lain', 'label' => 'Apakah kamu sudah diterima di kampus lain?', 'icon' => '✅'],
                        ['id' => 'sudah_daftar_diterima_mncuniversity', 'label' => 'Apakah sudah mendaftar atau diterima di MNC University?', 'icon' => '🏫'],
                    ];
                @endphp

                @foreach($binaryQuestions as $index => $q)
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 md:flex items-center justify-between gap-6 transition-all hover:bg-white hover:shadow-md">
                    <div class="flex items-start gap-4 mb-4 md:mb-0">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-xl border border-slate-100">
                            {{ $q['icon'] }}
                        </div>
                        <div class="flex-1">
                             <label class="text-sm font-bold text-gray-800 leading-snug block pt-2">{{ $q['label'] }}</label>
                        </div>
                    </div>
                    
                    <div class="flex gap-2 bg-white p-1 rounded-xl border border-gray-200 shadow-sm">
                        <div class="relative">
                            <input type="radio" name="{{ $q['id'] }}" id="{{ $q['id'] }}_1" value="1" class="peer hidden" required>
                            <label for="{{ $q['id'] }}_1" class="block px-6 py-2 rounded-lg text-sm font-bold text-gray-500 cursor-pointer transition-all peer-checked:bg-emerald-500 peer-checked:text-white hover:bg-gray-50">
                                Ya
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="{{ $q['id'] }}" id="{{ $q['id'] }}_0" value="0" class="peer hidden" required>
                            <label for="{{ $q['id'] }}_0" class="block px-6 py-2 rounded-lg text-sm font-bold text-gray-500 cursor-pointer transition-all peer-checked:bg-red-500 peer-checked:text-white hover:bg-gray-50">
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pt-8 border-t border-gray-100 flex items-center justify-end gap-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="font-bold text-gray-400 hover:text-red-500 text-sm px-6 py-4">
                        Keluar (Logout)
                    </button>
                </form>
                
                <button type="submit" 
                    class="bg-primary-gold hover:bg-primary-gold-hover text-dark-navy font-black px-10 py-4 rounded-2xl shadow-xl shadow-primary-gold/20 transition-all hover:scale-[1.02] active:scale-[0.98] flex items-center gap-2">
                    <span>Simpan & Lanjutkan</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </form>
    </div>
</body>
</html>
