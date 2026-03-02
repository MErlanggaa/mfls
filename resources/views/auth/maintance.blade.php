@extends('layouts.auth')

@section('title', 'Daftar Akun')

@section('content')
<div class="mb-10 text-center lg:text-left">
    <h1 class="text-3xl font-black text-gray-900 mb-3">Pendaftaran Belum Dibuka!</h1>
    <p class="text-gray-500 font-medium">Mohon maaf, pendaftaran beasiswa MFLS 2026 belum dibuka saat ini.</p>
</div>

<div class="bg-gray-50 border border-gray-100 rounded-[2rem] p-8 md:p-12 text-center shadow-lg shadow-gray-200/50">
    <div class="w-24 h-24 bg-primary-gold/10 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-primary-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    
    <h2 class="text-2xl md:text-3xl font-black text-dark-navy mb-4">Harap Bersabar</h2>
    <p class="text-gray-600 mb-8 leading-relaxed max-w-md mx-auto">
        Pantau terus informasi terbaru melalui saluran WhatsApp dan Instagram resmi kami agar tidak ketinggalan jadwal pendaftarannya.
    </p>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="/" class="px-8 py-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full font-bold transition-all w-full sm:w-auto">
            Kembali ke Beranda
        </a>
        <a href="https://www.instagram.com/beasiswamncu/" target="_blank" class="px-8 py-4 bg-primary-gold hover:bg-primary-gold-hover text-white rounded-full font-bold shadow-lg hover:shadow-xl transition-all w-full sm:w-auto flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        </a>
    </div>
</div>


@endsection
