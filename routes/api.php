<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PengajuanSuratController;


// route login api
Route::post('/login', [AuthController::class, 'login']);

// route protected pengajuan surat
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pengajuan-surat', [PengajuanSuratController::class, 'store']);
});

// route protected list pengajuan surat
Route::middleware('auth:sanctum')->get(
    '/pengajuan-surat',
    [PengajuanSuratController::class, 'index']
);

// route protected detail pengajuan surat
Route::middleware('auth:sanctum')->get(
    '/pengajuan-surat/{id}',
    [PengajuanSuratController::class, 'show']
);
