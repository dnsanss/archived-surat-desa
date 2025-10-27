<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProsesSuratController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\BeritaController;
use App\Models\Berita;

// import controller pengajuan surat
Route::get('/profil-desa', [FrontendController::class, 'profilDesa'])->name('profil-desa');

// route untuk halaman struktur pemerintahan
Route::get('/struktur-pemerintahan', function () {
    return view('frontend.struktur-pemerintahan');
})->name('struktur-pemerintahan');

// berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.judul');

// route untuk melihat arsip surat
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

// import controller pengajuan surat
Route::get('/pengajuan-surat', [PengajuanSuratController::class, 'index'])->name('pengajuan-surat');

// route untuk menyimpan pengajuan surat
Route::post('/pengajuan-surat', [PengajuanSuratController::class, 'store'])->name('pengajuan-surat.store');

// route untuk halaman sukses pengajuan surat
Route::get('/pengajuan-surat/sukses', [PengajuanSuratController::class, 'sukses'])->name('pengajuan-surat.sukses');

// route untuk halaman proses surat (admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/proses-surat/{id}', [ProsesSuratController::class, 'generate'])
        ->name('admin.proses-surat');
});