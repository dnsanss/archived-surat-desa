<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifikasiEmailPengguna extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $nama;

    public function __construct($token, $nama)
    {
        $this->token = $token;
        $this->nama  = $nama;
    }


    public function build()
    {
        return $this->subject('Verifikasi Email Akun Anda')
            ->view('frontend.verifikasi-email');
    }
}
