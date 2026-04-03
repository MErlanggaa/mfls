@extends('layouts.auth')

@section('title', 'Atur Ulang Password')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-black text-navy-mnc mb-3 font-outfit uppercase tracking-tighter">Atur Ulang Password</h1>
    <p class="text-gray-500 font-medium font-outfit">Silakan masukkan kata sandi baru Anda untuk dapat mengakses kembali portal pendaftar.</p>
</div>

<form action="{{ route('password.update') }}" method="POST" class="space-y-6" id="resetForm">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    
    <div>
        <label for="email" class="block text-sm font-bold text-navy-mnc mb-2 font-outfit uppercase tracking-wider">Email Akun</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-orange transition-colors">
                <i class="fas fa-envelope"></i>
            </div>
            <input type="email" id="email" name="email" value="{{ $email ?? request('email') }}" readonly
                class="w-full pl-11 pr-5 py-4 bg-gray-100 border border-gray-200 rounded-2xl outline-none transition-all text-gray-500 font-bold cursor-not-allowed"
                placeholder="nama@email.com">
        </div>
        @error('email')
            <p class="mt-2 text-sm text-red-500 font-bold italic">-- {{ $message }} --</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-bold text-navy-mnc mb-2 font-outfit uppercase tracking-wider">Password Baru</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-orange transition-colors">
                <i class="fas fa-lock"></i>
            </div>
            <input type="password" id="password" name="password" required
                class="w-full pl-11 pr-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-orange/10 focus:border-primary-orange outline-none transition-all placeholder:text-gray-400 font-medium"
                placeholder="••••••••">
        </div>
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-bold text-navy-mnc mb-2 font-outfit uppercase tracking-wider">Konfirmasi Password Baru</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-orange transition-colors">
                <i class="fas fa-shield-alt"></i>
            </div>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="w-full pl-11 pr-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-orange/10 focus:border-primary-orange outline-none transition-all placeholder:text-gray-400 font-medium"
                placeholder="••••••••">
        </div>
        @error('password')
            <p class="mt-2 text-sm text-red-500 font-bold italic">-- {{ $message }} --</p>
        @enderror
    </div>

    <button type="submit" id="submitBtn"
        class="w-full bg-navy-mnc hover:bg-[#003366] text-white font-black py-4 rounded-2xl shadow-xl shadow-navy-mnc/20 transition-all hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2 group">
        <span>Simpan Password Baru</span>
        <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
    </button>
</form>

<script>
    document.getElementById('resetForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `<i class="fas fa-circle-notch animate-spin"></i> <span>Menyimpan...</span>`;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
    });
</script>

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Gagal!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        });
    });
</script>
@endif

@endsection
