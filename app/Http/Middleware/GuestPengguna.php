<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
