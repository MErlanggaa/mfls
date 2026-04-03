@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-black text-navy-mnc mb-3 font-outfit">Lupa Password?</h1>
    <p class="text-gray-500 font-medium font-outfit">Tenang, jangan panik. Masukkan email Anda dan kami akan mengirimkan link pemulihan.</p>
</div>

@if(session('status'))
    <div class="mb-6 p-4 bg-orange-50 border border-orange-100 text-primary-orange rounded-2xl font-bold flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        {{ session('status') }}
    </div>
@endif

<form action="{{ route('password.email') }}" method="POST" class="space-y-6" id="forgotForm">
    @csrf
    
    <div>
        <label for="email" class="block text-sm font-bold text-navy-mnc mb-2 font-outfit uppercase tracking-wider">Email Terdaftar</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-orange transition-colors">
                <i class="fas fa-envelope"></i>
            </div>
            <input type="email" id="email" name="email" required
                class="w-full pl-11 pr-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-orange/10 focus:border-primary-orange outline-none transition-all placeholder:text-gray-400 font-medium"
                placeholder="nama@email.com">
        </div>
        @error('email')
            <p class="mt-2 text-sm text-red-500 font-bold italic">-- {{ $message }} --</p>
        @enderror
    </div>

    <button type="submit" id="submitBtn"
        class="w-full bg-navy-mnc hover:bg-[#003366] text-white font-black py-4 rounded-2xl shadow-xl shadow-navy-mnc/20 transition-all hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2 group">
        <span>Kirim Link Pemulihan</span>
        <i class="fas fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
    </button>
</form>

<div class="mt-10 text-center">
    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-400 hover:text-primary-orange transition-colors flex items-center justify-center gap-2">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Login
    </a>
</div>

<script>
    document.getElementById('forgotForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `<i class="fas fa-circle-notch animate-spin"></i> <span>Mengirim...</span>`;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
    });
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Email Terkirim!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#001f3f'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Waduh!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'Coba Lagi',
            confirmButtonColor: '#d33',
        });
    });
</script>
@endif

@endsection
