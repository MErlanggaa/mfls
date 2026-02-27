@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Edit Berita</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Perbarui konten publikasi</p>
        </div>
        <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 bg-white text-slate-600 rounded-xl hover:bg-slate-50 border border-slate-200 font-bold transition-all inline-flex items-center gap-2 shadow-sm">
            <span class="iconify" data-icon="solar:arrow-left-linear"></span>
            Kembali
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Judul -->
                <div>
                    <label for="judul" class="block text-sm font-bold text-slate-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-xl outline-none transition-all font-medium text-slate-800 placeholder:text-slate-400"
                        placeholder="Contoh: Pembukaan Beasiswa MFLS 2026">
                    @error('judul') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Thumbnail -->
                <div>
                    <label for="thumbnail" class="block text-sm font-bold text-slate-700 mb-2">Thumbnail (Biarkan kosong jika tidak ingin mengubah)</label>
                    @if($berita->thumbnail)
                        <div class="mb-3">
                            <span class="text-xs text-slate-500 block mb-1">Thumbnail saat ini:</span>
                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="h-32 w-auto rounded-lg shadow-sm border border-slate-200 object-cover">
                        </div>
                    @endif
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 text-sm text-slate-500">
                    @error('thumbnail') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Konten (Summernote) -->
                <div>
                    <label for="konten" class="block text-sm font-bold text-slate-700 mb-2">Isi Konten <span class="text-red-500">*</span></label>
                    <textarea id="konten" name="konten" required>{{ old('konten', $berita->konten) }}</textarea>
                    @error('konten') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Status Publikasi -->
                <div class="flex items-center bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $berita->is_published) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                    <label for="is_published" class="ml-3 text-sm font-bold text-slate-700 cursor-pointer">Status Publikasi (Ceklist untuk mempublikasikan)</label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 transition-all inline-flex items-center gap-2 hover:-translate-y-0.5">
                    <span class="iconify" data-icon="solar:diskette-line-duotone"></span>
                    Perbarui Berita
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Styling for Summernote inside Tailwind */
    .note-editor.note-frame {
        @apply border-slate-200 rounded-xl overflow-hidden shadow-sm;
    }
    .note-editor .note-toolbar {
        @apply bg-slate-50 border-b border-slate-200 p-2;
    }
    .note-editor .note-editing-area {
        @apply p-4 min-h-[300px];
    }
</style>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#konten').summernote({
            placeholder: 'Tulis isi konten berita di sini...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
