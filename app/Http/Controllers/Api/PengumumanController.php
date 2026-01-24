<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Cek hasil pengumuman beasiswa berdasarkan NISN.
     */
    public function cekHasil(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
        ]);

        $peserta = Peserta::with('daftar')->where('nisn', $request->nisn)->first();

        if (!$peserta) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pendaftar dengan NISN tersebut tidak ditemukan.'
            ], 404);
        }

        $daftar = $peserta->daftar;

        if (!$daftar || $daftar->status !== 'lulus') {
            return response()->json([
                'status' => 'pending',
                'nama' => $peserta->nama,
                'message' => 'Hasil seleksi Anda belum tersedia atau masih dalam proses peninjauan.'
            ]);
        }

        // Logika Khusus: 100% (Jalur Undangan)
        if ($daftar->nominal_beasiswa === '100%') {
            return response()->json([
                'status' => 'success',
                'nama' => $peserta->nama,
                'jalur' => 'UNDANGAN',
                'message' => 'Selamat! Anda dinyatakan lolos melalui Jalur Undangan. Segera cek email atau hubungi admin untuk mengikuti proses undangan selanjutnya.',
                'hasil_beasiswa' => 'Menunggu Verifikasi Undangan' // Jangan tampilkan 100% dulu
            ]);
        }

        // Beasiswa Lainnya (25, 50, 75)
        return response()->json([
            'status' => 'success',
            'nama' => $peserta->nama,
            'jalur' => 'BEASISWA PRESTASI',
            'message' => 'Selamat! Anda dinyatakan lolos seleksi beasiswa.',
            'hasil_beasiswa' => $daftar->nominal_beasiswa
        ]);
    }
}
