<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class DataWarga extends Authenticatable
{
    protected $table = 'data_warga';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'agama',
        'pendidikan',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
    ];

    public function pengajuan()
    {
        return $this->hasMany(PengajuanSurat::class, 'warga_id');
    }

    public function suratTerbit()
    {
        return $this->hasManyThrough(
            SuratTerbit::class,
            PengajuanSurat::class,
            'warga_id',       // foreign key di tabel pengajuan_surat
            'pengajuan_id',   // foreign key di tabel surat_terbit
            'id',             // local key di data_warga
            'id'              // local key di pengajuan_surat
        );
    }
}
