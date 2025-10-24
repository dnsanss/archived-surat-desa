<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'templates_surat';

    protected $fillable = [
        'nama_template',
        'isi_template',
        'nomor_surat',
    ];

    public function pengajuan()
    {
        return $this->hasMany(PengajuanSurat::class, 'template_id');
    }
}
