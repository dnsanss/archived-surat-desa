<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
