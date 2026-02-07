@extends('pendaftar.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Card -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-2">Campaign Twibbon 📸</h1>
                <p class="text-gray-500 font-medium">Ramaikan media sosial dengan semangat MFLS 2026!</p>
            </div>
            <div class="w-16 h-16 bg-pink-500/10 rounded-2xl flex items-center justify-center text-pink-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Left: Preview & Download -->
            <div class="space-y-6 text-center">
                <div class="bg-gray-100/50 rounded-3xl p-6 border-2 border-dashed border-gray-200">
                    <img src="https://placehold.co/600x600/F2B451/111827?text=Twibbon+MFLS+2026&font=montserrat" alt="Preview Twibbon" class="w-full rounded-2xl shadow-lg rotate-1 hover:rotate-0 transition-all duration-500">
                </div>
                <a href="https://placehold.co/600x600/F2B451/111827?text=Twibbon+MFLS+2026&font=montserrat" download="Twibbon_MFLS_2026.png" class="inline-flex items-center gap-2 bg-dark-navy text-white font-bold py-3 px-6 rounded-xl hover:bg-black transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Twibbon
                </a>
            </div>

            <!-- Right: Instructions & Caption -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Langkah-langkah:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600 font-medium ml-2">
                        <li>Download gambar Twibbon di samping.</li>
                        <li>Pasang foto terbaikmu menggunakan aplikasi editing foto.</li>
                        <li>Upload ke Instagram Feed atau Story.</li>
                        <li>Gunakan caption yang telah disediakan di bawah ini.</li>
                        <li>Tag @mncuniversity.</li>
                        <li>Salin link postinganmu dan tempel di formulir bawah.</li>
                    </ol>
                </div>

                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 relative group">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2 block">Caption Postingan</label>
                    <div class="bg-white p-4 rounded-xl text-sm text-gray-600 h-40 overflow-y-auto font-mono text-xs border border-gray-100 shadow-inner" id="captionText">Halo Future Leaders! 👋

Saya [Nama Lengkap], siap menjadi bagian dari generasi emas Indonesia melalui MNC University Future Leaders Scholarship 2026.

Mimpi besar dimulai dari langkah berani. Ayo bergabung bersama kami wujudkan masa depan gemilang! 🚀

#MFLS2026 #MNCUniversity #BeasiswaIndonesia #FutureLeaders #GenerasiEmas #ScholarshipHunter</div>
                    
                    <button onclick="copyCaption()" class="absolute top-4 right-4 bg-white text-primary-gold p-2 rounded-lg shadow-sm border border-gray-100 hover:bg-primary-gold hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                    <div id="copyFeedback" class="absolute top-4 right-16 bg-dark-navy text-white text-[10px] font-bold px-3 py-2 rounded-lg opacity-0 transition-opacity">
                        Copied!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submission Form -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-2xl font-black text-gray-900 mb-2">Form Pengumpulan Link 🔗</h2>
            <p class="text-gray-500 font-medium">Sertakan link postingan Twibbon dan media sosialmu.</p>
        </div>

        <form action="{{ route('pendaftar.twibbon.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            


            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="col-span-1 md:col-span-2 space-y-2">
                    <label class="text-sm font-bold text-gray-700">Link Postingan Twibbon (Wajib)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-400">🔗</span>
                        </div>
                        <input type="url" name="link_twibbon" value="{{ old('link_twibbon', $peserta->link_twibbon) }}" placeholder="https://instagram.com/p/..." class="w-full pl-12 pr-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-pink-500/10 focus:border-pink-500/20 outline-none transition-all" required>
                    </div>
                    <p class="text-[10px] text-gray-400 font-medium ml-1">Pastikan akun tidak di-private.</p>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        Profile Instagram
                    </label>
                    <input type="url" name="link_ig" value="{{ old('link_ig', $peserta->link_ig) }}" placeholder="Link Profil Instagram" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500/20 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.65-1.62-1.12-1.61 2.75-4.93 5.51-8.54 5.2-3.64-.31-6.54-3.2-6.54-6.85 0-3.66 3.06-6.85 6.95-6.85 1.41 0 2.74.45 3.79 1.19.05-.72.09-1.46.13-2.18.29-1.99.3-4.04.13-6.42zm-2.91 3.83c-2.19 0-4.22 1.34-4.8 3.52-.56 2.11.45 4.43 2.5 5.27 2.06.84 4.54-.2 5.34-2.28.32-.82.35-1.75.05-2.6-.68-1.92-2.11-3.92-3.09-3.91z"/></svg>
                        Profile TikTok
                    </label>
                    <input type="url" name="link_tiktok" value="{{ old('link_tiktok', $peserta->link_tiktok) }}" placeholder="Link Profil TikTok" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-black/10 focus:border-black/20 outline-none transition-all">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-primary-gold hover:bg-primary-gold/90 text-dark-navy font-bold py-4 rounded-2xl transition-all hover:scale-[1.02] shadow-lg shadow-primary-gold/20 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Tautan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function copyCaption() {
        const text = document.getElementById('captionText').innerText;
        navigator.clipboard.writeText(text).then(() => {
            const feedback = document.getElementById('copyFeedback');
            feedback.style.opacity = '1';
            setTimeout(() => {
                feedback.style.opacity = '0';
            }, 2000);
        });
    }
</script>
@endsection
