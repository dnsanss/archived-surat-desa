<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use App\Models\SuratTerbit;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;
use App\Http\Controllers\Controller;

class VerifikasiSuratController extends Controller
{
    // route untuk menampilkan halaman verifikasi surat
    public function show($token)
    {
        // Cari surat berdasarkan token QR
        $surat = SuratTerbit::where('qr_token', $token)->first();

        if (!$surat) {
            return view('pdf.verifikasi-surat', [
                'valid' => false,
                'message' => 'Kode verifikasi tidak valid atau surat tidak ditemukan.',
            ]);
        }

        // Ambil data pengajuan & relasinya
        $pengajuan = $surat->pengajuan;
        $template = $pengajuan ? $pengajuan->template : null;
        $warga = $pengajuan
            ? \App\Models\DataWarga::where('nik', $pengajuan->nik)->first()
            : null;

        return view('pdf.verifikasi-surat', [
            'valid' => true,
            'message' => null,
            'surat' => $surat,
            'template' => $template,
            'warga' => $warga,
        ]);
    }

    // route untuk download file surat terverifikasi
    public function download($token)
    {
        $surat = SuratTerbit::where('qr_token', $token)->firstOrFail();

        $filePath = str_replace('storage/', '', $surat->file_pdf); // hapus prefix agar sesuai dengan disk lokal
        $fullPath = storage_path('app/' . $filePath);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($fullPath);
    }
}
