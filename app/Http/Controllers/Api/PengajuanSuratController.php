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

    public function index(Request $request)
    {
        $user = $request->user(); // dari Sanctum

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Ambil data pengguna
        $pengguna = DataPengguna::findOrFail($user->id);

        // Ambil warga berdasarkan NIK
        $warga = DataWarga::where('nik', $pengguna->nik)->first();

        if (!$warga) {
            return response()->json([
                'message' => 'Data warga tidak ditemukan'
            ], 404);
        }

        // Ambil pengajuan surat milik warga
        $pengajuan = PengajuanSurat::with('template')
            ->where('warga_id', $warga->id)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'nik' => $item->nik,
                    'jenis_surat' => $item->template->nama_template ?? '-',
                    'tanggal_pengajuan' => $item->tanggal_pengajuan
                        ? $item->tanggal_pengajuan->format('d-m-Y')
                        : $item->created_at->format('d-m-Y'),
                    'status' => $item->status,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $pengajuan
        ]);
    }
}
