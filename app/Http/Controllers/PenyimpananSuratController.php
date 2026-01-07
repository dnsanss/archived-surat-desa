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
        if (!session()->has('data_pengguna')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $pengguna = session('data_pengguna');

        $warga = DataWarga::where('nik', $pengguna->nik)->first();
        if (!$warga) {
            return redirect()->route('pengajuan-surat')
                ->with('error', 'Data warga belum terverifikasi.');
        }

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
        // Pastikan login
        if (!session()->has('data_pengguna')) {
            abort(403, 'Akses ditolak.');
        }

        $pengguna = session('data_pengguna');

        $warga = DataWarga::where('nik', $pengguna->nik)->first();
        if (!$warga) {
            abort(403, 'Data warga tidak valid.');
        }

        // Ambil surat berdasarkan token & kepemilikan
        $surat = SuratTerbit::with('pengajuan')
            ->where('qr_token', $token)
            ->whereHas('pengajuan', function ($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })
            ->firstOrFail();

        // Path RELATIF di Supabase
        $path = $surat->file_pdf;

        if (!Storage::disk('supabase')->exists($path)) {
            abort(404, 'File PDF tidak ditemukan di storage.');
        }

        // Nama file aman
        $namaFile = 'Surat-' . str_replace(['/', '\\'], '-', $surat->nomor_surat) . '.pdf';

        // DOWNLOAD DARI SUPABASE
        return response(Storage::disk('supabase')->get($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$namaFile}\"",
        ]);
    }
}
