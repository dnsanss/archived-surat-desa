<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'warga_id',
        'nik',
        'nama',
        'template_id',
        'nomor_wa',
        'nomor_surat',
        'isi_surat',
        'kepada',
        'tanggal_pengajuan',
        'status',
    ];

    public function template()
    {
        return $this->belongsTo(TemplateSurat::class, 'template_id');
    }

    public function suratTerbit()
    {
        return $this->hasOne(SuratTerbit::class, 'pengajuan_id');
    }
}
