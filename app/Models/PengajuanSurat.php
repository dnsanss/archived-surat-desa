<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'nik',
        'nama',
        'template_id',
        'nomor_surat',
        'kepada',
        'tanggal_pengajuan',
        'catatan',
        'status',
    ];

    public function template()
    {
        return $this->belongsTo(TemplateSurat::class, 'template_id');
    }
}
