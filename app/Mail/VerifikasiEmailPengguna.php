<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VerifikasiEmailPengguna extends Mailable
{
    public $pengguna;

    public function __construct($pengguna)
    {
        $this->pengguna = $pengguna;
    }

    public function build()
    {
        return $this->subject('Verifikasi Email Akun Anda')
            ->view('emails.verifikasi-email');
    }
}
