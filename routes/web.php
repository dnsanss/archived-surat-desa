<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\WargaAuthController;
use App\Http\Controllers\ProsesSuratController;
use App\Http\Controllers\PelacakanSuratController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\WargaPengajuanController;
use App\Http\Controllers\VerifikasiSuratController;
use App\Http\Controllers\PenyimpananSuratController;

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
Route::get('/surat-masuk/view', function () {

    $path = request()->query('path');

    if (!$path) {
        abort(400, 'Path file tidak valid.');
    }

    if (!Storage::disk('supabase')->exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    $file = Storage::disk('supabase')->get($path);

    return response($file, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline',
    ]);
})->name('surat-masuk.view')->middleware('auth');

// route untuk download arsip surat
Route::get('/surat-masuk/download', function () {

    $path = request()->query('path');

    if (!$path) {
        abort(400, 'Path file tidak valid.');
    }

    if (!Storage::disk('supabase')->exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    $file = Storage::disk('supabase')->get($path);

    return response($file, 200, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . basename($path) . '"',
    ]);
})->name('surat-masuk.download')->middleware('auth');

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
Route::get('/surat-keluar/view', function () {

    $path = request()->query('path');

    if (!$path) {
        abort(400, 'Path file tidak valid.');
    }

    // ambil file dari Supabase
    if (!Storage::disk('supabase')->exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    $file = Storage::disk('supabase')->get($path);

    return response($file, 200, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
    ]);
})->name('surat-keluar.view')->middleware('auth');

// route untuk download dokumen di surat keluar
Route::get('/surat-keluar/download', function () {

    $path = request()->query('path');

    if (!$path) {
        abort(400, 'Path file tidak valid.');
    }

    if (!Storage::disk('supabase')->exists($path)) {
        abort(404, 'File tidak ditemukan.');
    }

    $file = Storage::disk('supabase')->get($path);

    return response($file, 200, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . basename($path) . '"',
    ]);
})->name('surat-keluar.download')->middleware('auth');

// route untuk verifikasi surat via QR Code
Route::get('/verifikasi-surat/{token}', [VerifikasiSuratController::class, 'show'])
    ->name('verifikasi.surat');

// route untuk download dokumen di halaman verifikasi surat
Route::get('/verifikasi-surat/{token}', [VerifikasiSuratController::class, 'show'])->name('verifikasi.surat');
Route::get('/verifikasi-surat/download/{token}', [VerifikasiSuratController::class, 'download'])->name('verifikasi.download');

Route::middleware('guest.pengguna')->group(function () {
    // login
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
    // register
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.submit');
});

// route untuk verifikasi email pengguna
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])
    ->name('email.verify');

// route untuk halaman pemberitahuan email belum verifikasi
Route::get('/email-belum-verifikasi', function () {
    return view('frontend.email-not-verified');
})->name('email.notice');


// 3 fitur utama di pengajuan surat
Route::middleware('pengguna')->group(function () {
    // logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Pengajuan surat
    Route::get('/pengajuan-surat/form-pengajuan-surat', [WargaPengajuanController::class, 'form'])
        ->name('form.pengajuan.surat');

    Route::post('/pengajuan-surat/store', [WargaPengajuanController::class, 'store'])
        ->name('pengajuan.store');

    //Lacak surat
    Route::get('/pengajuan-surat/pelacakan-surat', [PelacakanSuratController::class, 'index'])
        ->name('pelacakan.surat');

    //route untuk melihat detail pelacakan surat
    Route::get('/pelacakan/{id}', [PelacakanSuratController::class, 'show'])->name('pelacakan.show');

    // Penyimpanan surat
    Route::get('/pengajuan-surat/penyimpanan-surat', [PenyimpananSuratController::class, 'index'])
        ->name('penyimpanan.surat');

    Route::get('/penyimpanan/{id}', [PenyimpananSuratController::class, 'show'])
        ->name('penyimpanan.show');
});

// route untuk download surat di penyimpanan surat
Route::get('/download-surat/{token}', [PenyimpananSuratController::class, 'download'])
    ->name('surat.download');
