<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Daftar;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function indexPendaftar()
    {
        // Ambil data pendaftar beserta detail daftar dan nilainya
        $pendaftars = Akun::where('role', 'pendaftar')
            ->with(['peserta.daftar'])
            ->get();
            
        // Hitung ulang rata-rata (opsional, bisa dipindah ke event listener saat nilai diinput)
        foreach($pendaftars as $user) {
            if ($user->peserta && $user->peserta->daftar) {
                // Dummy logic hitung nilai (karena tabel nilai kompleks, kita simulasikan atau ambil dari relation jika ada)
                // Real implementation harus ambil dari table 'nilais'
                // $avg = $user->peserta->nilais()->avg('nilai');
                
                // For demo purpose, kita pakai kolom rata_rata_nilai yang sudah ada
                // Nanti saat integrasi NilaiController, kolom ini diupdate.
            }
        }

        return view('admin.pendaftar.index', compact('pendaftars'));
    }

    public function detailPendaftar($id)
    {
        $user = Akun::with(['peserta.daftar', 'peserta.berkas', 'peserta.nilais.matpel'])->findOrFail($id);
        
        // Hitung rata-rata valid dari tabel nilai
        $rataRata = $user->peserta->nilais->avg('nilai') ?? 0;
        
        return view('admin.pendaftar.show', compact('user', 'rataRata'));
    }

    public function verifikasi(Request $request, $id)
    {
        $daftar = Daftar::where('peserta_id', function($query) use ($id) {
            $query->select('id')->from('peserta')->where('akun_id', $id);
        })->firstOrFail();

        $daftar->update([
            'status' => $request->status
        ]);

        // Logic Email Notifikasi
        if ($request->status == 'lulus') {
            $akun = Akun::find($id);
            // Ganti link ini dengan link React App Anda yang sebenarnya
            $linkUjian = "https://ujian-react.mfls.com/start?token=" . base64_encode($akun->email); 
            
            try {
                \Illuminate\Support\Facades\Mail::to($akun->email)->send(
                    new \App\Mail\UjianLinkMail($akun->nama, $linkUjian)
                );
            } catch (\Exception $e) {
                // Log error email tapi jangan hentikan proses
                \Illuminate\Support\Facades\Log::error("Gagal kirim email ujian: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Status kelulusan berhasil diperbarui!');
    }

    public function updateNilaiDummy(Request $request, $id) {
         // Ini method helper untuk testing update nilai rata-rata
         $daftar = Daftar::where('peserta_id', function($query) use ($id) {
            $query->select('id')->from('peserta')->where('akun_id', $id);
        })->firstOrFail();

        $daftar->update(['rata_rata_nilai' => $request->nilai]);
        return back();
    }

    public function exportExcel()
    {
        $fileName = 'detail_raport_mfls_' . date('Y-m-d_H-i') . '.csv';
        // Ambil data nilai juga
        $pendaftars = Akun::where('role', 'pendaftar')
                         ->with(['peserta.daftar', 'peserta.nilais.matpel'])
                         ->get();

        // Siapkan Header Dinamis
        // 1. Header Identitas
        $columns = ['Nama Lengkap', 'Email', 'NISN', 'Asal Sekolah', 'No. WA', 'Status Kelulusan', 'Waktu Daftar'];
        
        // 2. Ambil List Matpel dari database (asumsi semua siswa mapelnya sama/variatif, kita ambil unique)
        $allMatpels = \App\Models\Matpel::pluck('nama', 'id'); // [id => nama]

        // 3. Header Matpel (Matematika Sem 1, Matematika Sem 2... Matematika Avg)
        foreach ($allMatpels as $mpName) {
            for ($i = 1; $i <= 6; $i++) {
                $columns[] = "$mpName (S$i)";
            }
            $columns[] = "Rata2 $mpName";
        }

        // 4. Header Rata-rata Semester
        for ($i = 1; $i <= 6; $i++) {
            $columns[] = "Rata2 Sem $i";
        }
        $columns[] = 'TOTAL SCORE';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($pendaftars, $columns, $allMatpels) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis Header

            foreach ($pendaftars as $user) {
                if (!$user->peserta) continue;

                // Data Dasar
                $row = [
                    $user->nama,
                    $user->email,
                    $user->peserta->nisn ?? '-',
                    $user->peserta->daftar->asal_sekolah ?? '-',
                    $user->peserta->daftar->no_wa ?? '-',
                    ucfirst($user->peserta->daftar->status ?? 'menunggu'),
                    $user->created_at->format('Y-m-d H:i'),
                ];

                // Data Nilai Logic
                $nilais = $user->peserta->nilais;
                $semesterTotals = array_fill(1, 6, 0);
                $semesterCounts = array_fill(1, 6, 0);

                // Loop per Matpel
                foreach ($allMatpels as $mpId => $mpName) {
                    $mpTotal = 0;
                    $mpCount = 0;

                    // Loop Semester 1-6 untuk Matpel ini
                    for ($sem = 1; $sem <= 6; $sem++) {
                        $val = $nilais->where('matpel_id', $mpId)->where('semester', $sem)->first()->nilai ?? 0;
                        
                        $row[] = $val > 0 ? $val : '0'; // Masukkan ke CSV

                        if ($val > 0) {
                            $mpTotal += $val;
                            $mpCount++;
                            $semesterTotals[$sem] += $val;
                            $semesterCounts[$sem]++;
                        }
                    }
                    // Rata2 Per Matpel
                    $row[] = $mpCount > 0 ? number_format($mpTotal / $mpCount, 2) : '0';
                }

                // Loop Rata-rata Per Semester
                $totalAll = 0;
                $countAll = 0;
                for ($sem = 1; $sem <= 6; $sem++) {
                    $avgSem = $semesterCounts[$sem] > 0 ? ($semesterTotals[$sem] / $semesterCounts[$sem]) : 0;
                    $row[] = number_format($avgSem, 2);
                    
                    if ($avgSem > 0) {
                        $totalAll += $avgSem;
                        $countAll++;
                    }
                }

                // Total Score (Rata-rata dari Rata-rata Semester)
                $row[] = $countAll > 0 ? number_format($totalAll / $countAll, 2) : '0';

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
