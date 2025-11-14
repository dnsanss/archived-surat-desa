<?php

namespace App\Helpers;

use Carbon\Carbon;

class SuratHelper
{
    public static function replaceVariables($template, $warga)
    {
        $map = [
            '{{nama}}' => $warga->nama,
            '{{nik}}' => $warga->nik,
            '{{alamat}}' => $warga->alamat,
            '{{tempat_lahir}}' => $warga->tempat_lahir,
            '{{tanggal_lahir}}' => Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y'),
            '{{jenis_kelamin}}' => $warga->jenis_kelamin,
            '{{agama}}' => $warga->agama,
            '{{pekerjaan}}' => $warga->pekerjaan,
            '{{status_perkawinan}}' => $warga->status_perkawinan,
            '{{kewarganegaraan}}' => $warga->kewarganegaraan,
        ];

        return str_replace(array_keys($map), array_values($map), $template);
    }
}
