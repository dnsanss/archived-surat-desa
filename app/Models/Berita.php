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
        'penulis'
    ];

    protected static function boot()
    {
        parent::boot();

        // menghapus file gambar saat data berita dihapus
        static::deleting(function ($berita) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
        });

        // menghapus file gambar lama saat data berita diperbarui dengan gambar barustatic::updating(function ($berita) {
        static::updating(function ($berita) {
            if ($berita->isDirty('gambar')) {
                $oldImage = $berita->getOriginal('gambar');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        });
    }
}
