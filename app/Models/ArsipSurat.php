<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ArsipSurat extends Model
{
    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'nama_surat',
        'perihal',
        'dokumen',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($arsip) {

            if (!$arsip->dokumen) {
                return;
            }

            // HAPUS FILE LANGSUNG DARI SUPABASE
            if (Storage::disk('supabase')->exists($arsip->dokumen)) {
                Storage::disk('supabase')->delete($arsip->dokumen);

                logger()->info('Arsip surat dihapus dari Supabase', [
                    'path' => $arsip->dokumen,
                ]);
            } else {
                logger()->warning('File arsip tidak ditemukan di Supabase', [
                    'path' => $arsip->dokumen,
                ]);
            }
        });
    }
}
