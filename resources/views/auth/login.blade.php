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

    {{-- <div class="relative py-4">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
        <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-4 text-gray-400 font-bold tracking-widest">Atau</span></div>
    </div>

    <button type="button" 
        class="w-full bg-white border border-gray-100 text-gray-700 font-bold py-4 rounded-2xl flex items-center justify-center gap-3 hover:bg-gray-50 transition-all">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5" alt="Google">
        Masuk dengan Google
    </button> --}}
</form>

<p class="mt-10 text-center text-sm font-bold text-gray-500">
    Belum punya akun? 
    <a href="/register" class="text-primary-gold hover:underline">Daftar Sekarang</a>
</p>
@endsection

<script>
// Cookie Management Functions
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function deleteCookie(name) {
    document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;`;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const saveEmailCheckbox = document.getElementById('save_email');
    const rememberCheckbox = document.getElementById('remember');
    const loginForm = document.querySelector('form');
    
    // Load saved email from cookie
    const savedEmail = getCookie('saved_email');
    if (savedEmail) {
        emailInput.value = savedEmail;
        saveEmailCheckbox.checked = true;
        
        // Add visual indicator that email was loaded from cookie
        emailInput.style.backgroundColor = '#f0f9ff';
        emailInput.style.borderColor = '#0ea5e9';
        
        // Show notification
        showNotification('Email tersimpan dimuat otomatis', 'info');
    }
    
    // Load remember me preference
    const rememberMe = getCookie('remember_me');
    if (rememberMe === 'true') {
        rememberCheckbox.checked = true;
    }
    
    // Handle form submission
    loginForm.addEventListener('submit', function(e) {
        const email = emailInput.value;
        const saveEmail = saveEmailCheckbox.checked;
        const remember = rememberCheckbox.checked;
        
        // Save email to cookie if checkbox is checked
        if (saveEmail && email) {
            setCookie('saved_email', email, 30); // Save for 30 days
            showNotification('Email disimpan untuk login berikutnya', 'success');
        } else {
            deleteCookie('saved_email');
        }
        
        // Save remember me preference
        if (remember) {
            setCookie('remember_me', 'true', 30);
        } else {
            deleteCookie('remember_me');
        }
    });
    
    // Handle email input changes
    emailInput.addEventListener('input', function() {
        // Reset background if user changes the email
        if (this.value !== savedEmail) {
            this.style.backgroundColor = '';
            this.style.borderColor = '';
        }
    });
    
    // Handle save email checkbox changes
    saveEmailCheckbox.addEventListener('change', function() {
        if (!this.checked) {
            deleteCookie('saved_email');
            showNotification('Email tersimpan dihapus', 'info');
        }
    });
    
    // Clear saved data button (optional)
    const clearDataBtn = document.createElement('button');
    clearDataBtn.type = 'button';
    clearDataBtn.className = 'text-xs text-gray-400 hover:text-red-500 transition-colors mt-2';
    clearDataBtn.innerHTML = '🗑️ Hapus Data Tersimpan';
    clearDataBtn.onclick = function() {
        deleteCookie('saved_email');
        deleteCookie('remember_me');
        emailInput.value = '';
        emailInput.style.backgroundColor = '';
        emailInput.style.borderColor = '';
        saveEmailCheckbox.checked = false;
        rememberCheckbox.checked = false;
        showNotification('Semua data tersimpan dihapus', 'success');
    };
    
    // Add clear button after the form
    loginForm.parentNode.insertBefore(clearDataBtn, loginForm.nextSibling);
});

// Notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white text-sm font-medium transition-all duration-300 transform translate-x-full`;
    
    // Set color based on type
    switch(type) {
        case 'success':
            notification.className += ' bg-green-500';
            break;
        case 'error':
            notification.className += ' bg-red-500';
            break;
        case 'info':
        default:
            notification.className += ' bg-blue-500';
            break;
    }
    
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">×</button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// Auto-save email as user types (debounced)
let saveEmailTimeout;
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const saveEmailCheckbox = document.getElementById('save_email');
    
    emailInput.addEventListener('input', function() {
        clearTimeout(saveEmailTimeout);
        saveEmailTimeout = setTimeout(() => {
            if (saveEmailCheckbox.checked && this.value.includes('@')) {
                setCookie('saved_email', this.value, 30);
            }
        }, 1000); // Save after 1 second of no typing
    });
});
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#F2B451'
        });
    });
</script>
@endif

@if(session('loginError'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Gagal Masuk!',
            text: "{{ session('loginError') }}",
            icon: 'error',
            confirmButtonText: 'Coba Lagi',
            confirmButtonColor: '#d33',
        });
    });
</script>
@endif
