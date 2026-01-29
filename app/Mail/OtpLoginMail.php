<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpLoginMail extends Mailable
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
                    ->view('emails.otp_login'); // Nama file tampilan (kita buat di langkah 2.3)
    }
}