<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataWarga;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $templates = TemplateSurat::all();
        return view('frontend.pengajuan-surat', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|digits:16',
            'nama' => 'required|string|max:255',
            'template_id' => 'required|exists:templates_surat,id',
            'catatan' => 'nullable|string',
        ]);

        // ✅ Validasi warga menggunakan model DataWarga
        $warga = DataWarga::where('nik', $validated['nik'])
            ->where('nama', 'LIKE', '%' . $validated['nama'] . '%')
            ->first();

        if (!$warga) {
            return back()->withErrors([
                'nik' => 'Data warga tidak ditemukan. Pastikan NIK dan Nama sesuai dengan data kependudukan Desa Karangasem.',
            ])->withInput();
        }

        // ✅ Simpan pengajuan surat ke database
        $template = TemplateSurat::find($validated['template_id']);
        PengajuanSurat::create([
            'nik' => $validated['nik'],
            'nama' => $validated['nama'],
            'template_id' => $validated['template_id'],
            'nomor_surat' => $template?->nomor_surat ?? '-', // ← otomatis isi dari template
            'status' => 'menunggu',
        ]);

        return redirect()->route('pengajuan-surat.sukses');
    }

    public function sukses()
    {
        return view('frontend.pengajuan-surat-sukses');
    }
}
