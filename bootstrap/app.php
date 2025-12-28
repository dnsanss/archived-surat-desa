<?php

use App\Http\Middleware\WargaAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ALIAS MIDDLEWARE
        $middleware->alias([
            'pengguna' => \App\Http\Middleware\PenggunaAuth::class,
            'guest.pengguna' => \App\Http\Middleware\GuestPengguna::class,
        ]);

        // GROUP WEB (WAJIB – JANGAN DIHAPUS)
        $middleware->group('web', [
            // COOKIE & SESSION
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,

            // SHARE ERROR + CSRF
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,

            // ROUTING
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
