<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    // Jam pembukaan pengumuman (12:00 WIB / UTC+7)
    const OPEN_HOUR   = 12;
    const OPEN_MINUTE = 0;

    public function index(Request $request)
    {
        // Cek apakah sudah waktunya pengumuman (12:00 WIB)
        $now = Carbon::now('Asia/Jakarta');
        $openTime = Carbon::today('Asia/Jakarta')->setTime(self::OPEN_HOUR, self::OPEN_MINUTE, 0);

        // Jika belum waktunya, tampilkan halaman countdown
        if ($now->lt($openTime)) {
            return view('pengumuman_countdown', [
                'openTime' => $openTime->toIso8601String(),
            ]);
        }

        $peserta = null;

        if ($request->has('nisn') && !empty($request->nisn)) {
            // Validasi NISN
            $request->validate([
                'nisn' => 'required|string|min:8|max:20'
            ], [
                'nisn.required' => 'NISN harus diisi',
                'nisn.min'      => 'NISN minimal terdiri dari 8 karakter',
                'nisn.max'      => 'NISN maksimal terdiri dari 20 karakter'
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