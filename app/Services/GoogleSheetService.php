<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Illuminate\Support\Facades\Log;

class GoogleSheetService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->spreadsheetId = config('services.google_sheet.id') ?? env('GOOGLE_SHEET_ID');
        $credentialsPath = storage_path('app/google/service_account.json');

        if (!$this->spreadsheetId || !file_exists($credentialsPath) || !is_readable($credentialsPath)) {
            if (config('app.debug')) {
                \Illuminate\Support\Facades\Log::warning('Google Sheets configuration missing or invalid. Path: '.$credentialsPath);
            }
            return;
        }

        $this->client = new Client();
        $this->client->setAuthConfig($credentialsPath);
        $this->client->addScope(Sheets::SPREADSHEETS);
        $this->service = new Sheets($this->client);
    }

    /**
     * Sync all pendaftars to the sheet with full details.
     */
    public function syncAll()
    {
        if (!$this->service) return;

        $pendaftars = \App\Models\Akun::where('role', 'pendaftar')
            ->with(['peserta.daftar', 'peserta.nilais.matpel', 'peserta.berkas', 'peserta.sertifikats'])
            ->get()
            ->sort(function ($a, $b) {
                $progA = $a->peserta->progress ?? 0;
                $progB = $b->peserta->progress ?? 0;
                if ($progA == $progB) {
                    $nilaiA = $a->peserta && $a->peserta->daftar ? $a->peserta->daftar->rata_rata_nilai : 0;
                    $nilaiB = $b->peserta && $b->peserta->daftar ? $b->peserta->daftar->rata_rata_nilai : 0;
                    return $nilaiB <=> $nilaiA;
                }
                return $progB <=> $progA;
            });

        $rows = [];
        // Header
        $headerBefore = [
            'STT / KETERANGAN', 'PROGRES (%)', 
            'Nama Lengkap', 'Email', 'Jenis Kelamin', 'Nomor HP', 'NISN', 'Asal Sekolah', 'Provinsi', 'Kabupaten', 'Minat Prodi 1', 'Minat Prodi 2', 'Wilayah (Jabodetabek)', 'Sumber Informasi', 'Kode Referral',
            'S1 - B.Indo', 'S1 - B.Inggris', 'S1 - Mat.Wajib', 'S1 - Mapel 4', 'S1 - Mapel 5', 'Rata Rata S1',
            'S2 - B.Indo', 'S2 - B.Inggris', 'S2 - Mat.Wajib', 'S2 - Mapel 4', 'S2 - Mapel 5', 'Rata Rata S2',
            'S3 - B.Indo', 'S3 - B.Inggris', 'S3 - Mat.Wajib', 'S3 - Mapel 4', 'S3 - Mapel 5', 'Rata Rata S3',
            'S4 - B.Indo', 'S4 - B.Inggris', 'S4 - Mat.Wajib', 'S4 - Mapel 4', 'S4 - Mapel 5', 'Rata Rata S4',
            'S5 - B.Indo', 'S5 - B.Inggris', 'S5 - Mat.Wajib', 'S5 - Mapel 4', 'S5 - Mapel 5', 'Rata Rata S5',
            'TOTAL NILAI S1-S5', 'RATA RATA AKADEMIK (TOT/25)',
            'FOTO', 'RAPOR S1', 'RAPOR S2', 'RAPOR S3', 'RAPOR S4', 'RAPOR S5', 'IJAZAH', 'PERSONAL STATEMENT', 'SURAT BUTA WARNA (DKV)'
        ];

        $rows[] = array_merge($headerBefore, ['SERTIFIKAT', 'LINK VIDEO', 'LINK TWIBBON', 'LINK IG', 'LINK TIKTOK']);

        foreach ($pendaftars as $user) {
            /** @var \App\Models\Akun $user */
            $peserta = $user->peserta;
            $daftar = $peserta?->daftar;
            $berkas = $peserta?->berkas;
            $nilais = $peserta?->nilais ?? collect();

            // New Progress & Detailed Status Logic (Move to FRONT)
            $progress = $peserta?->progress ?? 0;
            if (!$peserta) {
                $status = 'BELUM ISI BIODATA';
            } elseif (!$user->email_verified_at) {
                $status = 'BELUM VERIFIKASI (OTP)';
            } elseif ($progress < 100) {
                $status = 'BELUM LENGKAP (' . $progress . '%)';
            } else {
                $status = '100% BERKAS LENGKAP';
            }

            $row = [
                $status,
                $progress . '%',
                $user->nama,
                $this->cleanDeletedEmail($user->email),
                $peserta?->jenis_kelamin ?? '-',
                $peserta?->no_whatsapp ?? '-',
                $this->cleanDeletedEmail($peserta?->nisn ?? '-'),
                $peserta?->nama_sekolah ?? '-',
                $peserta?->provinsi ?? '-',
                $peserta?->kabupaten ?? '-',
                explode(' | ', $peserta?->pilihan_prodi ?? '')[0] ?? '-',
                explode(' | ', $peserta?->pilihan_prodi ?? '')[1] ?? '-',
                (function($kab) {
                    $kab = strtolower($kab ?? '');
                    $cities = ['jakarta', 'bogor', 'depok', 'tangerang', 'bekasi'];
                    foreach ($cities as $c) if (str_contains($kab, $c)) return "JABODETABEK";
                    return "DI LUAR JABODETABEK";
                })($peserta?->kabupaten ?? null),
                $daftar?->sumber_informasi ?? '-',
                $daftar?->kode_referral ?? '-',
            ];

            // Mapping Nilai S1 - S5
            $totalSemesters = 0;
            $grandTotal = 0;
            for ($s = 1; $s <= 5; $s++) {
                $semNilais = $nilais->where('semester', $s);
                $sBIndo = $semNilais->where('matpel_id', 2)->first()->nilai ?? 0;
                $sBIng = $semNilais->where('matpel_id', 3)->first()->nilai ?? 0;
                $sMat = $semNilais->where('matpel_id', 1)->first()->nilai ?? 0;
                $sAsdad = $semNilais->where('matpel_id', 4)->first()->nilai ?? 0;
                $sBIng2 = $semNilais->where('matpel_id', 5)->first()->nilai ?? 0;

                $totalS = (float)$sBIndo + (float)$sBIng + (float)$sMat + (float)$sAsdad + (float)$sBIng2;
                $avgS = $totalS / 5;
                $grandTotal += $totalS;

                $row[] = $sBIndo;
                $row[] = $sBIng;
                $row[] = $sMat;
                $row[] = $sAsdad;
                $row[] = $sBIng2;
                $row[] = number_format($avgS, 2);
            }

            $row[] = $grandTotal;
            $row[] = number_format($grandTotal / 25, 2);

            // Files (Full URLs)
            $row[] = $this->getFileUrl($berkas->foto ?? null);
            $row[] = $this->getFileUrl($berkas->rapor1 ?? null);
            $row[] = $this->getFileUrl($berkas->rapor2 ?? null);
            $row[] = $this->getFileUrl($berkas->rapor3 ?? null);
            $row[] = $this->getFileUrl($berkas->rapor4 ?? null);
            $row[] = $this->getFileUrl($berkas->rapor5 ?? null);
            $row[] = $this->getFileUrl($berkas->ijazah ?? null);
            $row[] = $this->getFileUrl($berkas->personal_statement ?? null);
            $row[] = $this->getFileUrl($berkas->surat_buta_warna ?? null);

            // Sertifikats (Multiple links in one cell)
            $sertifikats = $peserta?->sertifikats ?? collect();
            $sertifikatUrls = [];
            foreach ($sertifikats as $sertifikatObj) {
                if ($sertifikatObj->file) {
                    $sertifikatUrls[] = $this->getFileUrl($sertifikatObj->file);
                }
            }
            $row[] = count($sertifikatUrls) > 0 ? implode("\n", $sertifikatUrls) : '-';

            // Links (Video, Twibbon, IG & TikTok)
            $row[] = $berkas?->motivasi_video ?? '-';
            $row[] = $peserta?->link_twibbon ?? '-';
            $row[] = $peserta?->link_ig ?? '-';
            $row[] = $peserta?->link_tiktok ?? '-';

            $rows[] = $row;
        }

        $body = new ValueRange(['values' => $rows]);
        $params = ['valueInputOption' => 'USER_ENTERED'];

        // Dynamically find the first sheet title (GID 0) instead of hardcoding 'Sheet1'
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $firstSheetTitle = 'Sheet1'; // Fallback
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getSheetId() == 0) {
                $firstSheetTitle = $sheet->getProperties()->getTitle();
                break;
            }
        }
        
        $this->service->spreadsheets_values->clear($this->spreadsheetId, $firstSheetTitle . '!A1:CZ5000', new \Google\Service\Sheets\ClearValuesRequest());
        $this->service->spreadsheets_values->update($this->spreadsheetId, $firstSheetTitle . '!A1', $body, $params);

        $this->applyFormatting($pendaftars);
        $this->syncSecondSheet();
    }

    /**
     * Sync pendaftars to the second sheet (GID: 433979925)
     * Sorted by registration date (created_at)
     */
    protected function syncSecondSheet()
    {
        if (!$this->service) return;

        $pendaftars = \App\Models\Akun::where('role', 'pendaftar')
            ->orderBy('created_at', 'asc')
            ->get();

        $rows = [];
        $rows[] = ['No', 'Nama Lengkap', 'Email', 'Tanggal Buat Akun'];

        foreach ($pendaftars as $index => $user) {
            $rows[] = [
                $index + 1,
                $user->nama,
                $this->cleanDeletedEmail($user->email),
                $user->created_at->format('d-m-Y H:i:s')
            ];
        }

        $body = new ValueRange(['values' => $rows]);
        $params = ['valueInputOption' => 'USER_ENTERED'];

        // Find sheet title for GID 433979925
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheetTitle = 'Sheet2'; // Fallback
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getSheetId() == 433979925) {
                $sheetTitle = $sheet->getProperties()->getTitle();
                break;
            }
        }

        $this->service->spreadsheets_values->clear($this->spreadsheetId, $sheetTitle . '!A1:D5000', new \Google\Service\Sheets\ClearValuesRequest());
        $this->service->spreadsheets_values->update($this->spreadsheetId, $sheetTitle . '!A1', $body, $params);
    }

    /**
     * Sync wawancara results to the specific sheet (GID: 821132360)
     */
    public function syncWawancara()
    {
        \Illuminate\Support\Facades\Log::info("Memulai syncWawancara...");
        
        if (!$this->service) {
            \Illuminate\Support\Facades\Log::error("syncWawancara: service is null");
            return;
        }

        $pendaftars = \App\Models\Akun::where('role', 'pendaftar')
            ->whereHas('peserta.daftar', function ($q) {
                $q->where('status', 'lulus');
            })
            ->whereHas('peserta', function ($q) {
                $q->where('status_seleksi_ujian', 'lulus');
            })
            ->with(['peserta.daftar', 'peserta.penilaianAkademiks'])
            ->get();

        \Illuminate\Support\Facades\Log::info("syncWawancara: Ditemukan " . $pendaftars->count() . " peserta.");

        $rows = [];
        $rows[] = [
            'No', 'Nama Lengkap', 'Asal Sekolah', 'Email', 'No HP', 'Minat Prodi 1', 'Minat Prodi 2',
            'Total Nilai Akhir',
            'Wawancara Motivasi', 'Wawancara Prestasi', 'Wawancara Karakter', 'Wawancara Kontribusi', 'Wawancara Komunikasi',
            'Rekomendasi Prodi 1', 'Rekomendasi Prodi 2',
            'Rekomendasi Akhir', 'Rekomendasi Beasiswa', 'Catatan Rekomendasi',
            'Penilai (Dosen)', 'Alasan Rekomendasi',
            'Status Wawancara'
        ];

        foreach ($pendaftars as $index => $user) {
            $peserta = $user->peserta;
            $daftar = $peserta?->daftar;
            $penilaian = $peserta?->penilaianAkademiks->first(); // Take the first evaluation

            $rows[] = [
                $index + 1,
                $user->nama,
                $daftar?->asal_sekolah ?? $peserta?->nama_sekolah ?? '-',
                $this->cleanDeletedEmail($user->email),
                $peserta?->no_whatsapp ?? '-',
                explode(' | ', $peserta?->pilihan_prodi ?? '')[0] ?? '-',
                explode(' | ', $peserta?->pilihan_prodi ?? '')[1] ?? '-',
                $penilaian ? $penilaian->total_akhir : '-',
                $penilaian ? $penilaian->wawancara_motivasi : '-',
                $penilaian ? $penilaian->wawancara_prestasi : '-',
                $penilaian ? $penilaian->wawancara_karakter : '-',
                $penilaian ? $penilaian->wawancara_kontribusi : '-',
                $penilaian ? $penilaian->wawancara_komunikasi : '-',
                $penilaian ? $penilaian->rekomendasi_prodi_1 : '-',
                $penilaian ? $penilaian->rekomendasi_prodi_2 : '-',
                $penilaian ? $penilaian->rekomendasi_akhir : '-',
                $penilaian ? $penilaian->rekomendasi_beasiswa : '-',
                $penilaian ? $penilaian->catatan_rekomendasi_beasiswa : '-',
                $penilaian && $penilaian->penilai ? $penilaian->penilai->nama : '-',
                $penilaian ? $penilaian->catatan : '-',
                $penilaian ? 'Sudah Dinilai' : 'Belum Dinilai'
            ];
        }

        $body = new \Google\Service\Sheets\ValueRange(['values' => $rows]);
        $params = ['valueInputOption' => 'USER_ENTERED'];

        // Find sheet title for GID 821132360
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheetTitle = null;
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getSheetId() == 821132360) {
                $sheetTitle = $sheet->getProperties()->getTitle();
                break;
            }
        }

        if ($sheetTitle) {
            $safeSheetTitle = "'" . $sheetTitle . "'";
            \Illuminate\Support\Facades\Log::info("syncWawancara: Menemukan sheet title {$sheetTitle}. Melakukan update ke GSheet...");
            $this->service->spreadsheets_values->clear($this->spreadsheetId, $safeSheetTitle . '!A1:Z5000', new \Google\Service\Sheets\ClearValuesRequest());
            $this->service->spreadsheets_values->update($this->spreadsheetId, $safeSheetTitle . '!A1', $body, $params);
            \Illuminate\Support\Facades\Log::info("syncWawancara: Update GSheet selesai.");
        } else {
            \Illuminate\Support\Facades\Log::warning("Sheet with GID 821132360 not found in spreadsheet {$this->spreadsheetId}");
        }
    }

    protected function cleanDeletedEmail($val)
    {
        if (strpos($val, 'deleted_') === 0) {
            $parts = explode('_', $val, 3);
            return $parts[2] ?? $val;
        }
        return $val;
    }

    protected function getFileUrl($path)
    {
        if (!$path) return '-';
        return url('storage/' . $path);
    }

    protected function applyFormatting($pendaftars)
    {
        $requests = [];
        $index = 1;

        // Get the sheetId for first sheet (GID 0)
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheetId = 0;
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getSheetId() == 0) {
                $sheetId = $sheet->getProperties()->getSheetId();
                break;
            }
        }

        // Active users formatting and other logic can be placed here if needed.
        // For now, we skip the red formatting logic as deleted users are gone from DB.

        if (count($requests) > 0) {
            $this->service->spreadsheets->batchUpdate(
                $this->spreadsheetId,
                new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest(['requests' => $requests])
            );
        }
    }
}
