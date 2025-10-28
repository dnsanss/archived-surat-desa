<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratTerbit extends Model
{
    use HasFactory;

    protected $table = 'surat_terbit';

    protected $fillable = [
        'pengajuan_id',
        'nomor_surat',
        'kepada',
        'file_pdf',
        'tanggal_pengajuan',
        'qrcode_path',
    ];

    protected static function booted()
    {
        static::deleting(function ($surat) {
            if ($surat->file_pdf && Storage::disk('local')->exists($surat->file_pdf)) {
                Storage::disk('local')->delete($surat->file_pdf);
            }
        });
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
