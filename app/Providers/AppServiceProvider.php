<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //set locale aplikasi ke Bahasa Indonesia
        App::setLocale('id');

        //set locale Carbon ke Bahasa Indonesia
        Carbon::setLocale('id');
    }
}
