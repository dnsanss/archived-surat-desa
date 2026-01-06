<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'tanggal_publikasi',
    ];

    protected static function boot()
    {
        parent::boot();

        //Hapus gambar saat berita dihapus
        static::deleting(function ($berita) {

            if (!$berita->gambar) {
                return;
            }

            if (Storage::disk('supabase')->exists($berita->gambar)) {
                Storage::disk('supabase')->delete($berita->gambar);

                logger()->info('Gambar berita dihapus dari Supabase', [
                    'path' => $berita->gambar,
                ]);
            } else {
                logger()->warning('Gambar berita tidak ditemukan di Supabase', [
                    'path' => $berita->gambar,
                ]);
            }
        });

        //Hapus gambar lama saat update gambar baru
        static::updating(function ($berita) {

            if (!$berita->isDirty('gambar')) {
                return;
            }

            $oldImage = $berita->getOriginal('gambar');

            if ($oldImage && Storage::disk('supabase')->exists($oldImage)) {
                Storage::disk('supabase')->delete($oldImage);

                logger()->info('Gambar lama berita dihapus dari Supabase', [
                    'path' => $oldImage,
                ]);
            }
        });
    }
}
