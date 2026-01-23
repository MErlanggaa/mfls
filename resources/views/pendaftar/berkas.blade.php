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
                    ['title' => 'Pas Foto 4x6', 'desc' => 'Latar belakang merah, format JPG/PNG', 'status' => 'Belum'],
                    ['title' => 'Scan Rapor (Semester 1-5)', 'desc' => 'PDF gabungan semua semester', 'status' => 'Belum'],
                    ['title' => 'Sertifikat Prestasi', 'desc' => 'Opsional, maksimal 3 file terbaik', 'status' => 'Belum'],
                ];
            @endphp

            @foreach($docs as $doc)
            <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[2rem] border border-gray-100 group hover:border-primary-gold/50 transition-all">
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
    </div>
</div>
@endsection
