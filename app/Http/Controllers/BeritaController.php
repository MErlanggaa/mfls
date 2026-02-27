<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = \App\Models\Berita::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $berita = new \App\Models\Berita();
        $berita->judul = $request->judul;
        $berita->slug = \Illuminate\Support\Str::slug($request->judul) . '-' . time();
        $berita->konten = $request->konten;
        $berita->is_published = $request->has('is_published');

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('berita', 'public');
            $berita->thumbnail = $path;
        }

        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit($id)
    {
        $berita = \App\Models\Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $berita = \App\Models\Berita::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $berita->judul = $request->judul;
        $berita->konten = $request->konten;
        $berita->is_published = $request->has('is_published');

        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($berita->thumbnail);
            }
            $path = $request->file('thumbnail')->store('berita', 'public');
            $berita->thumbnail = $path;
        }

        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $berita = \App\Models\Berita::findOrFail($id);
        if ($berita->thumbnail) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($berita->thumbnail);
        }
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus');
    }
}
