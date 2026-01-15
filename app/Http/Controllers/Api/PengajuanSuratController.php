<?php

namespace App\Http\Controllers\Api;

use App\Models\DataWarga;
use App\Helpers\SuratHelper;
use App\Models\DataPengguna;
use Illuminate\Http\Request;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class PengajuanSuratController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:templates_surat,id',
            'nik' => 'required',
            'nama' => 'required',
            'nomor_wa' => 'required',
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

    private function mapStatus(string $status): string
    {
        return match ($status) {
            'status_raw'   => $status,          // menunggu | selesai
            'status_label' => $this->mapStatus(...),  // Belum diproses
            default => ucfirst($status),
        };
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
                    'tanggal_pengajuan' => $item->tanggal_jakarta = Carbon::parse($item->created_at)
                        ->timezone('Asia/Jakarta')
                        ->format('d F Y'),
                    'pukul' => $item->created_at->format('H:i'),
                    'diproses_oleh' => $item->diproses_oleh ?? '-',
                    'status' => $this->mapStatus($item->status),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $pengajuan
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Ambil pengguna
        $pengguna = DataPengguna::findOrFail($user->id);

        // Ambil warga via NIK
        $warga = DataWarga::where('nik', $pengguna->nik)->first();

        if (!$warga) {
            return response()->json([
                'message' => 'Data warga tidak ditemukan'
            ], 404);
        }

        // Ambil pengajuan + validasi kepemilikan
        $pengajuan = PengajuanSurat::with('template')
            ->where('id', $id)
            ->where('warga_id', $warga->id)
            ->first();

        if (!$pengajuan) {
            return response()->json([
                'message' => 'Pengajuan surat tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pengajuan->id,
                'nama' => $pengajuan->nama,
                'nik' => $pengajuan->nik,
                'jenis_surat' => $pengajuan->template->nama_template ?? '-',
                'nomor_surat' => $pengajuan->nomor_surat,
                'isi_surat' => $pengajuan->isi_surat,
                'tanggal_pengajuan' => $pengajuan->tanggal_jakarta = Carbon::parse($pengajuan->created_at)
                    ->timezone('Asia/Jakarta')
                    ->format('d F Y'),
                'jam' => $pengajuan->created_at->format('H:i'),
                'status' => $this->mapStatus($pengajuan->status),
            ]
        ]);
    }
}
