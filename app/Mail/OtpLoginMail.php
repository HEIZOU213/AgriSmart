<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // <--- 1. TAMBAHAN PENTING
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// 2. TAMBAHKAN 'implements ShouldQueue' DI SINI
class OtpLoginMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $otp; // Variable ini yang akan membawa angka ke view

    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Kode Masuk AgriSmart Anda') // Judul Email
                    ->view('emails.otp_login'); // Nama file tampilan
    }
}