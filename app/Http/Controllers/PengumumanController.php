<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta; // Sesuaikan dengan model Anda

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $peserta = null;
        
        if ($request->has('nisn') && !empty($request->nisn)) {
            // Validasi NISN
            $request->validate([
                'nisn' => 'required|string|min:8|max:20'
            ], [
                'nisn.required' => 'NISN harus diisi',
                'nisn.min' => 'NISN minimal terdiri dari 8 karakter',
                'nisn.max' => 'NISN maksimal terdiri dari 20 karakter'
            ]);
            
            // Cari peserta berdasarkan NISN dengan relasi daftar
            $peserta = Peserta::with(['daftar', 'berkas', 'penilaianAkademiks'])->where('nisn', $request->nisn)->first();
            
            // Jika peserta tidak ditemukan, tetap tampilkan form dengan pesan error
            if (!$peserta) {
                return view('pengumuman', compact('peserta'));
            }
        }
        
        return view('pengumuman', compact('peserta'));
    }
}