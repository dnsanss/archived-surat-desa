<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/profil-desa', [FrontendController::class, 'profilDesa'])->name('profil-desa');

Route::get('/struktur-pemerintahan', function () {
    return view('frontend.struktur-pemerintahan');
})->name('struktur-pemerintahan');

Route::get('/arsip/view/{filename}', function ($filename) {
    $path = storage_path('app/arsip-surat/' . $filename);

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    $mimeType = mime_content_type($path);
    return response()->file($path, [
        'Content-Type' => $mimeType,
    ]);
})->name('arsip.view')->middleware('auth');
