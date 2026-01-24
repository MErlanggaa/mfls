<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Survei Peserta - {{ config('app.name', 'MFLS') }}</title>

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
<body class="font-jakarta antialiased bg-gray-50/30 py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white border border-gray-100 shadow-2xl shadow-gray-200/50 rounded-[2.5rem] overflow-hidden">
        <!-- Header -->
        <div class="p-10 border-b border-gray-50 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-primary-gold rounded-xl flex items-center justify-center shadow-lg shadow-primary-gold/20">
                    <span class="text-dark-navy font-extrabold text-xl">M</span>
                </div>
            </div>
            <h1 class="text-3xl font-black text-gray-900 mb-2">Survei Peserta 📋</h1>
            <p class="text-gray-500 font-medium">Isi survei dulu yuk ✨</p>
        </div>

        <form action="/survey" method="POST" class="p-10 space-y-12">
            @csrf

            <!-- Question 1 -->
            <div class="space-y-6">
                <label class="block text-base font-bold text-gray-800 leading-relaxed">
                    Darimanakah kamu mendapatkan informasi mengenai program MFLS 2026?
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $sources = [
                            'Guru atau Sekolah', 'Forum OSIS Jawa Barat (FOJB)', 'Forum Komunikasi Pengurus OSIS Prov. DIY',
                            'Forum OSIS Jawa Tengah (FOSIS)', 'Forum Anak Jawa Tengah (FAN Jateng)', 'Himpunan Musyawarah OSIS SMA Jawa Timur',
                            'Forum Anak Jawa Timur (FA Jatim)', 'Forum OSIS DKI Jakarta (FOS DKI)', 'Himpunan Osis Banten',
                            'Instagram @iggscholarship', 'Instagram @mncuniversity', 'Tiktok mncuniversity',
                            'Website Indonesian Gold Generation Scholarship', 'Website MNC University', 'Teman',
                            'Poster/Brosur IGGS', 'Sosialisasi Tim', 'Expo Campus', 'Lainnya'
                        ];
                    @endphp
                    @foreach($sources as $source)
                    <label class="flex items-center group cursor-pointer">
                        <input type="radio" name="info_sumber" value="{{ $source }}" class="w-5 h-5 border-gray-200 text-primary-gold focus:ring-primary-gold/20">
                        <span class="ml-3 text-sm font-semibold text-gray-600 group-hover:text-gray-900 transition-colors">{{ $source }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <hr class="border-gray-50">

            <!-- Question 2 -->
            <div class="space-y-6">
                <label class="block text-base font-bold text-gray-800 leading-relaxed">
                    Apa motivasi kamu mendaftar program Beasiswa MFLS?
                </label>
                <div class="space-y-4">
                    @php
                        $motivations = ['Biaya Kuliah (Beasiswa)', 'Akreditasi Kampus', 'Prospek Kerja', 'Fasilitas Pendidikan', 'Reputasi Universitas'];
                    @endphp
                    @foreach($motivations as $mot)
                    <label class="flex items-center group cursor-pointer">
                        <input type="checkbox" name="motivasi[]" value="{{ $mot }}" class="w-5 h-5 border-gray-200 rounded text-primary-gold focus:ring-primary-gold/20">
                        <span class="ml-3 text-sm font-semibold text-gray-600 group-hover:text-gray-900 transition-colors">{{ $mot }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <hr class="border-gray-50">

            <!-- Binary Questions -->
            <div class="space-y-10">
                @php
                    $binaryQuestions = [
                        ['id' => 'bersedia_informasi_lain', 'label' => 'Apakah kamu bersedia menerima informasi tentang jalur seleksi lainnya dari MNC University?'],
                        ['id' => 'daftar_beasiswa_lain', 'label' => 'Apakah kamu sedang mendaftar beasiswa lain?'],
                        ['id' => 'daftar_univ_lain', 'label' => 'Apakah kamu sedang mendaftar di Universitas selain MNC University?'],
                        ['id' => 'mengikuti_osis', 'label' => 'Apakah kamu mengikuti OSIS?'],
                        ['id' => 'mengikuti_forum_osis', 'label' => 'Apakah kamu mengikuti Forum OSIS Daerah/Provinsi?'],
                        ['id' => 'anggota_forum_anak', 'label' => 'Apakah Anggota Forum Anak?'],
                        ['id' => 'sudah_diterima_kampus_lain', 'label' => 'Apakah kamu sudah diterima di kampus lain?'],
                        ['id' => 'sudah_daftar_diterima_mncuniversity', 'label' => 'Apakah sudah mendaftar atau diterima di MNC University?'],
                    ];
                @endphp

                @foreach($binaryQuestions as $q)
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <label class="text-sm font-bold text-gray-800 flex-grow max-w-[60%]">{{ $q['label'] }}</label>
                    <div class="flex gap-8">
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="{{ $q['id'] }}" value="1" class="w-5 h-5 border-gray-200 text-primary-gold focus:ring-primary-gold/20">
                            <span class="ml-2 text-sm font-bold text-gray-600 group-hover:text-dark-navy">Ya</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="{{ $q['id'] }}" value="0" class="w-5 h-5 border-gray-200 text-primary-gold focus:ring-primary-gold/20">
                            <span class="ml-2 text-sm font-bold text-gray-600 group-hover:text-dark-navy">Tidak</span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Submit -->
            <div class="pt-6">
                <button type="submit" 
                    class="w-full bg-primary-gold hover:bg-primary-gold-hover text-dark-navy font-black py-4 rounded-2xl shadow-xl shadow-primary-gold/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    Kirim Survei
                </button>
            </div>
        </form>

        <div class="p-8 text-center border-t border-gray-50">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                Copyright ©2026 Indonesian Gold Generation Scholarship. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
