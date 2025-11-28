<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataWarga;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;

class WargaPengajuanController extends Controller
{
    /**
     * Form Pengajuan Surat
     */
    public function form()
    {
        // Ambil data warga dari session
        $warga = DataWarga::find(session('warga_id'));

        // Ambil list template
        $templates = TemplateSurat::all();

        return view('frontend.form-pengajuan-surat', compact('warga', 'templates'));
    }

    /**
     * Simpan Pengajuan Surat
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_wa' => 'required|string|max:15',
            'template_id' => 'required|exists:templates_surat,id',
        ]);

        $warga = DataWarga::find(session('warga_id'));
        $template = TemplateSurat::find($request->template_id);

        PengajuanSurat::create([
            'warga_id'      => $warga->id,
            'nik'            => $warga->nik,
            'nama'           => $warga->nama,
            'template_id'    => $template->id,
            'nomor_wa'      => $request->nomor_wa,
            'nomor_surat'    => $template->nomor_surat,
            'kepada'         => null, // admin isi nanti
            'isi_surat'      => null, // akan digenerate pertama kali saat admin buka
            'status'         => 'menunggu',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('pengajuan-surat')
            ->with('success', 'Pengajuan surat berhasil dikirim.');
    }
}
