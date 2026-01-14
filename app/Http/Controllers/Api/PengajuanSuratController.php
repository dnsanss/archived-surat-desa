<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataPengguna;
use App\Models\DataWarga;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;
use App\Helpers\SuratHelper;

class PengajuanSuratController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:templates_surat,id',
        ]);

        $user = $request->user(); // 🔑 dari Sanctum

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $pengguna = DataPengguna::findOrFail($user->id);
        $warga = DataWarga::where('nik', $pengguna->nik)->firstOrFail();
        $template = TemplateSurat::findOrFail($request->template_id);

        $isiSurat = SuratHelper::replaceVariables(
            $template->isi_template,
            $warga
        );

        $pengajuan = PengajuanSurat::create([
            'warga_id'          => $warga->id,
            'nik'               => $warga->nik,
            'nama'              => $warga->nama,
            'template_id'       => $template->id,
            'nomor_surat'       => $template->nomor_surat,
            'nomor_wa'          => $pengguna->nomor_hp,
            'isi_surat'         => $isiSurat,
            'tanggal_pengajuan' => now(),
            'status'            => 'menunggu',
        ]);

        return response()->json([
            'success' => true,
            'data' => $pengajuan
        ], 201);
    }
}
