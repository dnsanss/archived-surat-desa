<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\DataWarga;
use Carbon\Carbon;

class PelacakanSuratController extends Controller
{
    public function index(Request $request)
    {
        // Cek session warga
        if (!session()->has('warga_id')) {
            return redirect()->route('warga.login')->with([
                'status' => 'error',
                'msg' => 'Silakan login terlebih dahulu.'
            ]);
        }

        $warga = DataWarga::find(session('warga_id'));
        if (!$warga) {
            return redirect()->route('warga.login')->with([
                'status' => 'error',
                'msg' => 'Data warga tidak ditemukan.'
            ]);
        }

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

        return view('frontend.pelacakan-surat', [
            'pengajuan' => $pengajuan,
        ]);
    }
}
