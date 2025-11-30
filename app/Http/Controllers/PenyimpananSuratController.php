<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\SuratTerbit;
use App\Models\DataWarga;
use Carbon\Carbon;

class PenyimpananSuratController extends Controller
{
    public function index()
    {
        // cek session warga seperti pelacakan
        if (!session()->has('warga_id')) {
            return redirect()->route('warga.login')->with([
                'status' => 'error',
                'msg' => 'Silakan login terlebih dahulu.'
            ]);
        }

        $wargaId = session('warga_id');

        $suratTersimpan = SuratTerbit::with(['pengajuan.template'])
            ->whereHas('pengajuan', function ($q) use ($wargaId) {
                $q->where('warga_id', $wargaId);
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
        if (!session()->has('warga_id')) {
            return redirect()->route('warga.login')->with([
                'status' => 'error',
                'msg' => 'Silakan login terlebih dahulu.'
            ]);
        }

        $wargaId = session('warga_id');

        $surat = SuratTerbit::with(['pengajuan.template'])
            ->where('id', $id)
            ->whereHas('pengajuan', function ($q) use ($wargaId) {
                $q->where('warga_id', $wargaId);
            })
            ->firstOrFail();

        return view('frontend.detail-penyimpanan', compact('surat'));
    }
}
