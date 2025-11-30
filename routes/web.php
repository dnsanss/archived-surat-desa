<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\WargaAuthController;
use App\Http\Controllers\ProsesSuratController;
use App\Http\Controllers\PelacakanSuratController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\WargaPengajuanController;
use App\Http\Controllers\VerifikasiSuratController;

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
Route::get('/surat-masuk/view/{filename}', function ($filename) {
    $path = storage_path('app/surat-masuk/' . $filename);

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    $mimeType = mime_content_type($path);
    return response()->file($path, [
        'Content-Type' => $mimeType,
    ]);
})->name('surat-masuk.view')->middleware('auth');

// import controller pengajuan surat
Route::get('/pengajuan-surat', [FrontendController::class, 'pengajuanSurat'])
    ->name('pengajuan-surat');

// route untuk halaman sukses pengajuan surat
Route::get('/pengajuan-surat-sukses/{id}', [WargaPengajuanController::class, 'sukses'])
    ->name('pengajuan-surat-sukses');

// route untuk halaman proses surat (admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/proses-surat/{id}', [ProsesSuratController::class, 'generate'])
        ->name('admin.proses-surat');
});

// route untuk view dokumen di surat keluar
Route::get('/surat-keluar/view/{filename}', function ($filename) {
    $path = storage_path('app/surat-keluar/' . $filename);

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    $mimeType = mime_content_type($path);
    return response()->file($path, [
        'Content-Type' => $mimeType,
    ]);
})->name('surat-keluar.view')->middleware('auth');

// route untuk verifikasi surat via QR Code
Route::get('/verifikasi-surat/{token}', [VerifikasiSuratController::class, 'show'])
    ->name('verifikasi.surat');

// route untuk download dokumen di halaman verifikasi surat
Route::get('/verifikasi-surat/{token}', [VerifikasiSuratController::class, 'show'])->name('verifikasi.surat');
Route::get('/verifikasi-surat/download/{token}', [VerifikasiSuratController::class, 'download'])->name('verifikasi.download');

// login warga
Route::get('/login-warga', [WargaAuthController::class, 'showLoginForm'])
    ->name('warga.login');

Route::post('/login-warga', [WargaAuthController::class, 'login'])
    ->name('warga.login.submit');

Route::get('/logout-warga', [WargaAuthController::class, 'logout'])
    ->name('warga.logout');

// 3 fitur utama di pengajuan surat
Route::middleware('warga')->group(function () {

    // 🔹 1. Pengajuan surat
    Route::get('/pengajuan-surat/form-pengajuan-surat', [WargaPengajuanController::class, 'form'])
        ->name('form.pengajuan.surat');

    Route::post('/pengajuan-surat/store', [WargaPengajuanController::class, 'store'])
        ->name('pengajuan.store');

    // 🔹 2. Lacak surat
    Route::get('/pengajuan-surat/pelacakan-surat', [PelacakanSuratController::class, 'index'])
        ->name('pelacakan.surat');

    //route untuk melihat detail pelacakan surat
    Route::get('/pelacakan/{id}', [PelacakanSuratController::class, 'show'])->name('pelacakan.show');

    // 🔹 3. Penyimpanan surat
    Route::get('/pengajuan-surat/penyimpanan-surat', [WargaPengajuanController::class, 'penyimpanan'])
        ->name('penyimpanan.surat');
});
