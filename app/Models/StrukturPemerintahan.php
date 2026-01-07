<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturPemerintahan extends Model
{
    protected $table = 'struktur_pemerintahan';

    protected $fillable = [
        'nama',
        'jabatan',
    ];
}
