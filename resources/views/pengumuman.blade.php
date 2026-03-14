@extends('layouts.user')

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        #graduation-letter, #graduation-letter * { visibility: visible; }
        #graduation-letter {
            position: absolute; left: 0; top: 0;
            width: 100%; background: white; color: black;
            padding: 0; margin: 0;
        }
    }
    #graduation-letter { display: none; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(!request('nisn') || !isset($peserta))
        <!-- Form Input NISN -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pengumuman Hasil Seleksi</h1>
                    <p class="text-blue-100">MNCU Future Leader Scholarship (MFLS) 2026</p>
                </div>
            </div>

            <div class="p-8">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-8">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <h3 class="font-semibold text-blue-900 mb-1">Informasi Penting</h3>
                            <p class="text-blue-800 text-sm">Masukkan NISN Anda untuk melihat hasil seleksi administrasi berkas MFLS 2026. Pastikan NISN yang dimasukkan sesuai dengan data yang Anda daftarkan.</p>
                        </div>
                    </div>
                </div>

                <div class="max-w-md mx-auto">
                    <form method="GET" action="{{ url('/pengumuman') }}" class="space-y-6">
                        <div>
                            <label for="nisn" class="block text-sm font-bold text-gray-900 mb-3">Nomor Induk Siswa Nasional (NISN)</label>
                            <input type="text" id="nisn" name="nisn"
                                placeholder="Masukkan 10 digit NISN Anda"
                                class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all text-center font-mono"
                                maxlength="10" pattern="[0-9]{10}" required value="{{ request('nisn') }}">
                            <p class="text-xs text-gray-500 mt-2 text-center">Contoh: 0012345678</p>
                        </div>

                        @if(request('nisn') && !isset($peserta))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-red-700 text-sm font-medium">NISN tidak ditemukan. Pastikan NISN yang Anda masukkan benar dan sudah terdaftar.</p>
                            </div>
                        </div>
                        @endif

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl transition-all hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Cek Hasil Seleksi
                            </span>
                        </button>
                    </form>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600 mb-2"><strong>Pengumuman Resmi:</strong> Senin, 7 Mei 2026 - 15:00 WIB</p>
                    <p class="text-xs text-gray-500">Untuk bantuan, hubungi panitia di info@beasiswamncu.com atau +62 858-8005-9189</p>
                </div>
            </div>
        </div>

        @else
        <!-- Hasil Pengumuman -->
        @php
            $dbStatus = $peserta->daftar->status ?? 'menunggu';
            if ($dbStatus === 'lulus') {
                $status = 'lulus';
            } elseif ($dbStatus === 'tidak lulus' || $dbStatus === 'gugur') {
                $status = 'tidak_lulus';
            } else {
                $status = 'pending';
            }
            $noPendaftaran = 'MFLS2026' . str_pad($peserta->id, 4, '0', STR_PAD_LEFT);
            $noSurat = date('Y') . '/MFLS-ADM/SKL/' . str_pad($peserta->id, 4, '0', STR_PAD_LEFT);
            $prodi = strtolower($peserta->pilihan_prodi);
            $fakultas = 'LAINNYA';
            if (in_array($prodi, ['manajemen', 'akuntansi', 'pendidikan matematika'])) {
                $fakultas = 'BISNIS DAN KEUANGAN';
            } elseif (in_array($prodi, ['pendidikan bahasa inggris', 'sains komunikasi', 'desain komunikasi visual', 'ilmu komputer', 'sistem informasi'])) {
                $fakultas = 'INDUSTRI DAN KREATIF';
            }
        @endphp

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Pengumuman</h2>
                        <p class="text-blue-100 text-sm">Hasil Seleksi Administrasi MFLS 2026</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="mb-8">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <h3 class="font-semibold text-blue-900 mb-1">Informasi Penting</h3>
                                <p class="text-blue-800 text-sm">Hasil seleksi administrasi berkas telah selesai diverifikasi. Silakan cek status kelulusan Anda di bawah ini.</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">HASIL SELEKSI ADMINISTRASI BERKAS</h3>
                        <p class="text-gray-600">MNCU Future Leader Scholarship (MFLS) 2026</p>
                        <div class="w-24 h-1 bg-blue-500 mx-auto mt-3 rounded-full"></div>
                    </div>
                </div>

                <!-- Data Peserta -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Data Peserta
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Nama Lengkap</span>
                                <span class="font-semibold text-gray-900">{{ strtoupper($peserta->nama) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">No. Pendaftaran</span>
                                <span class="font-semibold text-gray-900">{{ $noPendaftaran }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">NISN</span>
                                <span class="font-semibold text-gray-900">{{ $peserta->nisn }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Asal Sekolah</span>
                                <span class="font-semibold text-gray-900">{{ strtoupper($peserta->nama_sekolah ?? '-') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Program Studi</span>
                                <span class="font-semibold text-gray-900">{{ strtoupper($peserta->pilihan_prodi ?? '-') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Fakultas</span>
                                <span class="font-semibold text-gray-900">{{ $fakultas }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Kelulusan -->
                @if($status === 'lulus')
                <div class="border-2 border-green-500 rounded-lg p-6 mb-8 bg-green-50">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-green-700 mb-2">SELAMAT!</h3>
                        <p class="text-lg font-semibold text-green-600 mb-4">ANDA DINYATAKAN LULUS</p>
                        <p class="text-green-700">Seleksi Administrasi Berkas</p>
                    </div>
                </div>

                <div class="bg-white border border-green-200 rounded-lg p-6 mb-8">
                    <h4 class="font-bold text-gray-900 mb-3">Keterangan:</h4>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start gap-2"><div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div><span>Berkas administrasi Anda telah diverifikasi dan dinyatakan <strong>LENGKAP</strong></span></li>
                        <li class="flex items-start gap-2"><div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div><span>Anda <strong>BERHAK</strong> mengikuti tahap seleksi berikutnya</span></li>
                        <li class="flex items-start gap-2"><div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div><span>Silakan persiapkan diri untuk mengikuti tes selanjutnya</span></li>
                    </ul>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                    <h4 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Jadwal Seleksi Berikutnya
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white rounded border">
                            <div><p class="font-semibold text-gray-900">TPS, LBI & Pemetaan Diri</p><p class="text-sm text-gray-600">Tes Potensi Skolastik dan Literasi</p></div>
                            <div class="text-right"><p class="font-bold text-blue-600">18 Mei 2026</p><p class="text-sm text-gray-500">08:00 - 12:00 WIB</p></div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded border">
                            <div><p class="font-semibold text-gray-900">Interview User & Presentasi</p><p class="text-sm text-gray-600">Wawancara dan Mini Project</p></div>
                            <div class="text-right"><p class="font-bold text-blue-600">20 Mei 2026</p><p class="text-sm text-gray-500">09:00 - 17:00 WIB</p></div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded border">
                            <div><p class="font-semibold text-gray-900">Company Visit & Sit In Class</p><p class="text-sm text-gray-600">Kunjungan Kampus dan Observasi</p></div>
                            <div class="text-right"><p class="font-bold text-blue-600">21-22 Mei 2026</p><p class="text-sm text-gray-500">08:00 - 16:00 WIB</p></div>
                        </div>
                    </div>
                </div>

                @elseif($status === 'tidak_lulus')
                <div class="border-2 border-red-500 rounded-lg p-6 mb-8 bg-red-50">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-red-700 mb-2">MOHON MAAF</h3>
                        <p class="text-lg font-semibold text-red-600 mb-4">BERKAS BELUM MEMENUHI SYARAT</p>
                        <p class="text-red-700">Seleksi Administrasi Berkas</p>
                    </div>
                </div>
                <div class="bg-white border border-red-200 rounded-lg p-6 mb-8">
                    <h4 class="font-bold text-gray-900 mb-3">Keterangan:</h4>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start gap-2"><div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div><span>Berkas administrasi Anda <strong>BELUM LENGKAP</strong> atau tidak sesuai persyaratan</span></li>
                        <li class="flex items-start gap-2"><div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div><span>Silakan perbaiki dan lengkapi berkas sesuai panduan</span></li>
                        <li class="flex items-start gap-2"><div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div><span>Anda dapat mendaftar kembali pada periode berikutnya</span></li>
                    </ul>
                </div>

                @else
                <div class="border-2 border-yellow-500 rounded-lg p-6 mb-8 bg-yellow-50">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-yellow-700 mb-2">DALAM PROSES</h3>
                        <p class="text-lg font-semibold text-yellow-600 mb-4">VERIFIKASI BERKAS</p>
                        <p class="text-yellow-700">Mohon tunggu hasil verifikasi</p>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    @if($status === 'lulus')
                    <button id="btnDownloadPDF" onclick="generatePDF()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center gap-2 shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span id="btnDownloadText">Unduh Surat Kelulusan (PDF)</span>
                    </button>
                    @elseif($status === 'tidak_lulus')
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Perbaiki Berkas
                    </button>
                    @endif

                    <button onclick="shareResult('{{ strtoupper($peserta->nama) }}', '{{ $status === 'lulus' ? 'LULUS' : 'TIDAK LULUS' }}')" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/></svg>
                        Bagikan Hasil
                    </button>
                </div>

                <div class="text-center mb-8">
                    <a href="{{ url('/pengumuman') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Cek NISN Lain
                    </a>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <div class="text-center text-sm text-gray-600">
                        <p class="mb-2"><strong>Tanggal Pengumuman:</strong> Senin, 7 Mei 2026 - 14:00 WIB</p>
                        <p class="mb-4">Untuk informasi lebih lanjut, hubungi Panitia MFLS 2026</p>
                        <div class="flex flex-wrap justify-center items-center gap-5 text-xs">
                            <a href="https://wa.me/6285880059189" target="_blank" class="flex items-center gap-1.5 text-gray-600 hover:text-green-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                +62 858-8005-9189
                            </a>
                            <a href="mailto:info@beasiswamncu.com" class="flex items-center gap-1.5 text-gray-600 hover:text-blue-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                info@beasiswamncu.com
                            </a>
                            <a href="https://instagram.com/beasiswamncu" target="_blank" class="flex items-center gap-1.5 text-gray-600 hover:text-pink-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                @beasiswamncu
                            </a>
                            <a href="https://beasiswamncu.com" target="_blank" class="flex items-center gap-1.5 text-gray-600 hover:text-blue-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                beasiswamncu.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- ======================================================
     DATA untuk PDF (hanya render jika status lulus)
     ====================================================== --}}
@if(isset($peserta) && ($peserta->daftar->status ?? '') === 'lulus')
<script>
    // Data peserta disuntikkan dari server ke JS
    window.PESERTA_DATA = {
        nama: "{{ strtoupper($peserta->nama) }}",
        nisn: "{{ $peserta->nisn }}",
        noPendaftaran: "{{ $noPendaftaran }}",
        noSurat: "{{ $noSurat }}",
        sekolah: "{{ strtoupper($peserta->nama_sekolah ?? '-') }}",
        prodi: "{{ strtoupper($peserta->pilihan_prodi ?? '-') }}",
        fakultas: "{{ $fakultas }}",
        tanggal: "{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}"
    };
</script>
@endif

{{-- ======================================================
     JS Libraries & PDF Generator
     ====================================================== --}}
<!-- jsPDF via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
// ─── Auto-format NISN ────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const nisnInput = document.getElementById('nisn');
    if (nisnInput) {
        nisnInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
});

// ─── Helpers ─────────────────────────────────────────────────────────────────
function loadImageAsBase64(url) {
    return new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width  = img.naturalWidth;
            canvas.height = img.naturalHeight;
            canvas.getContext('2d').drawImage(img, 0, 0);
            resolve({
                data: canvas.toDataURL('image/png'),
                ratio: img.naturalWidth / img.naturalHeight
            });
        };
        img.onerror = () => resolve(null); // fallback: no logo
        img.src = url + '?t=' + Date.now(); // cache-bust
    });
}

// ─── PDF Generator ───────────────────────────────────────────────────────────
async function generatePDF(){

const btn = document.getElementById('btnDownloadPDF');
const btnText = document.getElementById('btnDownloadText');
const d = window.PESERTA_DATA;

if(!d){
alert("Data peserta tidak ditemukan");
return;
}

btn.disabled = true;
btnText.textContent = "Membuat PDF...";

const { jsPDF } = window.jspdf;
const doc = new jsPDF("p","mm","a4");

const logoRes = await loadImageAsBase64('{{ asset('icon/logoo.png') }}');
const ttdRes = await loadImageAsBase64('{{ asset('icon/ttd.jpeg') }}');

const marginLeft = 30;
const marginRight = 180;
const contentWidth = marginRight - marginLeft;

let y = 22;

/* ================= HEADER ================= */

if(logoRes){
const logoW = 40;
const logoH = logoW / logoRes.ratio;
// Posisi logo di kiri (marginLeft)
doc.addImage(logoRes.data,"PNG", marginLeft, 15, logoW, logoH);
}

// Teks di sebelah kanan logo (bukan center)
const textX = marginLeft + 30; // posisi teks di sebelah kanan logo
doc.setFont("times","bold");
doc.setFontSize(16);
doc.text("MNC UNIVERSITY", textX, 22);

doc.setFont("times","normal");
doc.setFontSize(10);
doc.text("Jl. Panjang Blok A8, Kedoya Utara, Jakarta Barat", textX, 27);
doc.text("info@beasiswamncu.com | beasiswamncu.com", textX, 32);

doc.setLineWidth(0.5);
doc.line(marginLeft, 38, marginRight, 38);
doc.setLineWidth(0.2); // reset line width

y = 48;

/* ================= JUDUL ================= */

doc.setFont("times","bold");
doc.setFontSize(14);
doc.text("PENGUMUMAN HASIL SELEKSI ADMINISTRASI",105,y,{align:"center"});

y += 6;

doc.setFont("times","normal");
doc.setFontSize(11);
doc.text("MNCU Future Leader Scholarship (MFLS) 2026",105,y,{align:"center"});

y += 14;

/* ================= NOMOR ================= */

doc.setFontSize(11);

doc.text(`Nomor : ${d.noSurat}`,marginLeft,y);
y+=7;

doc.text(`Tanggal : Jakarta, ${d.tanggal}`,marginLeft,y);

y += 14;

/* ================= PEMBUKA ================= */

const pembuka = doc.splitTextToSize(
"Panitia Seleksi MNCU Future Leader Scholarship (MFLS) 2026 dengan ini menerangkan bahwa:",
contentWidth
);

doc.text(pembuka,marginLeft,y,{maxWidth:contentWidth});

y += pembuka.length * 6 + 6;

/* ================= DATA PESERTA ================= */

const labelX = marginLeft + 5;
const valueX = marginLeft + 60;

doc.setFontSize(11);

/* Nama */
doc.setFont("times","normal");
doc.text("Nama Lengkap",labelX,y);
doc.text(":",valueX-3,y);

doc.setFont("times","bold");
doc.text(d.nama,valueX,y);
y+=7;

/* NISN */
doc.setFont("times","normal");
doc.text("NISN",labelX,y);
doc.text(":",valueX-3,y);

doc.setFont("times","bold");
doc.text(d.nisn,valueX,y);
y+=7;

/* No */
doc.setFont("times","normal");
doc.text("No Pendaftaran",labelX,y);
doc.text(":",valueX-3,y);

doc.setFont("times","bold");
doc.text(d.noPendaftaran,valueX,y);
y+=7;

/* Sekolah */
doc.setFont("times","normal");
doc.text("Asal Sekolah",labelX,y);
doc.text(":",valueX-3,y);

doc.setFont("times","bold");
doc.text(d.sekolah,valueX,y);
y+=7;

/* Prodi */
doc.setFont("times","normal");
doc.text("Program Studi",labelX,y);
doc.text(":",valueX-3,y);

doc.setFont("times","bold");
doc.text(d.prodi,valueX,y);
y+=7;

/* Fakultas */
doc.setFont("times","normal");
doc.text("Fakultas",labelX,y);
doc.text(":",valueX-3,y);

doc.setFont("times","bold");
doc.text(d.fakultas,valueX,y);

y += 14;

/* ================= STATUS ================= */

let status = "{{ $status ?? '' }}";

doc.setFont("times","bold");
doc.setFontSize(13);

if(status === "lulus"){
doc.setTextColor(0,130,0);
doc.text("LULUS SELEKSI ADMINISTRASI",105,y,{align:"center"});
}else{
doc.setTextColor(200,0,0);
doc.text("TIDAK LULUS SELEKSI ADMINISTRASI",105,y,{align:"center"});
}

doc.setTextColor(0,0,0);

y += 12;

/* ================= PARAGRAF ================= */

doc.setFont("times","normal");
doc.setFontSize(11);

const isi = doc.splitTextToSize(
"Berdasarkan hasil verifikasi berkas administrasi yang telah dilakukan oleh Panitia MNCU Future Leader Scholarship 2026, peserta dinyatakan telah memenuhi seluruh persyaratan administrasi dan berhak melanjutkan ke tahap seleksi berikutnya.",
contentWidth
);

doc.text(isi,marginLeft,y,{maxWidth:contentWidth});

y += isi.length * 6 + 8;

/* ================= JADWAL ================= */

if(status === "lulus"){

doc.setFont("times","bold");
doc.text("Jadwal Tahap Seleksi Berikutnya",marginLeft,y);

y+=8;

const col1=40;
const col2=80;
const col3=40;

const jadwal=[
["Tanggal","Kegiatan","Waktu"],
["18 Mei 2026","TPS, LBI & Pemetaan Diri","08:00 - 12:00 WIB"],
["20 Mei 2026","Interview User & Presentasi","09:00 - 17:00 WIB"],
["21 - 22 Mei 2026","Company Visit & Sit In Class","08:00 - 16:00 WIB"]
];

jadwal.forEach((row,i)=>{

doc.rect(marginLeft,y-5,col1,9);
doc.rect(marginLeft+col1,y-5,col2,9);
doc.rect(marginLeft+col1+col2,y-5,col3,9);

doc.setFont("times",i==0?"bold":"normal");

doc.text(row[0],marginLeft+2,y);
doc.text(row[1],marginLeft+col1+2,y);
doc.text(row[2],marginLeft+col1+col2+2,y);

y+=9;

});

}

y += 12;

/* ================= PENUTUP ================= */

doc.setFont("times","normal");

doc.text(
"Demikian pengumuman ini disampaikan untuk dapat digunakan sebagaimana mestinya.",
marginLeft,
y
);

y += 15;

/* ================= TANDA TANGAN ================= */

doc.setFontSize(11);
doc.text("Jakarta, " + d.tanggal, marginRight - 50, y, {align:"left"});
y += 5;
doc.text("Panitia Beasiswa MFLS 2026", marginRight - 50, y, {align:"left"});

y += 5;

// Tambahkan gambar tanda tangan jika ada
if(ttdRes){
    const ttdW = 30;
    const ttdH = ttdW / ttdRes.ratio;
    doc.addImage(ttdRes.data, "PNG", marginRight - 55, y, ttdW, ttdH);
    y += ttdH + 2;
}else{
    y += 20;
}

doc.setFont("times","bold");
doc.text("TIM ADMISI MNC UNIVERSITY", marginRight - 55, y);

/* ================= FOOTER ================= */

doc.setFontSize(9);

doc.text("Informasi lebih lanjut:",marginLeft,270);
doc.text("WhatsApp: +62 858-8005-9189 | Instagram: @beasiswamncu",marginLeft,276);
doc.text("Website: beasiswamncu.com",marginLeft,282);

doc.save("Pengumuman_MFLS_"+d.nisn+".pdf");

btn.disabled=false;
btnText.textContent="Unduh Surat Kelulusan (PDF)";

}


// ─── Share ────────────────────────────────────────────────────────────────────
async function shareResult(name, status) {
    const shareData = {
        title: 'Pengumuman Hasil Seleksi MFLS 2026',
        text: `Saya ${name} dinyatakan ${status} Seleksi Administrasi Berkas MFLS 2026!`,
        url: window.location.href
    };
    try {
        if (navigator.share) {
            await navigator.share(shareData);
        } else {
            await navigator.clipboard.writeText(`${shareData.text} ${shareData.url}`);
            alert('Link pengumuman telah disalin ke clipboard!');
        }
    } catch (err) {
        console.error('Error sharing:', err);
    }
}
</script>
@endsection