<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataWarga;
use App\Models\SuratTerbit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function download($id)
    {
        $surat = SuratTerbit::findOrFail($id);

        // Bersihkan path yang tidak perlu
        // karena file_pdf = "storage/surat-keluar/nama.pdf"
        $relativePath = str_replace('storage/', '', $surat->file_pdf);

        // Sekarang path = "surat-keluar/nama.pdf"
        $fullPath = storage_path('app/' . $relativePath);

        if (!file_exists($fullPath)) {
            abort(404, 'File PDF tidak ditemukan di storage lokal');
        }

        return response()->download($fullPath);
    }
}
