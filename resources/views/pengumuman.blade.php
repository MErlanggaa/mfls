<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PENGUMUMAN HASIL SELEKSI - MNCU Future Leader Scholarship 2026</title>

    <link rel="icon" type="image/png" href="{{ asset('icon/logoo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-snbp-blue: #00509d;
            --color-snbp-red: #d0021b;
            --color-snbp-black: #121212;
            --font-jakarta: "Plus Jakarta Sans", sans-serif;
        }
        @layer base {
            body { @apply font-jakarta bg-[#f0f4f8] antialiased min-h-screen flex flex-col; }
        }
        .bg-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.05;
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .watermark-map {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.03;
            width: 80%;
            z-index: -1;
            pointer-events: none;
        }
        /* Overrides for Image Capture Compatibility */
        #announcementCard, #announcementCard * {
            --tw-ring-color: rgba(0, 0, 0, 0) !important;
            --tw-shadow-color: rgba(0, 0, 0, 0.1) !important;
            --tw-shadow: none !important;
            --tw-ring-offset-shadow: none !important;
            --tw-ring-shadow: none !important;
            color-scheme: light !important;
        }
        .capture-mode #announcementCard {
            transform: none !important;
            transition: none !important;
        }
        .capture-mode .no-capture {
            display: none !important;
        }
    </style>
</head>

