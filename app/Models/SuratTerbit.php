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

            $disk = Storage::disk('supabase');

            // 🧩 Hapus file PDF di Supabase
            if (!empty($surat->file_pdf)) {
                if ($disk->exists($surat->file_pdf)) {
                    $disk->delete($surat->file_pdf);
                    logger("✅ Supabase PDF dihapus: {$surat->file_pdf}");
                } else {
                    logger("⚠️ Supabase PDF tidak ditemukan: {$surat->file_pdf}");
                }
            }

            // 🧩 Hapus QR Code di Supabase
            if (!empty($surat->qrcode_path)) {
                if ($disk->exists($surat->qrcode_path)) {
                    $disk->delete($surat->qrcode_path);
                    logger("✅ Supabase QR Code dihapus: {$surat->qrcode_path}");
                } else {
                    logger("⚠️ Supabase QR Code tidak ditemukan: {$surat->qrcode_path}");
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
