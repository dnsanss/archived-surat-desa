<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [FrontendController::class, 'profilDesa'])->name('profil-desa');


Route::get('/struktur-pemerintahan', function () {
    return view('frontend.struktur-pemerintahan');
})->name('struktur-pemerintahan');
