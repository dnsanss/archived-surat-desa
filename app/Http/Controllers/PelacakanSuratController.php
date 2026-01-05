<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use App\Models\DataWarga;
use Carbon\Carbon;

class PelacakanSuratController extends Controller
{
    public function index()
    {
        // 1. Pastikan user login
        if (!session('pengguna_login')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil data pengguna dari session
        $pengguna = session('data_pengguna');

        if (!$pengguna) {
            session()->flush();
            return redirect()->route('login');
        }

        // 3. Ambil data warga berdasarkan NIK
        $warga = DataWarga::where('nik', $pengguna->nik)->first();

        if (!$warga) {
            return redirect()->route('pengajuan-surat')
                ->with('error', 'Data warga tidak ditemukan.');
        }

        // 4. Ambil pengajuan surat milik warga
        $pengajuan = PengajuanSurat::with('template')
            ->where('warga_id', $warga->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tanggal_jakarta = Carbon::parse($item->created_at)
                    ->timezone('Asia/Jakarta')
                    ->format('d F Y');
                return $item;
            });

        return view('frontend.pelacakan-surat', compact('pengajuan'));
    }

    public function show($id)
    {
        if (!session('pengguna_login')) {
            return redirect()->route('login');
        }

        $pengguna = session('data_pengguna');

        if (!$pengguna) {
            session()->flush();
            return redirect()->route('login');
        }

        $warga = DataWarga::where('nik', $pengguna->nik)->first();

        if (!$warga) {
            abort(403, 'Akses tidak sah');
        }

        $surat = PengajuanSurat::with('template')
            ->where('id', $id)
            ->where('warga_id', $warga->id)
            ->firstOrFail();

        return view('frontend.detail-pelacakan', compact('surat'));
    }
}
