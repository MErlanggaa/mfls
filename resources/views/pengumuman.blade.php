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
                $isGagal = !$isLulus;
                $isProses = false;

                $headerColor = $isLulus ? 'bg-snbp-blue' : 'bg-snbp-red';
                $statusText = $isLulus ? 'SELAMAT! ANDA DINYATAKAN LULUS SELEKSI ADMINISTRASI' : 'ANDA DINYATAKAN TIDAK LULUS SELEKSI ADMINISTRASI';
            @endphp

            <div id="announcementCard"
                class="w-full max-w-lg overflow-hidden rounded-3xl shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)] transform transition-all duration-500 hover:scale-[1.01]">
                <!-- Card Header -->
                <div class="{{ $headerColor }} p-8 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 -skew-x-12 transform translate-x-1/2"></div>
                    <div class="relative z-10">
                        <img src="{{ asset('icon/logoo.png') }}" class="h-28 mx-auto mb-4 brightness-0 invert" alt="Logo">
                        <h3 class="text-white font-black text-lg md:text-xl leading-tight px-4">{{ $statusText }}</h3>

                        <p class="text-white/80 text-[10px] mt-3 font-medium uppercase tracking-wider">MNCU FUTURE LEADER
                            SCHOLARSHIP</p>

                    </div>
                </div>

                <!-- Card Body (Black Style) -->
                <div class="bg-snbp-black p-8 text-white relative">
                    <div class="flex flex-col md:flex-row gap-6 items-center md:items-start mb-8">
                        {{-- Foto 3x4 --}}
                        {{-- @php
                        $fotoPath = $peserta->berkas->foto ?? null;
                        $fotoUrl = $fotoPath ? asset('storage/' . $fotoPath) : "https://ui-avatars.com/api/?name=" .
                        urlencode($peserta->nama) . "&background=F97316&color=fff";
                        @endphp
                        <div
                            class="w-24 h-32 rounded-xl overflow-hidden shadow-lg border-2 border-white/20 flex-shrink-0 bg-slate-800">
                            <img src="{{ $fotoUrl }}" class="w-full h-full object-cover" alt="Foto {{ $peserta->nama }}">
                        </div> --}}
                        <div class="text-center md:text-left">
                            <p class="text-white/50 text-[10px] font-bold tracking-widest uppercase">NISN
                                {{ $peserta->nisn }} - NOREG {{ $peserta->id }}
                            </p>
                            <h4 class="text-2xl font-black mt-1 uppercase tracking-tight">{{ $peserta->nama }}</h4>
                            @if($isLulus)
                                <p class="text-amber-400 font-bold text-sm mt-1 uppercase">{{ $peserta->pilihan_prodi ?? '-' }}
                                </p>
                                <p class="text-white/70 text-xs font-medium">MNC UNIVERSITY</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 text-sm border-t border-white/10 pt-6">
                        <div class="flex flex-col">
                            <span class="text-white/40 text-[9px] font-bold uppercase tracking-widest">Tanggal Lahir</span>
                            <span class="font-bold">{{ $peserta->tgl_lahir ? \Carbon\Carbon::parse($peserta->tgl_lahir)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white/40 text-[9px] font-bold uppercase tracking-widest">Asal Sekolah</span>
                            <span class="font-bold uppercase">{{ $peserta->daftar->asal_sekolah ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white/40 text-[9px] font-bold uppercase tracking-widest">Kabupaten/Kota</span>
                            <span class="font-bold uppercase">{{ $peserta->kabupaten ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white/40 text-[9px] font-bold uppercase tracking-widest">Provinsi</span>
                            <span class="font-bold uppercase">{{ $peserta->provinsi ?? '-' }}</span>
                        </div>
                    </div>

                    @if($isLulus)
                        <div class="mt-8 pt-6 border-t border-white/10 text-center">
                            <p class="text-xs text-white/80 leading-relaxed italic text-center">
                                "Selamat atas pencapaian luar biasa Anda! Perjuangan Anda baru saja dimulai. Terus
                                pantau dashboard dan email Anda untuk informasi mengenai tahapan seleksi selanjutnya.
                                Tetap semangat!"
                            </p>

                        </div>
                    @elseif($isGagal)
                        <div class="mt-8 pt-6 border-t border-white/10 text-center">
                            <p class="text-xs text-white/50 leading-relaxed mb-6 px-4">
                                Jangan patah semangat! Masih ada kesempatan untuk bergabung bersama kami melalui jalur 
                                <span class="text-white font-bold">Beasiswa Mandiri</span>. Hubungi kami untuk informasi lebih lanjut:
                            </p>
                            
                            <div class="grid grid-cols-1 gap-3 px-2">
                                <a href="https://wa.me/6281181221792" target="_blank"
                                    class="flex items-center justify-between px-6 py-4 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 rounded-2xl text-emerald-400 font-bold text-xs transition-all group">
                                    <div class="flex items-center gap-3">
                                        <span class="iconify text-xl" data-icon="logos:whatsapp-icon"></span>
                                        <span class="text-left leading-tight font-black uppercase">Beasiswa Mandiri<br><span class="text-[11px] font-medium opacity-80 normal-case tracking-wider">0811-8122-1792</span></span>
                                    </div>
                                    <span class="iconify group-hover:translate-x-1 transition-transform" data-icon="solar:alt-arrow-right-bold"></span>
                                </a>

                                <a href="https://wa.me/6281181221791" target="_blank"
                                    class="flex items-center justify-between px-6 py-4 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 rounded-2xl text-emerald-400 font-bold text-xs transition-all group">
                                    <div class="flex items-center gap-3">
                                        <span class="iconify text-xl" data-icon="logos:whatsapp-icon"></span>
                                        <span class="text-left leading-tight font-black uppercase">Beasiswa Mandiri<br><span class="text-[11px] font-medium opacity-80 normal-case tracking-wider">0811-8122-1791</span></span>
                                    </div>
                                    <span class="iconify group-hover:translate-x-1 transition-transform" data-icon="solar:alt-arrow-right-bold"></span>
                                </a>
                            </div>

                            <a href="{{ route('pengumuman') }}"
                                class="inline-flex items-center gap-2 text-white/30 hover:text-white text-[10px] font-bold mt-8 uppercase tracking-widest transition-all">
                                <span class="iconify" data-icon="solar:arrow-left-bold"></span> Kembali Cek NISN
                            </a>
                        </div>
                    @else
                        <div class="mt-8 pt-6 border-t border-white/10 text-center">
                            <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-5">
                                <p class="text-xs text-amber-200 leading-relaxed font-bold">
                                    Berkas Anda telah kami terima dan sedang dalam antrean verifikasi. Silakan cek kembali
                                    secara berkala.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Card Footer (Integrated Share Button) -->
                <div class="bg-slate-50 p-4 no-capture flex items-center justify-center border-t border-slate-100">
                    <button onclick="captureAndShare()" id="btnCapture"
                        class="flex items-center gap-2 text-slate-500 hover:text-snbp-blue text-[10px] font-black uppercase tracking-widest transition-all">
                        <span class="iconify text-sm" data-icon="solar:share-bold"></span>
                        <span id="btnCaptureText">BAGIKAN HASIL SELEKSI</span>
                    </button>
                </div>
            </div>

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