@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Manajemen Pengguna</h2>
        <p class="text-gray-500">Kelola akun operasional sistem (Admin, Administrasi, Akademik, Mentor).</p>
    </div>
    <button onclick="openAddModal()" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-sm font-black shadow-lg shadow-slate-200 hover:bg-black transition-all uppercase tracking-widest flex items-center gap-2">
        <span class="iconify" data-icon="solar:user-plus-bold"></span> Tambah User
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($users as $user)
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all relative overflow-hidden group">
        @php
            $colorClass = 'bg-slate-600';
            $bgColorClass = 'bg-slate-50';
            $textColorClass = 'text-slate-600';
            
            if($user->role === 'admin') { 
                $colorClass = 'bg-red-600'; $bgColorClass = 'bg-red-50'; $textColorClass = 'text-red-600';
            } elseif($user->role === 'panitia') {
                $colorClass = 'bg-orange-600'; $bgColorClass = 'bg-orange-50'; $textColorClass = 'text-orange-600';
            } elseif($user->role === 'akademik') {
                $colorClass = 'bg-blue-600'; $bgColorClass = 'bg-blue-50'; $textColorClass = 'text-blue-600';
            } elseif($user->role === 'mentor') {
                $colorClass = 'bg-emerald-600'; $bgColorClass = 'bg-emerald-50'; $textColorClass = 'text-emerald-600';
            }
        @endphp
        
        <div class="absolute top-0 left-0 w-full h-1 {{ $colorClass }}"></div>
        
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 {{ $bgColorClass }} rounded-2xl flex items-center justify-center {{ $textColorClass }} font-black text-xl shadow-inner">
                {{ substr($user->nama, 0, 1) }}
            </div>
            <div>
                <h3 class="font-black text-slate-800 text-sm mb-0.5">{{ $user->nama }}</h3>
                <span class="px-2 py-0.5 {{ str_replace('text-', 'bg-', $textColorClass) }} bg-opacity-10 {{ $textColorClass }} rounded text-[9px] font-black uppercase tracking-widest">
                    {{ $user->role === 'panitia' ? 'ADMINISTRASI' : strtoupper($user->role) }}
                </span>
            </div>
        </div>

        <div class="space-y-2 mb-6 text-xs font-medium text-slate-500">
            <div class="flex items-center gap-2">
                <span class="iconify" data-icon="solar:letter-bold"></span>
                {{ $user->email }}
            </div>
            @if($user->role === 'mentor')
            <div class="flex items-center gap-2">
                <span class="iconify" data-icon="solar:users-group-two-rounded-bold"></span>
                Handle {{ $user->peserta_count }} Peserta
            </div>
            @endif
        </div>

        <div class="flex gap-2">
            <button onclick="openEditModal({{ json_encode($user) }})" class="flex-1 py-3 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black hover:bg-slate-100 transition-all uppercase tracking-widest">Edit Akun</button>
            <button type="button" onclick="confirmQuickReset({{ $user->id }}, '{{ $user->nama }}')" class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center hover:bg-yellow-500 hover:text-white transition-all shadow-sm" title="Quick Reset Password">
                <span class="iconify" data-icon="solar:key-minimalistic-bold-duotone"></span>
            </button>
            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDeleteUser(this, '{{ $user->nama }}')" class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                    <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Add/Edit -->
<div id="userModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    
    <!-- Modal Content Holder -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-[2.5rem] w-full max-w-lg shadow-2xl transform transition-all overflow-hidden z-[101]">
            <form id="userForm" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="px-8 pt-8 pb-8">
                    <h3 class="text-xl font-black text-slate-900 mb-6 uppercase tracking-tight" id="modalTitle">Tambah User Baru</h3>
                    <div class="space-y-4 text-left">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Nama Lengkap</label>
                            <input type="text" name="nama" id="formNama" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm font-bold text-slate-800 outline-none focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Email Address</label>
                            <input type="email" name="email" id="formEmail" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm font-bold text-slate-800 outline-none focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Password</label>
                            <input type="password" name="password" id="formPassword" placeholder="Minimal 6 karakter" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm font-bold text-slate-800 outline-none focus:border-blue-500 transition-all">
                            <p class="text-[9px] text-slate-400 italic mt-1 ml-2" id="passwordHint">Isi hanya jika ingin mengganti password.</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-2">Role Akses</label>
                            <div class="relative">
                                <select name="role" id="formRole" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-sm font-bold text-slate-800 outline-none focus:border-blue-500 transition-all appearance-none">
                                    <option value="admin">Admin (Full Access)</option>
                                    <option value="panitia">Administrasi (Selection & Docs)</option>
                                    <option value="akademik">Akademik (Bank Soal & Results)</option>
                                    <option value="mentor">Mentor (Assessments)</option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <span class="iconify" data-icon="solar:alt-arrow-down-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-8 py-6 flex gap-3">
                    <button type="submit" class="flex-1 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-slate-200">Simpan Data</button>
                    <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-white border border-slate-200 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="quickResetForm" method="POST" style="display:none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="password" id="quickResetInput">
</form>

<script>
const modal = document.getElementById('userModal');
const form = document.getElementById('userForm');
const modalTitle = document.getElementById('modalTitle');
const methodField = document.getElementById('methodField');
const passwordHint = document.getElementById('passwordHint');

function confirmQuickReset(userId, name) {
    Swal.fire({
        title: 'Konfirmasi Reset',
        text: `Apakah Anda benar-benar ingin mereset password untuk ${name}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f97316',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Reset Password',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Password Baru',
                text: `Masukkan password baru untuk ${name}:`,
                input: 'password',
                inputPlaceholder: 'Minimal 6 karakter',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#000',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    if (!password || password.length < 6) {
                        Swal.showValidationMessage('Password minimal 6 karakter');
                        return false;
                    }
                    return password;
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((inputResult) => {
                if (inputResult.isConfirmed) {
                    const resetForm = document.getElementById('quickResetForm');
                    resetForm.action = `/admin/user/${userId}/reset-password`;
                    document.getElementById('quickResetInput').value = inputResult.value;
                    resetForm.submit();
                }
            });
        }
    });
}

function openAddModal() {
    modalTitle.innerText = 'Tambah User Baru';
    form.action = "{{ route('admin.user.store') }}";
    methodField.innerHTML = '';
    passwordHint.style.display = 'none';
    form.reset();
    document.getElementById('formPassword').required = true;
    modal.classList.remove('hidden');
}

function openEditModal(user) {
    modalTitle.innerText = 'Edit Data User';
    form.action = `/admin/user/${user.id}`;
    methodField.innerHTML = '@method("PUT")';
    passwordHint.style.display = 'block';
    
    document.getElementById('formNama').value = user.nama;
    document.getElementById('formEmail').value = user.email;
    document.getElementById('formRole').value = user.role;
    document.getElementById('formPassword').value = '';
    document.getElementById('formPassword').required = false;
    
    modal.classList.remove('hidden');
}

function closeModal() {
    modal.classList.add('hidden');
}

function confirmDeleteUser(button, name) {
    Swal.fire({
        title: 'Hapus User?',
        text: `Hapus akun ${name}? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endsection
