@extends('pendaftar.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-2">Upload Berkas</h1>
                <p class="text-gray-500 font-medium">Unggah dokumen pendaftaran yang diperlukan</p>
            </div>
            <div class="w-16 h-16 bg-primary-gold/10 rounded-2xl flex items-center justify-center text-primary-gold">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>

        <div class="p-10 space-y-10">


            <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Main Documents -->
                <div class="mb-10">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary-gold/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        Dokumen Utama
                    </h3>

                    @php
                        $inputFiles = [
                            ['name' => 'foto', 'label' => 'Pas Foto 4x6', 'desc' => 'Latar belakang merah, JPG/PNG', 'multiple' => false, 'optional' => false],
                            ['name' => 'rapor1', 'label' => 'Rapor Semester 1', 'desc' => 'Scan PDF/JPG (Bisa > 1 file)', 'multiple' => true, 'optional' => false],
                            ['name' => 'rapor2', 'label' => 'Rapor Semester 2', 'desc' => 'Scan PDF/JPG (Bisa > 1 file)', 'multiple' => true, 'optional' => false],
                            ['name' => 'rapor3', 'label' => 'Rapor Semester 3', 'desc' => 'Scan PDF/JPG (Bisa > 1 file)', 'multiple' => true, 'optional' => false],
                            ['name' => 'rapor4', 'label' => 'Rapor Semester 4', 'desc' => 'Scan PDF/JPG (Bisa > 1 file)', 'multiple' => true, 'optional' => false],
                            ['name' => 'rapor5', 'label' => 'Rapor Semester 5', 'desc' => 'Scan PDF/JPG (Bisa > 1 file)', 'multiple' => true, 'optional' => false],
                            ['name' => 'ijazah', 'label' => 'Ijazah / SKL', 'desc' => 'Jika sudah ada (Opsional)', 'multiple' => false, 'optional' => true],
                        ];
                    @endphp
                    
                    @foreach($inputFiles as $file)
                    <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[2rem] border border-gray-100 group hover:border-primary-gold/50 transition-all mb-4 {{ $file['optional'] ? 'bg-blue-50/30' : '' }}">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-{{ $berkas && $berkas->{$file['name']} ? 'green-500' : 'gray-400' }} group-hover:text-primary-gold transition-colors shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-gray-900">{{ $file['label'] }}</h4>
                                    @if($file['optional'])
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Opsional</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Wajib</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 font-medium">{{ $file['desc'] }}</p>
                                @if($berkas && $berkas->{$file['name']})
                                    @php
                                        $val = $berkas->{$file['name']};
                                        // Try decode json
                                        $decoded = json_decode($val, true);
                                        $count = is_array($decoded) ? count($decoded) : 1;
                                    @endphp
                                    <p class="text-xs text-green-600 font-bold mt-1">✓ {{ $count }} File terunggah</p>
                                @else
                                    @if($file['optional'])
                                        <p class="text-xs text-blue-500 font-medium mt-1">Belum diunggah (Tidak wajib)</p>
                                    @else
                                        <p class="text-xs text-red-400 font-medium mt-1">Belum diunggah</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <input type="file" name="{{ $file['name'] }}{{ $file['multiple'] ? '[]' : '' }}" class="hidden" id="{{ $file['name'] }}" {{ $file['multiple'] ? 'multiple' : '' }} onchange="document.getElementById('btn-{{ $file['name'] }}').innerText = this.files.length + ' File Dipilih'">
                        <label for="{{ $file['name'] }}" id="btn-{{ $file['name'] }}" class="cursor-pointer bg-dark-navy text-white text-xs font-bold px-6 py-3 rounded-xl hover:bg-primary-gold hover:text-dark-navy transition-all">
                            {{ $berkas && $berkas->{$file['name']} ? 'Tambah/Ganti' : 'Pilih File' }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- Sertifikat Section -->
                <div class="mb-10">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        Sertifikat Prestasi
                    </h3>
                    
                    <div class="p-6 bg-blue-50/50 rounded-[2rem] border border-blue-100 mb-4">
                        <p class="text-sm text-gray-600 mb-4">Unggah sertifikat prestasi Anda (misal: Lomba tingkat Provinsi/Nasional). Anda dapat memilih banyak file sekaligus (gunakan CTRL+Klik).</p>
                        
                        <div class="flex items-center gap-4">
                            <input type="file" name="sertifikat[]" multiple class="block w-full text-sm text-slate-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100
                            "/>
                        </div>
                        
                        @if($sertifikats->count() > 0)
                        <div class="mt-4">
                            <h5 class="font-bold text-sm text-gray-800 mb-2">Sertifikat Terunggah:</h5>
                            <ul class="list-disc pl-5 text-xs text-gray-600">
                                @foreach($sertifikats as $s)
                                    <li>{{ $s->nama }} ({{ $s->tahun }}) <a href="{{ Storage::url($s->file) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Video Link (IG/TikTok) -->
                <div class="mb-10">
                   <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        Link Video Motivasi
                    </h3>
                    
                    <div class="bg-white p-6 rounded-[2rem] border border-purple-200">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Link Video (Instagram/TikTok/YouTube)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            </div>
                            <input type="url" name="motivasi_video" value="{{ old('motivasi_video', $berkas->motivasi_video ?? '') }}" placeholder="https://instagram.com/reel/... atau https://tiktok.com/@..." class="w-full pl-12 pr-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/20 outline-none transition-all">
                        </div>
                        <p class="text-xs text-gray-500 mt-2 ml-1">💡 Bisa dari Instagram Reels, TikTok, atau YouTube. Pastikan video bisa diakses publik!</p>
                        @if($berkas && $berkas->motivasi_video)
                            <div class="mt-3 p-3 bg-green-50 rounded-xl border border-green-100">
                                <p class="text-xs text-green-700 font-bold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Link video sudah tersimpan
                                </p>
                                <a href="{{ $berkas->motivasi_video }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                                    {{ Str::limit($berkas->motivasi_video, 50) }} →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-gray-100">
                    <button type="submit" class="w-full bg-primary-gold hover:bg-primary-gold/90 text-dark-navy font-bold py-4 rounded-2xl transition-all hover:scale-[1.02] shadow-lg shadow-primary-gold/20">
                        <span class="flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan & Unggah Dokumen
                        </span>
                    </button>
                    <p class="text-center text-xs text-gray-500 mt-3">Pastikan semua data sudah benar sebelum menyimpan</p>
                </div>
            </form>
        </div>
@endsection
