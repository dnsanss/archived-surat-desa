<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataWarga;
use App\Models\SuratTerbit;
use Illuminate\Support\Facades\Storage;

class PenyimpananSuratController extends Controller
{
    public function index()
    {
        // 1. Cek login pengguna
        if (!session()->has('data_pengguna')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $pengguna = session('data_pengguna');

        // 2. Ambil data warga berdasarkan NIK pengguna
        $warga = DataWarga::where('nik', $pengguna->nik)->first();

        if (!$warga) {
            return redirect()->route('pengajuan-surat')
                ->with('error', 'Data warga belum terverifikasi.');
        }

        // 3. Ambil surat terbit milik warga tersebut
        $suratTersimpan = SuratTerbit::with(['pengajuan.template'])
            ->whereHas('pengajuan', function ($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tanggal_jakarta = Carbon::parse($item->created_at)
                    ->timezone('Asia/Jakarta')
                    ->format('d F Y');
                return $item;
            });

        return view('frontend.penyimpanan-surat', compact('suratTersimpan'));
    }

    public function show($id)
    {
        if (!session()->has('data_pengguna')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $pengguna = session('data_pengguna');

        $warga = DataWarga::where('nik', $pengguna->nik)->first();
        if (!$warga) {
            return redirect()->route('pengajuan-surat')
                ->with('error', 'Data warga tidak ditemukan.');
        }

        $surat = SuratTerbit::with(['pengajuan.template'])
            ->where('id', $id)
            ->whereHas('pengajuan', function ($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })
            ->firstOrFail();

        return view('frontend.detail-penyimpanan', compact('surat'));
    }

    public function download($token)
    {
        if (!session()->has('data_pengguna')) {
            abort(403);
        }

        $pengguna = session('data_pengguna');

        $warga = DataWarga::where('nik', $pengguna->nik)->first();
        if (!$warga) {
            abort(403);
        }

        $surat = SuratTerbit::with('pengajuan')
            ->where('qr_token', $token)
            ->whereHas('pengajuan', function ($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })
            ->firstOrFail();

        $relativePath = str_replace('storage/', '', $surat->file_pdf);
        $fullPath = storage_path('app/' . $relativePath);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $namaFile = 'Surat-' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';

        return response()->download($fullPath, $namaFile);
    }
}