<body class="relative overflow-x-hidden pt-8 md:pt-12">
    <div class="bg-pattern"></div>
    <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Indonesia_blank_map.svg" class="watermark-map"
        alt="Watermark">

    <main class="flex-grow flex flex-col items-center justify-center p-4 md:p-8 relative z-10">

        <!-- Search Section (Only if no results yet) -->
        @if(!isset($peserta))
            <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl p-8 border border-slate-100">
                <div class="text-center mb-8">
                    <img src="{{ asset('icon/logoo.png') }}" class="h-24 mx-auto mb-6" alt="Logo">
                    <h2 class="text-2xl font-black text-slate-800">Cek Hasil Seleksi</h2>
                    <p class="text-slate-500 text-sm mt-1">Masukkan NISN Anda untuk melihat status kelulusan</p>
                </div>

                <form action="{{ route('pengumuman') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nomor Induk Siswa
                            Nasional (NISN)</label>
                        <input type="text" name="nisn" maxlength="20" placeholder="Contoh: 0049999XXX"
                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-snbp-blue focus:ring-0 transition-all font-bold text-lg text-slate-700 outline-none @error('nisn') border-red-500 @enderror"
                            value="{{ old('nisn') }}" required>
                        @error('nisn')
                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full bg-snbp-blue hover:bg-blue-900 text-white py-5 rounded-2xl font-black text-lg transition-all shadow-lg flex items-center justify-center gap-3">
                        <span class="iconify" data-icon="solar:magnifer-bold"></span> LIHAT HASIL
                    </button>
                </form>

                @if(session('error') || (request()->has('nisn') && !isset($peserta)))
                    <div class="mt-4 p-4 bg-red-50 text-red-600 rounded-xl text-center text-sm font-bold border border-red-100">
                        @if(session('error'))
                            {{ session('error') }}
                        @else
                            Data tidak ditemukan. Pastikan NISN yang Anda masukkan sudah benar.
                        @endif
                    </div>
                @endif
            </div>
        @else
            <!-- Result Section -->
            @php
                $status = $peserta->daftar->status ?? 'menunggu';
                $isLulus = ($status === 'lulus');
                $nominalBeasiswa = $peserta->daftar->nominal_beasiswa ?? null;
            @endphp

            <style>
                @keyframes shimmer {
                    0% { background-position: -200% center; }
                    100% { background-position: 200% center; }
                }
                @keyframes float {
                    0%, 100% { transform: translateY(0px) rotate(0deg); }
                    33% { transform: translateY(-8px) rotate(1deg); }
                    66% { transform: translateY(-4px) rotate(-1deg); }
                }
                @keyframes pulse-ring {
                    0% { transform: scale(1); opacity: 0.6; }
                    100% { transform: scale(1.6); opacity: 0; }
                }
                @keyframes fade-up {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .shimmer-text {
                    background: linear-gradient(90deg, #fbbf24 0%, #fef3c7 40%, #f59e0b 60%, #fbbf24 100%);
                    background-size: 200% auto;
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    animation: shimmer 3s linear infinite;
                }
                .card-float { animation: float 6s ease-in-out infinite; }
                .fade-up-1 { animation: fade-up 0.6s ease both; }
                .fade-up-2 { animation: fade-up 0.8s ease 0.15s both; }
                .fade-up-3 { animation: fade-up 0.8s ease 0.3s both; }
                .pulse-dot::after {
                    content: '';
                    position: absolute;
                    inset: 0;
                    border-radius: 9999px;
                    background: currentColor;
                    animation: pulse-ring 1.5s ease-out infinite;
                }
            </style>

            @if($isLulus)
            {{-- ===== LULUS CARD ===== --}}
            <div id="announcementCard" class="card-float w-full max-w-md">
                {{-- Glow backdrop --}}
                <div class="relative">
                    <div class="absolute -inset-4 rounded-[3rem] blur-2xl opacity-60 z-0"
                         style="background: {{ $nominalBeasiswa === '100%' ? 'radial-gradient(ellipse, #f59e0b, #d97706, transparent 70%)' : ($nominalBeasiswa === '75%' ? 'radial-gradient(ellipse, #10b981, #059669, transparent 70%)' : ($nominalBeasiswa === '50%' ? 'radial-gradient(ellipse, #3b82f6, #2563eb, transparent 70%)' : 'radial-gradient(ellipse, #8b5cf6, #7c3aed, transparent 70%)')) }}">
                    </div>

                    <div class="relative z-10 overflow-hidden rounded-[2.5rem] border border-white/10 shadow-2xl"
                         style="background: linear-gradient(160deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);">

                        {{-- Top glow line --}}
                        <div class="h-[3px] w-full"
                             style="background: {{ $nominalBeasiswa === '100%' ? 'linear-gradient(90deg, transparent, #fbbf24, #f59e0b, #fbbf24, transparent)' : ($nominalBeasiswa === '75%' ? 'linear-gradient(90deg, transparent, #34d399, #10b981, #34d399, transparent)' : ($nominalBeasiswa === '50%' ? 'linear-gradient(90deg, transparent, #60a5fa, #3b82f6, #60a5fa, transparent)' : 'linear-gradient(90deg, transparent, #a78bfa, #8b5cf6, #a78bfa, transparent)')) }}">
                        </div>

                        {{-- Header --}}
                        <div class="px-8 pt-8 pb-6 text-center fade-up-1">
                            <img src="{{ asset('icon/logoo.png') }}" class="h-16 mx-auto mb-6 brightness-0 invert opacity-90" alt="Logo">

                            <p class="text-white/30 text-[9px] font-black uppercase tracking-[0.4em] mb-3">MNCU Future Leader Scholarship 2026</p>

                            <h3 class="text-white font-black text-2xl leading-tight mb-1">🎉 SELAMAT!</h3>
                            <p class="text-white/50 text-sm font-medium">Anda dinyatakan sebagai</p>
                            <p class="text-white font-black text-lg uppercase tracking-widest mt-1">PENERIMA BEASISWA</p>
                        </div>

                        {{-- Big Scholarship Showcase --}}
                        @if(!empty($nominalBeasiswa))
                        <div class="mx-6 mb-6 fade-up-2">
                            <div class="relative rounded-3xl p-6 text-center overflow-hidden"
                                 style="background: {{ $nominalBeasiswa === '100%' ? 'linear-gradient(135deg, #451a03, #92400e, #451a03)' : ($nominalBeasiswa === '75%' ? 'linear-gradient(135deg, #022c22, #064e3b, #022c22)' : ($nominalBeasiswa === '50%' ? 'linear-gradient(135deg, #1e1b4b, #1e40af, #1e1b4b)' : 'linear-gradient(135deg, #2e1065, #4c1d95, #2e1065)')) }}; border: 1px solid {{ $nominalBeasiswa === '100%' ? 'rgba(251,191,36,0.3)' : ($nominalBeasiswa === '75%' ? 'rgba(52,211,153,0.3)' : ($nominalBeasiswa === '50%' ? 'rgba(96,165,250,0.3)' : 'rgba(167,139,250,0.3)')) }};">

                                {{-- Decorative orb --}}
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 rounded-full opacity-20 blur-2xl"
                                     style="background: {{ $nominalBeasiswa === '100%' ? '#fbbf24' : ($nominalBeasiswa === '75%' ? '#34d399' : ($nominalBeasiswa === '50%' ? '#60a5fa' : '#a78bfa')) }};">
                                </div>

                                <div class="relative z-10">
                                    <p class="text-[10px] font-black uppercase tracking-[0.4em] mb-2 opacity-60"
                                       style="color: {{ $nominalBeasiswa === '100%' ? '#fbbf24' : ($nominalBeasiswa === '75%' ? '#34d399' : ($nominalBeasiswa === '50%' ? '#60a5fa' : '#a78bfa')) }}">
                                        Nominal Beasiswa Diterima
                                    </p>
                                    <p class="shimmer-text font-black leading-none mb-2"
                                       style="font-size: 3.5rem; background: {{ $nominalBeasiswa === '100%' ? 'linear-gradient(90deg,#fbbf24 0%,#fef3c7 40%,#f59e0b 60%,#fbbf24 100%)' : ($nominalBeasiswa === '75%' ? 'linear-gradient(90deg,#34d399 0%,#d1fae5 40%,#10b981 60%,#34d399 100%)' : ($nominalBeasiswa === '50%' ? 'linear-gradient(90deg,#60a5fa 0%,#dbeafe 40%,#3b82f6 60%,#60a5fa 100%)' : 'linear-gradient(90deg,#a78bfa 0%,#ede9fe 40%,#8b5cf6 60%,#a78bfa 100%)')) }}; background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; animation: shimmer 3s linear infinite;">
                                        {{ $nominalBeasiswa }}
                                    </p>
                                    <p class="text-white/40 text-xs font-bold uppercase tracking-widest">
                                        @if($nominalBeasiswa === '100%') Beasiswa Penuh — Full Scholarship
                                        @elseif($nominalBeasiswa === '75%') Beasiswa Tiga Perempat
                                        @elseif($nominalBeasiswa === '50%') Beasiswa Setengah
                                        @else Beasiswa Parsial
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Identity & Info --}}
                        <div class="px-8 pb-6 fade-up-3">
                            <div class="border-t border-white/8 pt-6 mb-5">
                                <p class="text-white/20 text-[9px] font-black tracking-[0.3em] uppercase mb-1">NISN {{ $peserta->nisn }} &nbsp;·&nbsp; No. Reg. {{ $peserta->id }}</p>
                                <h4 class="text-white font-black text-xl uppercase tracking-tight leading-tight">{{ $peserta->nama }}</h4>
                                <p class="text-amber-400/80 font-semibold text-xs mt-1 uppercase tracking-wide">{{ $peserta->pilihan_prodi ?? '-' }} · MNC University</p>
                            </div>

                            <div class="grid grid-cols-3 gap-2 mb-6">
                                <div class="col-span-3 bg-white/4 rounded-2xl px-4 py-3 border border-white/5">
                                    <p class="text-white/20 text-[8px] font-black uppercase tracking-widest mb-0.5">Asal Sekolah</p>
                                    <p class="text-white font-bold text-xs uppercase">{{ $peserta->daftar->asal_sekolah ?? '-' }}</p>
                                </div>
                                <div class="col-span-2 bg-white/4 rounded-2xl px-4 py-3 border border-white/5">
                                    <p class="text-white/20 text-[8px] font-black uppercase tracking-widest mb-0.5">Kota</p>
                                    <p class="text-white font-bold text-xs uppercase">{{ $peserta->kabupaten ?? '-' }}</p>
                                </div>
                                <div class="bg-white/4 rounded-2xl px-4 py-3 border border-white/5">
                                    <p class="text-white/20 text-[8px] font-black uppercase tracking-widest mb-0.5">Lahir</p>
                                    <p class="text-white font-bold text-xs">{{ $peserta->tgl_lahir ? \Carbon\Carbon::parse($peserta->tgl_lahir)->format('d/m/Y') : '-' }}</p>
                                </div>
                            </div>

                            <p class="text-white/20 text-[10px] text-center leading-relaxed italic">
                                Pantau email & dashboard untuk informasi tahap selanjutnya.
                            </p>
                        </div>

                        {{-- Footer --}}
                        <div class="border-t border-white/5 px-8 py-4 no-capture flex items-center justify-center">
                            <button onclick="captureAndShare()" id="btnCapture"
                                class="flex items-center gap-2 text-white/20 hover:text-white/60 text-[10px] font-black uppercase tracking-widest transition-all">
                                <span class="iconify text-sm" data-icon="solar:share-bold"></span>
                                <span id="btnCaptureText">BAGIKAN</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @else
            {{-- ===== TIDAK LULUS CARD ===== --}}
            <div id="announcementCard" class="w-full max-w-md fade-up-1">
                <div class="overflow-hidden rounded-[2.5rem] border border-white/10 shadow-2xl"
                     style="background: linear-gradient(160deg, #1a0505 0%, #2d0a0a 100%);">

                    <div class="h-[3px] w-full" style="background: linear-gradient(90deg, transparent, #ef4444, #dc2626, #ef4444, transparent);"></div>

                    <div class="px-8 pt-8 pb-6 text-center">
                        <img src="{{ asset('icon/logoo.png') }}" class="h-16 mx-auto mb-6 brightness-0 invert opacity-80" alt="Logo">
                        <p class="text-white/30 text-[9px] font-black uppercase tracking-[0.4em] mb-3">MNCU Future Leader Scholarship 2026</p>
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-red-500/20 border border-red-500/30 flex items-center justify-center">
                            <span class="iconify text-red-400 text-2xl" data-icon="solar:close-circle-bold-duotone"></span>
                        </div>
                        <h3 class="text-white font-black text-xl leading-tight">TIDAK LOLOS SELEKSI</h3>
                        <p class="text-white/30 text-xs mt-2 font-medium">MNCU Future Leader Scholarship 2026</p>
                    </div>

                    <div class="px-8 pb-6">
                        <div class="border-t border-white/8 pt-5 mb-5">
                            <p class="text-white/20 text-[9px] font-black tracking-[0.3em] uppercase mb-1">NISN {{ $peserta->nisn }} · No. Reg. {{ $peserta->id }}</p>
                            <h4 class="text-white font-black text-xl uppercase">{{ $peserta->nama }}</h4>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-6">
                            <div class="bg-white/4 rounded-2xl p-3 border border-white/5 col-span-2">
                                <p class="text-white/20 text-[8px] font-black uppercase tracking-widest mb-0.5">Asal Sekolah</p>
                                <p class="text-white font-bold text-xs uppercase">{{ $peserta->daftar->asal_sekolah ?? '-' }}</p>
                            </div>
                            <div class="bg-white/4 rounded-2xl p-3 border border-white/5">
                                <p class="text-white/20 text-[8px] font-black uppercase tracking-widest mb-0.5">Kota</p>
                                <p class="text-white font-bold text-xs uppercase">{{ $peserta->kabupaten ?? '-' }}</p>
                            </div>
                            <div class="bg-white/4 rounded-2xl p-3 border border-white/5">
                                <p class="text-white/20 text-[8px] font-black uppercase tracking-widest mb-0.5">Lahir</p>
                                <p class="text-white font-bold text-xs">{{ $peserta->tgl_lahir ? \Carbon\Carbon::parse($peserta->tgl_lahir)->format('d/m/Y') : '-' }}</p>
                            </div>
                        </div>

                        <p class="text-white/30 text-xs leading-relaxed mb-4 text-center">Jangan patah semangat! Masih ada kesempatan melalui jalur <span class="text-white font-bold">Beasiswa Mandiri</span>.</p>

                        <div class="space-y-2">
                            <a href="https://wa.me/6281181221792" target="_blank"
                                class="flex items-center justify-between px-5 py-3.5 bg-emerald-500/8 hover:bg-emerald-500/15 border border-emerald-500/20 rounded-2xl text-emerald-400 transition-all group">
                                <div class="flex items-center gap-3">
                                    <span class="iconify text-lg" data-icon="logos:whatsapp-icon"></span>
                                    <span class="font-black text-[11px] uppercase">Beasiswa Mandiri <span class="font-medium opacity-70 normal-case"> — 0811-8122-1792</span></span>
                                </div>
                                <span class="iconify group-hover:translate-x-1 transition-transform" data-icon="solar:alt-arrow-right-bold"></span>
                            </a>
                            <a href="https://wa.me/6281181221791" target="_blank"
                                class="flex items-center justify-between px-5 py-3.5 bg-emerald-500/8 hover:bg-emerald-500/15 border border-emerald-500/20 rounded-2xl text-emerald-400 transition-all group">
                                <div class="flex items-center gap-3">
                                    <span class="iconify text-lg" data-icon="logos:whatsapp-icon"></span>
                                    <span class="font-black text-[11px] uppercase">Beasiswa Mandiri <span class="font-medium opacity-70 normal-case"> — 0811-8122-1791</span></span>
                                </div>
                                <span class="iconify group-hover:translate-x-1 transition-transform" data-icon="solar:alt-arrow-right-bold"></span>
                            </a>
                        </div>
                        <div class="text-center mt-6">
                            <a href="{{ route('pengumuman') }}" class="inline-flex items-center gap-2 text-white/20 hover:text-white text-[10px] font-bold uppercase tracking-widest transition-all">
                                <span class="iconify" data-icon="solar:arrow-left-bold"></span> Cek NISN Lain
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-white/5 px-8 py-4 no-capture flex items-center justify-center">
                        <button onclick="captureAndShare()" id="btnCapture"
                            class="flex items-center gap-2 text-white/20 hover:text-white/60 text-[10px] font-black uppercase tracking-widest transition-all">
                            <span class="iconify text-sm" data-icon="solar:share-bold"></span>
                            <span id="btnCaptureText">BAGIKAN</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
            <p class="mt-8 text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">© 2026 MNCU FUTURE LEADER
                SCHOLARSHIP</p>
        @endif
    </main>

    <!-- Script Section -->
    <script>
        // Data Peserta untuk PDF
        @if(isset($peserta))
            window.PESERTA_DATA = {
                nama: "{{ $peserta->nama }}",
                nisn: "{{ $peserta->nisn }}",
                noPendaftaran: "{{ $peserta->id }}",
                sekolah: "{{ $peserta->daftar->asal_sekolah ?? '-' }}",
                prodi: "{{ explode(' | ', $peserta->pilihan_prodi ?? '')[0] ?? '-' }}",
                fakultas: "MNC UNIVERSITY",
                tanggal: "{{ date('d F Y') }}",
                noSurat: "MNCU/MFLS/2026/{{ str_pad($peserta->id, 4, '0', STR_PAD_LEFT) }}"
            };
            console.log('Capture library loaded:', typeof domtoimage !== 'undefined' ? 'domtoimage' : 'none');
        @endif

            async function shareResult(name, status) {
                const shareData = {
                    title: 'Hasil Seleksi MFLS 2026',
                    text: `Saya ${name} dinyatakan ${status} Seleksi Administrasi MNCU Future Leader Scholarship 2026!`,
                    url: window.location.href
                };
                try {
                    if (navigator.share) {
                        await navigator.share(shareData);
                    } else {
                        await navigator.clipboard.writeText(`${shareData.text} ${shareData.url}`);
                        alert('Teks pengumuman telah disalin!');
                    }
                } catch (err) { }
            }

            async function captureAndShare() {
                const card = document.getElementById('announcementCard');
                const btn = document.getElementById('btnCapture');
                const btnText = document.getElementById('btnCaptureText');
                const originalText = btnText.textContent;

                try {
                    btn.disabled = true;
                    btnText.textContent = "MEMPROSES...";

                    // Add capture class to body to freeze animations/transforms
                    document.body.classList.add('capture-mode');
                    await new Promise(r => setTimeout(r, 200));

                    // Force standard colors for capture to avoid oklab errors
                    const cardClone = card.cloneNode(true);
                    cardClone.style.backgroundColor = '#121212'; // fallback

                    const dataUrl = await htmlToImage.toPng(card, {
                        pixelRatio: 2,
                        backgroundColor: '#f0f4f8',
                        cacheBust: true,
                        // Filter out external resources that might cause CORS/Parsing issues
                        filter: (node) => {
                            if (node.tagName === 'LINK' && node.rel === 'stylesheet') return false;
                            return true;
                        }
                    });

                    document.body.classList.remove('capture-mode');

                    const response = await fetch(dataUrl);
                    const imageBlob = await response.blob();
                    const fileName = `Hasil_MFLS_2026_${window.PESERTA_DATA.nisn}.png`;
                    const file = new File([imageBlob], fileName, { type: 'image/png' });

                    // Try to share the file if supported
                    if (navigator.canShare && navigator.canShare({ files: [file] })) {
                        await navigator.share({
                            files: [file],
                            title: 'Hasil Seleksi MFLS 2026',
                            text: `Hasil Seleksi MNCU Future Leader Scholarship 2026 - ${window.PESERTA_DATA.nama}`
                        });
                    } else {
                        // Fallback to download
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(imageBlob);
                        link.download = fileName;
                        link.click();
                        alert('Gambar telah diunduh. Silakan bagikan secara manual.');
                    }
                } catch (error) {
                    console.error('Sharing failed', error);
                    alert('Gagal memproses gambar. Silakan coba lagi.');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                }
            }


    </script>
</body>

</html>