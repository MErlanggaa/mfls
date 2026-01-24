<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UjianLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $linkUjian;

    public function __construct($nama, $linkUjian)
    {
        $this->nama = $nama;
        $this->linkUjian = $linkUjian;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan Ujian Online MFLS 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ujian_link',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
