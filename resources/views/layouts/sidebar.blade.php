<!-- Sidebar -->
<aside class="w-72 bg-white border-r border-gray-100 flex flex-col sticky top-0 h-screen">
    <div class="p-8">
        <a href="/" class="flex items-center justify-center">
            <img src="{{ asset('icon/loog.jpg') }}" alt="Logo MFLS" class="h-12 w-auto">
        </a>
    </div>

    <nav class="flex-grow px-4 space-y-1">
        <a href="/pendaftar/dashboard" class="flex items-center gap-3 px-4 py-3 {{ request()->is('pendaftar/dashboard') ? 'bg-primary-gold/10 text-primary-gold font-bold' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="/pendaftar/biodata" class="flex items-center gap-3 px-4 py-3 {{ request()->is('pendaftar/biodata') ? 'bg-primary-gold/10 text-primary-gold font-bold' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-semibold transition-all group">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Biodata Diri
        </a>
        <a href="/pendaftar/berkas" class="flex items-center gap-3 px-4 py-3 {{ request()->is('pendaftar/berkas') ? 'bg-primary-gold/10 text-primary-gold font-bold' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl font-semibold transition-all group">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Upload Berkas
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 cursor-not-allowed rounded-xl font-semibold transition-all group">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Ujian Online
        </a>
        <a href="/pengumuman" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-semibold transition-all group">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            Pengumuman
        </a>
    </nav>

    <div class="p-6 border-t border-gray-100">
        <form action="/logout" method="POST">
            @csrf
            <div class="bg-dark-navy p-4 rounded-2xl flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-gold flex items-center justify-center text-dark-navy font-bold uppercase">
                    {{ substr(Auth::user()->nama ?? 'JD', 0, 2) }}
                </div>
                <div class="flex-grow min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->nama ?? 'John Doe' }}</p>
                    <p class="text-[10px] text-gray-400 truncate">Pendaftar</p>
                </div>
                <button type="submit" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </div>
        </form>
    </div>
</aside>
