@extends('layouts.auth')

@section('title', 'Verifikasi Email Baru')

@section('content')
<div class="mb-10 text-center md:text-left">
    <h1 class="text-3xl font-black text-navy-mnc mb-3 font-outfit uppercase tracking-tighter">Verifikasi Email Baru</h1>
    <p class="text-gray-500 font-medium font-outfit">Silakan masukkan kode OTP 6-digit yang telah kami kirimkan ke email baru Anda: <br><span class="text-primary-orange font-bold">{{ $newEmail }}</span></p>
</div>

<form action="{{ route('pendaftar.email.verify.post') }}" method="POST" class="space-y-8" id="otpForm">
    @csrf
    
    <div>
        <label for="otp" class="block text-center text-sm font-bold text-navy-mnc mb-6 font-outfit uppercase tracking-widest">Masukkan Kode OTP</label>
        <div class="flex justify-center gap-2 md:gap-4 group">
            <input type="text" name="otp" id="otp" maxlength="6" required
                class="w-full text-center px-4 py-6 bg-gray-50 border-2 border-gray-100 rounded-[2rem] focus:ring-8 focus:ring-primary-orange/10 focus:border-primary-orange outline-none transition-all placeholder:text-gray-200 font-black text-4xl tracking-[1rem] md:tracking-[2rem] uppercase font-outfit"
                placeholder="000000" autocomplete="off">
        </div>
        @error('otp')
            <p class="mt-4 text-center text-sm text-red-500 font-bold italic">-- {{ $message }} --</p>
        @enderror
    </div>

    <button type="submit" id="submitBtn"
        class="w-full bg-navy-mnc hover:bg-[#003366] text-white font-black py-4 rounded-2xl shadow-xl shadow-navy-mnc/20 transition-all hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-3 group">
        <span>Verifikasi & Simpan Email</span>
        <span class="iconify text-2xl group-hover:scale-110 transition-transform duration-300" data-icon="solar:check-circle-bold-duotone"></span>
    </button>
</form>

<div class="mt-10 pt-6 border-t border-gray-50 text-center">
    <p class="text-sm font-bold text-gray-400 font-outfit">
        Tidak menerima kode? 
        <a href="{{ route('pendaftar.email.change') }}" class="text-primary-orange hover:underline">Kirim Ulang Permintaan</a>
    </p>
</div>

<script>
    document.getElementById('otpForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `<span class="iconify animate-spin text-2xl" data-icon="solar:refresh-bold-duotone"></span> <span>Memverifikasi...</span>`;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
    });

    // Auto-focus and numeric only enhancement
    const otpInput = document.getElementById('otp');
    otpInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Verifikasi Gagal!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'Coba Lagi',
            confirmButtonColor: '#d33'
        });
    });
</script>
@endif

@endsection
