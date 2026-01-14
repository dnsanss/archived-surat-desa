<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\DataWarga;
use App\Models\SuratTerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PenyimpananSuratApiController extends Controller
{
    // LIST SURAT TERSIMPAN
    public function index(Request $request)
    {
        $user = $request->user(); // dari Sanctum

        $warga = DataWarga::where('nik', $user->nik)->first();

        if (!$warga) {
            return response()->json([
                'message' => 'Data warga belum terverifikasi'
            ], 403);
        }

        $surat = SuratTerbit::with(['pengajuan.template'])
            ->whereHas('pengajuan', function ($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nomor_surat' => $item->nomor_surat,
                    'nama_surat' => $item->pengajuan->template->nama_template,
                    'tanggal' => Carbon::parse($item->created_at)
                        ->timezone('Asia/Jakarta')
                        ->format('d F Y'),
                    'qr_token' => $item->qr_token,
                ];
            });

        return response()->json([
            'data' => $surat
        ]);
    }

    // DETAIL SURAT TERSIMPAN
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $warga = DataWarga::where('nik', $user->nik)->firstOrFail();

        $surat = SuratTerbit::with(['pengajuan.template'])
            ->where('id', $id)
            ->whereHas('pengajuan', function ($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })
            ->firstOrFail();

        return response()->json([
            'data' => [
                'id' => $surat->id,
                'nomor_surat' => $surat->nomor_surat,
                'nama_surat' => $surat->pengajuan->template->nama_template,
                'tanggal' => Carbon::parse($surat->created_at)
                    ->timezone('Asia/Jakarta')
                    ->format('d F Y'),
                'qr_token' => $surat->qr_token,
            ]
        ]);
    }

    // DOWNLOAD SURAT
    public function download(Request $request, $token)
    {
        $user = $request->user();

        $warga = DataWarga::where('nik', $user->nik)->first();

        if (!$warga) {
            return response()->json([
                'message' => 'Data warga tidak valid'
            ], 403);
        }

        $surat = SuratTerbit::with('pengajuan')
            ->where('qr_token', $token)
            ->whereHas('pengajuan', function ($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })
            ->firstOrFail();

        $path = $surat->file_pdf;

        if (!Storage::disk('supabase')->exists($path)) {
            return response()->json([
                'message' => 'File tidak ditemukan'
            ], 404);
        }

        $namaFile = 'Surat-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';

        return response(
            Storage::disk('supabase')->get($path),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$namaFile}\"",
            ]
        );
    }
}
