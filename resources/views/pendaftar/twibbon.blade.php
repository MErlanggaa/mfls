@extends('pendaftar.layout')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-primary-gold/10 to-white">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-2">🎨 Twibon Generator</h1>
                <p class="text-gray-500 font-medium">Buat twibon kamu dan bagikan ke social media!</p>
            </div>
            <div class="w-16 h-16 bg-primary-gold/20 rounded-2xl flex items-center justify-center text-primary-gold">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <div class="p-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Left: Upload & Controls -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 p-6 rounded-[2rem] border border-blue-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            Upload Foto Kamu
                        </h3>
                        
                        <div class="mb-4">
                            <label for="photoUpload" class="cursor-pointer block">
                                <div class="border-2 border-dashed border-blue-300 rounded-2xl p-8 text-center hover:border-blue-500 hover:bg-blue-50/50 transition-all">
                                    <svg class="w-12 h-12 mx-auto text-blue-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-sm font-bold text-gray-700">Klik untuk upload foto</p>
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG (Max 5MB)</p>
                                </div>
                            </label>
                            <input type="file" id="photoUpload" accept="image/*" class="hidden">
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Ukuran Foto</label>
                                <input type="range" id="scaleSlider" min="10" max="300" value="100" class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>Kecil</span>
                                    <span id="scaleValue">100%</span>
                                    <span>Besar</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Rotasi Foto</label>
                                <input type="range" id="rotateSlider" min="0" max="360" value="0" class="w-full h-2 bg-purple-200 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>0°</span>
                                    <span id="rotateValue">0°</span>
                                    <span>360°</span>
                                </div>
                            </div>

                            <div class="bg-white/50 p-4 rounded-xl border border-blue-200">
                                <p class="text-xs text-gray-600 mb-2">💡 <strong>Tips:</strong></p>
                                <ul class="text-xs text-gray-600 space-y-1 ml-4 list-disc">
                                    <li>Drag foto untuk menggeser posisi</li>
                                    <li>Gunakan slider untuk zoom in/out</li>
                                    <li>Pastikan wajah terlihat jelas</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button id="downloadBtn" class="w-full bg-gradient-to-r from-primary-gold to-amber-400 hover:from-amber-400 hover:to-primary-gold text-dark-navy font-bold py-4 rounded-2xl transition-all hover:scale-[1.02] shadow-lg shadow-primary-gold/30 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download Twibon
                    </button>
                </div>

                <!-- Right: Preview Canvas -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Preview Twibon
                    </h3>
                    
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-[2rem] border border-gray-200">
                        <div class="relative mx-auto" style="max-width: 500px;">
                            <canvas id="twibonCanvas" width="1080" height="1080" class="w-full h-auto rounded-2xl shadow-2xl border-4 border-white"></canvas>
                            <div id="dragHint" class="absolute inset-0 bg-black/50 rounded-2xl flex items-center justify-center text-white text-sm font-bold opacity-0 transition-opacity pointer-events-none">
                                📸 Upload foto untuk mulai
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <p class="text-xs text-gray-600 text-center">
                            <strong class="text-blue-600">Share ke Instagram/WhatsApp</strong> dengan hashtag <strong>#MFLSBeasiswa2026</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Social Media Submission Section -->
        <div class="mt-10 pt-10 border-t border-gray-100">
            <h3 class="text-xl font-black text-gray-900 mb-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-pink-500/10 rounded-xl flex items-center justify-center text-pink-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                Upload Link Twibbon & Sosmed
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Caption Copy -->
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-3">📋 Caption Twibbon</h4>
                    <div class="bg-white p-4 rounded-xl border border-gray-200 text-xs text-gray-600 font-mono leading-relaxed relative group" id="captionText">
                        Halo semuanya! 👋<br><br>
                        Saya {{ Auth::user()->nama }} siap menjadi bagian dari masa depan Indonesia bersama MNC Future Leaders Scholarship 2026! 🚀✨<br><br>
                        Mari bergabung bersama saya untuk mewujudkan mimpi dan berkontribusi bagi bangsa. Jangan lupa daftarkan dirimu sekarang juga!<br><br>
                        #MFLS2026 #BeasiswaMNC #FutureLeaders #GenerasiEmas
                        
                        <button onclick="copyCaption()" class="absolute top-2 right-2 bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-lg transition-colors" title="Copy Caption">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 text-center">Klik ikon copy untuk menyalin caption</p>
                </div>

                <!-- Submission Form -->
                <form action="{{ route('pendaftar.twibbon.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Link Postingan Twibbon (Required)</label>
                            <input type="url" name="link_twibbon" value="{{ old('link_twibbon', $peserta->link_twibbon) }}" placeholder="https://instagram.com/p/..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-gold focus:border-transparent outline-none transition-all" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Link Profil Instagram</label>
                            <input type="url" name="link_ig" value="{{ old('link_ig', $peserta->link_ig) }}" placeholder="https://instagram.com/username" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-gold focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Link Profil TikTok</label>
                            <input type="url" name="link_tiktok" value="{{ old('link_tiktok', $peserta->link_tiktok) }}" placeholder="https://tiktok.com/@username" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-gold focus:border-transparent outline-none transition-all">
                        </div>

                        <button type="submit" class="w-full bg-dark-navy text-white font-bold py-3.5 rounded-xl hover:bg-primary-gold hover:text-dark-navy transition-all shadow-lg shadow-dark-navy/20">
                            Simpan Link Sosmed
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('twibonCanvas');
    const ctx = canvas.getContext('2d');
    const photoUpload = document.getElementById('photoUpload');
    const scaleSlider = document.getElementById('scaleSlider');
    const scaleValue = document.getElementById('scaleValue');
    const rotateSlider = document.getElementById('rotateSlider');
    const rotateValue = document.getElementById('rotateValue');
    const downloadBtn = document.getElementById('downloadBtn');
    const dragHint = document.getElementById('dragHint');

    let userPhoto = null;
    let twibonFrame = new Image();
    let photoScale = 1;
    let photoRotation = 0;
    let photoX = 540; // Center X of 1080
    let photoY = 540; // Center Y of 1080
    let isDragging = false;
    let dragStartX = 0;
    let dragStartY = 0;

    // Load twibon frame
    twibonFrame.src = '{{ asset("icon/twiibon.png") }}';
    twibonFrame.onload = function() {
        drawCanvas();
    };

    // Upload photo
    photoUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                userPhoto = new Image();
                userPhoto.onload = function() {
                    // Center photo initially
                    photoX = canvas.width / 2;
                    photoY = canvas.height / 2;
                    dragHint.classList.add('opacity-0');
                    drawCanvas();
                };
                userPhoto.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Scale slider
    scaleSlider.addEventListener('input', function() {
        photoScale = this.value / 100;
        scaleValue.textContent = this.value + '%';
        drawCanvas();
    });

    // Rotate slider
    rotateSlider.addEventListener('input', function() {
        photoRotation = (this.value * Math.PI) / 180;
        rotateValue.textContent = this.value + '°';
        drawCanvas();
    });

    // Mouse drag events
    canvas.addEventListener('mousedown', function(e) {
        if (!userPhoto) return;
        isDragging = true;
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        dragStartX = (e.clientX - rect.left) * scaleX - photoX;
        dragStartY = (e.clientY - rect.top) * scaleY - photoY;
        canvas.style.cursor = 'grabbing';
    });

    canvas.addEventListener('mousemove', function(e) {
        if (!isDragging || !userPhoto) return;
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        photoX = (e.clientX - rect.left) * scaleX - dragStartX;
        photoY = (e.clientY - rect.top) * scaleY - dragStartY;
        drawCanvas();
    });

    canvas.addEventListener('mouseup', function() {
        isDragging = false;
        canvas.style.cursor = userPhoto ? 'grab' : 'default';
    });

    canvas.addEventListener('mouseleave', function() {
        isDragging = false;
        canvas.style.cursor = 'default';
    });

    // Touch events for mobile
    canvas.addEventListener('touchstart', function(e) {
        if (!userPhoto) return;
        e.preventDefault();
        isDragging = true;
        const rect = canvas.getBoundingClientRect();
        const touch = e.touches[0];
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        dragStartX = (touch.clientX - rect.left) * scaleX - photoX;
        dragStartY = (touch.clientY - rect.top) * scaleY - photoY;
    });

    canvas.addEventListener('touchmove', function(e) {
        if (!isDragging || !userPhoto) return;
        e.preventDefault();
        const rect = canvas.getBoundingClientRect();
        const touch = e.touches[0];
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        photoX = (touch.clientX - rect.left) * scaleX - dragStartX;
        photoY = (touch.clientY - rect.top) * scaleY - dragStartY;
        drawCanvas();
    });

    canvas.addEventListener('touchend', function() {
        isDragging = false;
    });

    // Draw canvas
    function drawCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Draw user photo (background layer)
        if (userPhoto) {
            ctx.save();
            ctx.translate(photoX, photoY);
            ctx.rotate(photoRotation);
            const scaledWidth = userPhoto.width * photoScale;
            const scaledHeight = userPhoto.height * photoScale;
            ctx.drawImage(userPhoto, -scaledWidth / 2, -scaledHeight / 2, scaledWidth, scaledHeight);
            ctx.restore();
        } else {
            // Show hint
            dragHint.classList.remove('opacity-0');
        }
        
        // Draw twibon frame (foreground layer)
        if (twibonFrame.complete) {
            ctx.drawImage(twibonFrame, 0, 0, canvas.width, canvas.height);
        }
    }

    // Download button
    downloadBtn.addEventListener('click', function() {
        if (!userPhoto) {
            alert('Silakan upload foto terlebih dahulu!');
            return;
        }
        
        const link = document.createElement('a');
        link.download = 'twibon-mfls-' + Date.now() + '.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });

    // Initial draw
    drawCanvas();
});

function copyCaption() {
    const captionElement = document.getElementById('captionText');
    const button = captionElement.querySelector('button'); // Get button to exclude from text
    const tempElement = captionElement.cloneNode(true); // Clone to modify
    
    // Remove button from clone
    const btnInClone = tempElement.querySelector('button');
    if(btnInClone) btnInClone.remove();
    
    const textToCopy = tempElement.innerText.trim();
    
    navigator.clipboard.writeText(textToCopy).then(() => {
        // Show temporary success feedback
        const originalIcon = button.innerHTML;
        button.innerHTML = '<span class="text-green-500 font-bold text-xs">Copied!</span>';
        setTimeout(() => {
            button.innerHTML = originalIcon;
        }, 2000);
    }).catch(err => {
        console.error('Gagal menyalin text: ', err);
        alert('Gagal menyalin. Silakan copy secara manual.');
    });
}
</script>

<style>
#twibonCanvas {
    cursor: grab;
}
#twibonCanvas:active {
    cursor: grabbing;
}
</style>
@endsection
