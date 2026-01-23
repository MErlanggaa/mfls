@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-black text-gray-900 mb-3">Selamat Datang Kembali!</h1>
    <p class="text-gray-500 font-medium">Silakan masuk ke akun Anda untuk melanjutkan pendaftaran.</p>
</div>

<form action="/login" method="POST" class="space-y-6">
    @csrf
    <div>
        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
        <div class="relative">
            <input type="email" id="email" name="email" required
                class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 focus:border-primary-gold outline-none transition-all placeholder:text-gray-400 font-medium"
                placeholder="nama@email.com">
        </div>
    </div>

    <div>
        <div class="flex justify-between mb-2">
            <label for="password" class="text-sm font-bold text-gray-700">Password</label>
            <a href="#" class="text-xs font-bold text-primary-gold hover:underline">Lupa Password?</a>
        </div>
        <div class="relative">
            <input type="password" id="password" name="password" required
                class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-gold/10 focus:border-primary-gold outline-none transition-all placeholder:text-gray-400 font-medium"
                placeholder="••••••••">
        </div>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="remember" class="w-5 h-5 border-gray-200 rounded text-primary-gold focus:ring-primary-gold/20">
        <label for="remember" class="ml-3 text-sm font-semibold text-gray-600">Ingat Saya</label>
    </div>

    <button type="submit" 
        class="w-full bg-primary-gold hover:bg-primary-gold-hover text-dark-navy font-black py-4 rounded-2xl shadow-xl shadow-primary-gold/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
        Masuk Sekarang
    </button>

    <div class="relative py-4">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
        <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-4 text-gray-400 font-bold tracking-widest">Atau</span></div>
    </div>

    <button type="button" 
        class="w-full bg-white border border-gray-100 text-gray-700 font-bold py-4 rounded-2xl flex items-center justify-center gap-3 hover:bg-gray-50 transition-all">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5" alt="Google">
        Masuk dengan Google
    </button>
</form>

<p class="mt-10 text-center text-sm font-bold text-gray-500">
    Belum punya akun? 
    <a href="/register" class="text-primary-gold hover:underline">Daftar Sekarang</a>
</p>
@endsection
