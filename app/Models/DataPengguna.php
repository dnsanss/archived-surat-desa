<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DataPengguna extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    protected $table = 'data_pengguna';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'nik',
        'email',
        'google_id',
        'nomor_hp',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVerified()
    {
        return !is_null($this->email_verified_at);
    }

    //   Relasi ke data_warga berdasarkan NIK
    public function warga()
    {
        return $this->belongsTo(DataWarga::class, 'nik', 'nik');
    }

    //Pengajuan surat milik pengguna
    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class, 'warga_id', 'id');
    }
}
