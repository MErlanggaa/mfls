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

        if (!$this->spreadsheetId || !file_exists($credentialsPath)) {
            \Illuminate\Support\Facades\Log::warning('Google Sheets configuration missing or invalid. Path: '.$credentialsPath);
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
            ->with(['peserta.daftar', 'peserta.nilais.matpel', 'peserta.berkas'])
            ->get();

        $rows = [];
        // Header (52 Columns)
        $rows[] = [
            'Nama Lengkap', 'Email', 'Nomor HP', 'NISN', 'Asal Sekolah', 'Prodi Minat', 'Kode Referral',
            'S1 - B.Indo', 'S1 - B.Inggris', 'S1 - Mat.Wajib', 'S1 - asdad', 'S1 - B.Inggrisas', 'Rata Rata S1',
            'S2 - B.Indo', 'S2 - B.Inggris', 'S2 - Mat.Wajib', 'S2 - asdad', 'S2 - B.Inggrisas', 'Rata Rata S2',
            'S3 - B.Indo', 'S3 - B.Inggris', 'S3 - Mat.Wajib', 'S3 - asdad', 'S3 - B.Inggrisas', 'Rata Rata S3',
            'S4 - B.Indo', 'S4 - B.Inggris', 'S4 - Mat.Wajib', 'S4 - asdad', 'S4 - B.Inggrisas', 'Rata Rata S4',
            'S5 - B.Indo', 'S5 - B.Inggris', 'S5 - Mat.Wajib', 'S5 - asdad', 'S5 - B.Inggrisas', 'Rata Rata S5',
            'TOTAL NILAI S1-S5', 'RATA RATA AKADEMIK (TOT/25)',
            'FOTO', 'RAPOR S1', 'RAPOR S2', 'RAPOR S3', 'RAPOR S4', 'RAPOR S5', 'IJAZAH', 'PERSONAL STATEMENT', 'SURAT BUTA WARNA (DKV)',
            'LINK VIDEO', 'LINK TWIBBON', 'LINK IG', 'LINK TIKTOK', 'PROGRES (%)', 'STATUS'
        ];

        foreach ($pendaftars as $user) {
            /** @var \App\Models\Akun $user */
            $peserta = $user->peserta;
            if (!$peserta) continue;

            $daftar = $peserta->daftar;
            $berkas = $peserta->berkas;
            $nilais = $peserta->nilais;

            $row = [
                $user->nama,
                $this->cleanDeletedEmail($user->email),
                $peserta->no_whatsapp ?? '-',
                $this->cleanDeletedEmail($peserta->nisn),
                $peserta->nama_sekolah ?? '-',
                $peserta->pilihan_prodi ?? '-',
                $daftar->kode_referral ?? '-',
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

                $totalS = $sBIndo + $sBIng + $sMat + $sAsdad + $sBIng2;
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

            // Links
            $row[] = $berkas->motivasi_video ?? '-';
            $row[] = $peserta->link_twibbon ?? '-';
            $row[] = $peserta->link_ig ?? '-';
            $row[] = $peserta->link_tiktok ?? '-';

            // New Progress & Detailed Status Logic
            $progress = $peserta->progress;
            $row[] = $progress . '%'; // New PROGRESS Column

            if (!$user->email_verified_at) {
                $status = 'BELUM VERIFIKASI (OTP)';
            } elseif ($progress < 100) {
                $status = 'BELUM LENGKAP (' . $progress . '%)';
            } else {
                $status = 'SUDAH LENGKAP';
            }
            $row[] = $status;

            $rows[] = $row;
        }

        $body = new ValueRange(['values' => $rows]);
        $params = ['valueInputOption' => 'RAW'];
        
        $this->service->spreadsheets_values->clear($this->spreadsheetId, 'Sheet1!A1:AZ5000', new \Google\Service\Sheets\ClearValuesRequest());
        $this->service->spreadsheets_values->update($this->spreadsheetId, 'Sheet1!A1', $body, $params);

        $this->applyFormatting($pendaftars);
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
