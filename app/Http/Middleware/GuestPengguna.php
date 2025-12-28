<?php

namespace App\Http\Middleware;

use Closure;

class GuestPengguna
{
    public function handle($request, Closure $next)
    {
        if (session('pengguna_login')) {
            return redirect()->route('form.pengajuan.surat');
        }
        return $next($request);
    }
}
