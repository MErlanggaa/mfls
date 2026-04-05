<?php

namespace App\Services;

use App\Models\Akun;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CertificateService
{
    /**
     * Generate Certificate PDF.
     */
    public function generatePdf($id)
    {
        $user = Akun::with('peserta')->findOrFail($id);
        $nama = $user->nama;

        return Pdf::loadView('admin.sertifikat.template_pdf', compact('nama'))
            ->setPaper('a4', 'landscape');
    }

    /**
     * Send Certificate via Email.
     */
    public function sendEmail($id)
    {
        $user = Akun::with('peserta')->findOrFail($id);
        $nama = $user->nama;
        $email = $user->email;

        try {
            $pdfContent = $this->generatePdf($id)->output();
            Mail::mailer('gmail')->to($user->email)->send(new \App\Mail\CertificateMail($user->nama, $pdfContent));

            // Mark as sent
            $user->is_sertifikat_sent = true;
            $user->save();

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send certificate to $email: " . $e->getMessage());
            return false;
        }
    }
}
