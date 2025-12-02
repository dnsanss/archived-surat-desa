<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WargaAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah warga sudah login
        if (!session()->has('warga_logged_in')) {
            // Jika belum login → redirect ke halaman login warga
            return redirect()->route('warga.login')
                ->with('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}
