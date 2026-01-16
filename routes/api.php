<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TemplateSuratController;
use App\Http\Controllers\Api\PengajuanSuratController;
use App\Http\Controllers\Api\PenyimpananSuratApiController;


// route login api
Route::post('/login', [AuthController::class, 'login']);

// route protected pengajuan surat
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pengajuan-surat', [PengajuanSuratController::class, 'store']);
    Route::get('/pengajuan-surat', [PengajuanSuratController::class, 'index']);
    Route::get('/pengajuan-surat/{id}', [PengajuanSuratController::class, 'show']);
});

Route::middleware('auth:sanctum')->get(
    '/templates-surat',
    [TemplateSuratController::class, 'index']
);

// route protected penyimpanan surat
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/penyimpanan-surat', [PenyimpananSuratApiController::class, 'index']);
    Route::get('/penyimpanan-surat/{id}', [PenyimpananSuratApiController::class, 'show']);
    Route::get('/penyimpanan-surat/download/{token}', [PenyimpananSuratApiController::class, 'download']);
});
