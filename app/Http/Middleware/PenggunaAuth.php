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

        return $next($request);
    }
}
