@extends('pendaftar.layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-10">
    <!-- Header Section -->
    <div class="relative overflow-hidden bg-navy-mnc p-10 md:p-14 rounded-[3rem] shadow-2xl border border-white/5">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary-orange opacity-10 blur-[80px] rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary-orange opacity-5 blur-[80px] rounded-full"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-8">
            <div class="p-6 bg-white/5 rounded-[2.5rem] backdrop-blur-xl border border-white/10 shadow-inner group transition-all duration-500 hover:border-primary-orange/30">
                <span class="iconify text-6xl text-primary-orange transition-transform duration-500 group-hover:scale-110" data-icon="solar:shield-keyhole-bold-duotone"></span>
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-3 tracking-tighter uppercase font-outfit">Pengaturan Akun</h1>
                <p class="text-lg text-gray-400 font-medium max-w-xl font-outfit uppercase tracking-widest opacity-80">Perbarui alamat email Anda untuk tetap terhubung dengan sistem MFLS.</p>
            </div>
        </div>
    </div>

    <!-- Change Email Form -->
    <div class="bg-white rounded-[3rem] p-10 md:p-14 shadow-xl border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-orange/5 rounded-bl-full translate-x-8 -translate-y-8 group-hover:scale-110 transition-transform duration-700"></div>
        
        <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-50">
            <div class="w-12 h-12 bg-primary-orange/10 rounded-2xl flex items-center justify-center text-primary-orange">
                <span class="iconify text-2xl" data-icon="solar:letter-bold-duotone"></span>
            </div>
            <div>
                <h3 class="text-2xl font-black text-navy-mnc font-outfit">Ubah Alamat Email</h3>
                <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">Gunakan email aktif akun Anda</p>
            </div>
        </div>

        <form action="{{ route('pendaftar.email.request') }}" method="POST" class="space-y-8" id="changeEmailForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Current Password (Verification) -->
                <div class="space-y-3">
                    <label class="block text-xs font-black text-navy-mnc uppercase tracking-widest ml-1">Password Saat Ini</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-orange transition-all duration-300">
                            <span class="iconify text-xl" data-icon="solar:lock-password-bold-duotone"></span>
                        </div>
                        <input type="password" name="current_password" required
                            class="w-full pl-12 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-orange/10 focus:border-primary-orange outline-none transition-all placeholder:text-gray-300 font-bold"
                            placeholder="Silakan masukkan password">
                    </div>
                </div>

                <!-- New Email -->
                <div class="space-y-3">
                    <label class="block text-xs font-black text-navy-mnc uppercase tracking-widest ml-1">Alamat Email Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-orange transition-all duration-300">
                            <span class="iconify text-xl" data-icon="solar:mailbox-bold-duotone"></span>
                        </div>
                        <input type="email" name="new_email" required
                            class="w-full pl-12 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-orange/10 focus:border-primary-orange outline-none transition-all placeholder:text-gray-300 font-bold"
                            placeholder="nama@emailbaru.com">
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" id="submitBtn"
                    class="w-full md:w-auto px-10 py-5 bg-navy-mnc hover:bg-[#003366] text-white font-black rounded-2xl shadow-xl shadow-navy-mnc/20 transition-all hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-3 group">
                    <span>Minta Kode Verifikasi</span>
                    <span class="iconify text-2xl group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-300" data-icon="solar:paper-plane-bold-duotone"></span>
                </button>
                <p class="mt-6 text-sm text-gray-400 font-bold font-outfit italic flex items-center gap-2">
                    <span class="iconify text-lg text-primary-orange" data-icon="solar:info-circle-bold-duotone"></span>
                    Kode OTP akan dikirimkan ke alamat email baru Anda.
                </p>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('changeEmailForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `<span class="iconify animate-spin text-2xl" data-icon="solar:refresh-bold-duotone"></span> <span>Memproses Permintaan...</span>`;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
    });
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Lanjutkan',
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
