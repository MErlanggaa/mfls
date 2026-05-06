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
                'nisn' => 'required|digits:10'
            ], [
                'nisn.required' => 'NISN harus diisi',
                'nisn.digits' => 'NISN harus terdiri dari 10 digit angka'
            ]);
            
            // Cari peserta berdasarkan NISN dengan relasi daftar
            $peserta = Peserta::with(['daftar', 'berkas'])->where('nisn', $request->nisn)->first();
            
            // Jika peserta tidak ditemukan, tetap tampilkan form dengan pesan error
            if (!$peserta) {
                return view('pengumuman', compact('peserta'));
            }
        }
        
        return view('pengumuman', compact('peserta'));
    }
}