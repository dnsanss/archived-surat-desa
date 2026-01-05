<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SuratTerbit extends Model
{
    protected $table = 'surat_terbit';

    protected $fillable = [
        'pengajuan_id',
        'warga_id',
        'nomor_surat',
        'kepada',
        'diproses_oleh',
        'file_pdf',
        'tanggal_pengajuan',
        'qrcode_path',
        'qr_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($surat) {

            // 🧩 Hapus file PDF
            if (!empty($surat->file_pdf)) {
                // Hapus "storage/" dari awal path agar cocok dengan lokasi storage/app
                $pathPdf = str_replace('storage/', '', trim($surat->file_pdf));

                if (Storage::disk('local')->exists($pathPdf)) {
                    Storage::disk('local')->delete($pathPdf);
                    logger("✅ File PDF dihapus: $pathPdf");
                } else {
                    logger("⚠️ File PDF tidak ditemukan: $pathPdf");
                }
            }

            // 🧩 Hapus file QR Code
            if (!empty($surat->qrcode_path)) {
                // Hapus "storage/" dari awal path juga
                $qrPath = str_replace('storage/', '', trim($surat->qrcode_path));

                if (Storage::disk('public')->exists($qrPath)) {
                    Storage::disk('public')->delete($qrPath);
                    logger("✅ File QR dihapus (public): $qrPath");
                } elseif (Storage::disk('local')->exists($qrPath)) {
                    Storage::disk('local')->delete($qrPath);
                    logger("✅ File QR dihapus (local): $qrPath");
                } else {
                    logger("⚠️ File QR tidak ditemukan: $qrPath");
                }
            }
        });
    }

    public function warga()
    {
        return $this->belongsTo(DataWarga::class, 'warga_id');
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
