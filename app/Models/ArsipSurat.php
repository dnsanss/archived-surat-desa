<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ArsipSurat extends Model
{
    protected $table = 'arsip_surat';

    protected $fillable = [
        'nomor_surat',
        'nama_surat',
        'perihal',
        'dokumen'
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($arsip) {
            if ($arsip->dokumen && Storage::disk('local')->exists($arsip->dokumen)) {
                Storage::disk('local')->delete($arsip->dokumen);
            }
        });
    }
}
