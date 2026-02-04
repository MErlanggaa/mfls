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
            @php
                $docs = [
                    ['title' => 'Pas Foto 4x6', 'desc' => 'Latar belakang merah, format JPG/PNG', 'status' => 'Belum', 'type' => 'file'],
                    ['title' => 'Scan Rapor (Semester 1-5)', 'desc' => 'PDF gabungan semua semester', 'status' => 'Belum', 'type' => 'file'],
                    ['title' => 'Sertifikat Prestasi', 'desc' => 'Opsional, maksimal 3 file terbaik', 'status' => 'Belum', 'type' => 'file'],
                ];
                
                $links = [
                    ['title' => 'Link Video Motivasi Instagram', 'desc' => 'Upload video ke Instagram dan masukkan linknya (Durasi 2-3 menit)', 'placeholder' => 'https://instagram.com/p/...'],
                    ['title' => 'Link Video Motivasi TikTok', 'desc' => 'Upload video ke TikTok dan masukkan linknya (Durasi 2-3 menit)', 'placeholder' => 'https://tiktok.com/@username/video/...'],
                ];
            @endphp

            <!-- File Upload Section -->
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-primary-gold/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    Upload Dokumen
                </h3>
                
                @foreach($docs as $doc)
                <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[2rem] border border-gray-100 group hover:border-primary-gold/50 transition-all mb-4">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-gray-400 group-hover:text-primary-gold transition-colors shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $doc['title'] }}</h4>
                            <p class="text-xs text-gray-500 font-medium">{{ $doc['desc'] }}</p>
                        </div>
                    </div>
                    <button class="bg-dark-navy text-white text-xs font-bold px-6 py-3 rounded-xl hover:bg-primary-gold hover:text-dark-navy transition-all">
                        Pilih File
                    </button>
                </div>
                @endforeach
            </div>

            <!-- Link Collection Section -->
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </div>
                    Pengumpulan Link
                </h3>
                
                @foreach($links as $link)
                <div class="p-6 bg-blue-50/50 rounded-[2rem] border border-blue-100 mb-4">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500 mt-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-2">{{ $link['title'] }}</h4>
                            <p class="text-xs text-gray-600 font-medium mb-4">{{ $link['desc'] }}</p>
                            <input type="url" placeholder="{{ $link['placeholder'] }}" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none text-sm font-medium transition-all">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Motivation Essay Section -->
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    Essay Motivasi
                </h3>
                
                <div class="p-6 bg-green-50/50 rounded-[2rem] border border-green-100">
                    <div class="mb-4">
                        <h4 class="font-bold text-gray-900 mb-2">Upload Essay Motivasi Anda</h4>
                        <p class="text-xs text-gray-600 font-medium mb-4">
                            Upload file essay motivasi dalam format PDF atau DOC/DOCX. Essay harus berisi 300-500 kata yang menjelaskan motivasi dan tujuan Anda.
                        </p>
                        
                        <!-- Essay Guidelines -->
                        <div class="bg-white p-4 rounded-xl border border-green-200 mb-6">
                            <h5 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Panduan Penulisan Essay:
                            </h5>
                            <ul class="text-xs text-gray-600 space-y-1 ml-6 mb-4">
                                <li>• Ceritakan latar belakang dan kondisi keluarga Anda</li>
                                <li>• Jelaskan prestasi akademik dan non-akademik yang pernah diraih</li>
                                <li>• Sampaikan alasan memilih program studi yang diminati</li>
                                <li>• Uraikan rencana karir dan kontribusi untuk masyarakat</li>
                                <li>• Gunakan bahasa yang baik, benar, dan mudah dipahami</li>
                            </ul>
                            
                            <div class="flex items-center gap-4 text-xs">
                                <div class="flex items-center gap-2 text-green-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="font-semibold">Format: PDF, DOC, DOCX</span>
                                </div>
                                <div class="flex items-center gap-2 text-blue-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="font-semibold">Ukuran: Max 5MB</span>
                                </div>
                                <div class="flex items-center gap-2 text-purple-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z"/></svg>
                                    <span class="font-semibold">Panjang: 300-500 kata</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- File Upload Area -->
                        <div class="flex items-center justify-between p-6 bg-white rounded-[2rem] border-2 border-dashed border-green-200 group hover:border-green-400 transition-all">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 bg-green-500/10 rounded-2xl flex items-center justify-center text-green-500 group-hover:bg-green-500/20 transition-colors shadow-sm">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">Essay Motivasi</h4>
                                    <p class="text-xs text-gray-500 font-medium">PDF, DOC, atau DOCX - Maksimal 5MB</p>
                                    <p class="text-xs text-green-600 font-semibold mt-1">Belum ada file yang dipilih</p>
                                </div>
                            </div>
                            <button class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold px-6 py-3 rounded-xl transition-all shadow-lg shadow-green-500/20">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    Pilih File
                                </span>
                            </button>
                        </div>
                        
                        <!-- Template Download -->
                        <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-gray-800 text-sm">Template Essay Motivasi</h5>
                                        <p class="text-xs text-gray-600">Download template untuk memudahkan penulisan essay</p>
                                    </div>
                                </div>
                                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-gray-100">
                <button class="w-full bg-primary-gold hover:bg-primary-gold/90 text-dark-navy font-bold py-4 rounded-2xl transition-all hover:scale-[1.02] shadow-lg shadow-primary-gold/20">
                    <span class="flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Simpan Semua Data
                    </span>
                </button>
                <p class="text-center text-xs text-gray-500 mt-3">Pastikan semua data sudah benar sebelum menyimpan</p>
            </div>
        </div>
</div>
@endsection
