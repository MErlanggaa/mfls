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

        // Calculate max certificates
        $maxSertifikatCount = 0;
        foreach ($pendaftars as $user) {
            $peserta = $user->peserta;
            if ($peserta && $peserta->sertifikats) {
                $count = $peserta->sertifikats->count();
                if ($count > $maxSertifikatCount) {
                    $maxSertifikatCount = $count;
                }
            }
        }
        $maxSertifikatCount = max(3, $maxSertifikatCount); // Minimum 3 columns for certificates

        $sertifikatHeaders = [];
        for ($i = 1; $i <= $maxSertifikatCount; $i++) {
            $sertifikatHeaders[] = "SERTIFIKAT {$i} (NAMA)";
            $sertifikatHeaders[] = "SERTIFIKAT {$i} (LINK)";
        }

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

        $headerAfter = [
            'LINK VIDEO MOTIVASI', 'LINK TWIBBON'
        ];

        $rows[] = array_merge($headerBefore, $sertifikatHeaders, $headerAfter);

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

            // Sertifikats
            $sertifikats = $peserta?->sertifikats ?? collect();
            for ($i = 0; $i < $maxSertifikatCount; $i++) {
                $sertifikatObj = $sertifikats->get($i);
                if ($sertifikatObj) {
                    $row[] = $sertifikatObj->nama ?? '-';
                    $row[] = $sertifikatObj->file ? $this->getFileUrl($sertifikatObj->file) : '-';
                } else {
                    $row[] = '-';
                    $row[] = '-';
                }
            }

            // Links
            $row[] = $berkas->motivasi_video ?? '-';
            $row[] = $peserta?->link_twibbon ?? '-';

            $rows[] = $row;
        }

        $body = new ValueRange(['values' => $rows]);
        $params = ['valueInputOption' => 'RAW'];
        
        $this->service->spreadsheets_values->clear($this->spreadsheetId, 'Sheet1!A1:CZ5000', new \Google\Service\Sheets\ClearValuesRequest());
        $this->service->spreadsheets_values->update($this->spreadsheetId, 'Sheet1!A1', $body, $params);

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
        $params = ['valueInputOption' => 'RAW'];

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

        // Get the sheetId for 'Sheet1'
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheetId = 0;
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getTitle() === 'Sheet1') {
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
