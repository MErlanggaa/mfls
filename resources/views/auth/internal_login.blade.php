@extends('layouts.auth')

@section('title', 'Internal System Login')

@section('content')
<div class="mb-10 text-center">
    <!-- Logo Alternative for Internal -->
    <div class="inline-flex items-center justify-center p-4 bg-dark-navy mb-6 rounded-2xl shadow-lg">
        <span class="text-white text-2xl font-black">MFLS <span class="text-primary-gold">ADMIN</span></span>
    </div>
    <h1 class="text-3xl font-black text-gray-900 mb-3">Portal Internal</h1>
    <p class="text-gray-500 font-medium">Akses khusus untuk Panitia, Mentor, dan Admin Akademik.</p>
</div>

<form action="{{ route('internal.login') }}" method="POST" class="space-y-6">
    @csrf
    
    <!-- Email Input -->
    <div>
        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Institusi</label>
        <div class="relative">
            <input type="email" id="email" name="email" required
                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-dark-navy/10 focus:border-dark-navy outline-none transition-all placeholder:text-gray-400 font-medium text-dark-navy"
                placeholder="admin@mfls.com">
        </div>
    </div>

    <!-- Password Input -->
    <div>
        <div class="flex justify-between mb-2">
            <label for="password" class="text-sm font-bold text-gray-700">Kode Akses</label>
        </div>
        <div class="relative">
            <input type="password" id="password" name="password" required
                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-dark-navy/10 focus:border-dark-navy outline-none transition-all placeholder:text-gray-400 font-medium text-dark-navy"
                placeholder="••••••••">
        </div>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="remember" class="w-5 h-5 border-gray-300 rounded text-dark-navy focus:ring-dark-navy/20">
        <label for="remember" class="ml-3 text-sm font-semibold text-gray-600">Tetap Masuk</label>
    </div>

    <!-- Submit Button (Dark Theme) -->
    <button type="submit" 
        class="w-full bg-dark-navy hover:bg-black text-white font-black py-4 rounded-2xl shadow-xl shadow-dark-navy/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
        Masuk Dashboard
    </button>
</form>

<p class="mt-10 text-center text-xs font-semibold text-gray-400">
    &copy; {{ date('Y') }} MFLS Internal System. Restricted Access.
</p>

<!-- SweetAlert Error Handling -->
@if(session('loginError'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Akses Ditolak!',
            text: "{{ session('loginError') }}",
            icon: 'error',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#111827',
        });
    });
</script>
@endif
@endsection
