<?php

namespace App\Http\Controllers;

use App\Models\SuratTerbit;
use App\Models\DataWarga;

class VerifikasiSuratController extends Controller
{
    // Halaman verifikasi surat
    public function show($token)
    {
        $surat = SuratTerbit::where('qr_token', $token)->first();

        if (!$surat) {
            return view('pdf.verifikasi-surat', [
                'valid' => false,
                'message' => 'Kode verifikasi tidak valid atau surat tidak ditemukan.',
            ]);
        }

        $pengajuan = $surat->pengajuan;
        $template  = $pengajuan?->template;
        $warga     = $pengajuan
            ? DataWarga::where('nik', $pengajuan->nik)->first()
            : null;

        return view('pdf.verifikasi-surat', [
            'valid'    => true,
            'message'  => null,
            'surat'    => $surat,
            'template' => $template,
            'warga'    => $warga,
        ]);
    }

    // Download PDF surat terverifikasi
    public function download($token)
    {
        $surat = SuratTerbit::where('qr_token', $token)->firstOrFail();

        if (!$surat->file_pdf) {
            abort(404, 'File surat tidak ditemukan.');
        }

        // URL file Supabase
        $fileUrl = config('services.supabase.url')
            . '/storage/v1/object/public/'
            . config('services.supabase.bucket')
            . '/' . $surat->file_pdf;

        // Nama file aman
        $namaFile = 'Surat-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';

        return redirect()->away($fileUrl . '?download=' . urlencode($namaFile));
    }
}
