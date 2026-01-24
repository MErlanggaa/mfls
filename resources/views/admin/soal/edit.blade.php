@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Edit Soal</h2>
        <p class="text-gray-500">Perbarui konten pertanyaan ujian.</p>
    </div>
    <a href="{{ route('admin.soal.index') }}" class="text-gray-500 hover:text-dark-navy font-bold flex items-center gap-2">
        ← Kembali
    </a>
</div>

<div class="max-w-3xl">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('admin.soal.update', $soal->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Kategori Ujian</label>
                <select name="ujian_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-dark-navy">
                    <option value="">-- Pilih --</option>
                    @foreach($ujians as $ujian)
                        <option value="{{ $ujian->id }}" {{ $soal->ujian_id == $ujian->id ? 'selected' : '' }}>{{ $ujian->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Pertanyaan</label>
                <textarea name="pertanyaan" rows="3" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-dark-navy">{{ $soal->pertanyaan }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase">Gambar (Opsional)</label>
                <input type="file" name="gambar" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 mb-2"/>
                @if($soal->gambar)
                    <div class="text-xs text-gray-400">Gambar saat ini:</div>
                    <img src="{{ asset('storage/' . $soal->gambar) }}" class="mt-1 h-32 rounded border border-gray-200">
                @endif
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Opsi A</label>
                    <input type="text" name="opsi_a" value="{{ $soal->opsi_a }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Opsi B</label>
                    <input type="text" name="opsi_b" value="{{ $soal->opsi_b }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Opsi C</label>
                    <input type="text" name="opsi_c" value="{{ $soal->opsi_c }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Opsi D</label>
                    <input type="text" name="opsi_d" value="{{ $soal->opsi_d }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Kunci Jawaban</label>
                    <select name="kunci_jawaban" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold">
                        <option value="a" {{ $soal->kunci_jawaban == 'a' ? 'selected' : '' }}>A</option>
                        <option value="b" {{ $soal->kunci_jawaban == 'b' ? 'selected' : '' }}>B</option>
                        <option value="c" {{ $soal->kunci_jawaban == 'c' ? 'selected' : '' }}>C</option>
                        <option value="d" {{ $soal->kunci_jawaban == 'd' ? 'selected' : '' }}>D</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Bobot Nilai</label>
                    <input type="number" name="bobot" value="{{ $soal->bobot }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-dark-navy text-white font-bold py-3 rounded-xl hover:bg-black transition-all shadow-lg">
                    Update Soal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
