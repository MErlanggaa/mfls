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

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="w-5 h-5 border-gray-300 rounded text-dark-navy focus:ring-dark-navy/20">
            <label for="remember" class="ml-3 text-sm font-semibold text-gray-600">Tetap Masuk</label>
        </div>
        <div class="flex items-center">
            <input type="checkbox" id="save_email" class="w-5 h-5 border-gray-300 rounded text-dark-navy focus:ring-dark-navy/20">
            <label for="save_email" class="ml-3 text-sm font-semibold text-gray-600">Simpan Email</label>
        </div>
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

<script>
// Cookie Management Functions for Internal Login
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

// Initialize Internal Login Cookie Management
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const saveEmailCheckbox = document.getElementById('save_email');
    const rememberCheckbox = document.getElementById('remember');
    const loginForm = document.querySelector('form');
    
    // Load saved email from cookie (internal prefix)
    const savedEmail = getCookie('internal_saved_email');
    if (savedEmail) {
        emailInput.value = savedEmail;
        saveEmailCheckbox.checked = true;
        
        // Add visual indicator for internal login
        emailInput.style.backgroundColor = '#f8fafc';
        emailInput.style.borderColor = '#111827';
        
        // Show notification
        showInternalNotification('Email admin tersimpan dimuat otomatis', 'info');
    }
    
    // Load remember me preference for internal
    const rememberMe = getCookie('internal_remember_me');
    if (rememberMe === 'true') {
        rememberCheckbox.checked = true;
    }
    
    // Handle form submission
    loginForm.addEventListener('submit', function(e) {
        const email = emailInput.value;
        const saveEmail = saveEmailCheckbox.checked;
        const remember = rememberCheckbox.checked;
        
        // Save email to cookie with internal prefix
        if (saveEmail && email) {
            setCookie('internal_saved_email', email, 30);
            showInternalNotification('Email admin disimpan untuk login berikutnya', 'success');
        } else {
            deleteCookie('internal_saved_email');
        }
        
        // Save remember me preference for internal
        if (remember) {
            setCookie('internal_remember_me', 'true', 30);
        } else {
            deleteCookie('internal_remember_me');
        }
    });
    
    // Handle email input changes
    emailInput.addEventListener('input', function() {
        if (this.value !== savedEmail) {
            this.style.backgroundColor = '';
            this.style.borderColor = '';
        }
    });
    
    // Handle save email checkbox changes
    saveEmailCheckbox.addEventListener('change', function() {
        if (!this.checked) {
            deleteCookie('internal_saved_email');
            showInternalNotification('Email admin tersimpan dihapus', 'info');
        }
    });
    
    // Clear saved data button for internal
    const clearDataBtn = document.createElement('button');
    clearDataBtn.type = 'button';
    clearDataBtn.className = 'text-xs text-gray-400 hover:text-red-500 transition-colors mt-2';
    clearDataBtn.innerHTML = '🗑️ Hapus Data Admin Tersimpan';
    clearDataBtn.onclick = function() {
        deleteCookie('internal_saved_email');
        deleteCookie('internal_remember_me');
        emailInput.value = '';
        emailInput.style.backgroundColor = '';
        emailInput.style.borderColor = '';
        saveEmailCheckbox.checked = false;
        rememberCheckbox.checked = false;
        showInternalNotification('Semua data admin tersimpan dihapus', 'success');
    };
    
    loginForm.parentNode.insertBefore(clearDataBtn, loginForm.nextSibling);
});

// Internal notification function with dark theme
function showInternalNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white text-sm font-medium transition-all duration-300 transform translate-x-full`;
    
    // Set color based on type (darker theme for internal)
    switch(type) {
        case 'success':
            notification.className += ' bg-green-600';
            break;
        case 'error':
            notification.className += ' bg-red-600';
            break;
        case 'info':
        default:
            notification.className += ' bg-gray-700';
            break;
    }
    
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span>🔒 ${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">×</button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 4 seconds (longer for internal)
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 4000);
}

// Auto-save email for internal (debounced)
let saveInternalEmailTimeout;
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const saveEmailCheckbox = document.getElementById('save_email');
    
    emailInput.addEventListener('input', function() {
        clearTimeout(saveInternalEmailTimeout);
        saveInternalEmailTimeout = setTimeout(() => {
            if (saveEmailCheckbox.checked && this.value.includes('@')) {
                setCookie('internal_saved_email', this.value, 30);
            }
        }, 1500); // Longer delay for internal
    });
});
</script>
