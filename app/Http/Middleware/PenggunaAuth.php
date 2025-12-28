<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PenggunaAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('pengguna_login')) {
            return redirect()->route('login')
                ->with('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini.');
        }
        $pengguna = session('data_pengguna');

        // Cek data session rusak
        if (!$pengguna) {
            session()->flush();
            return redirect()->route('login');
        }

        // Cek email verified
        if ($pengguna->email_verified_at === null) {
            return redirect()
                ->route('email.notice')
                ->with('error', 'Silakan verifikasi email terlebih dahulu.');
        }

        return $next($request);
    }
}
