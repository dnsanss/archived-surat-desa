<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use App\Helpers\SuratHelper;
use Illuminate\Http\Request;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;

class WargaPengajuanController extends Controller
{
    // Tampilkan form pengajuan surat
    public function form()
    {
        // Ambil data warga dari session
        $warga = DataWarga::find(session('warga_id'));

        // Ambil list template
        $templates = TemplateSurat::all();

        return view('frontend.form-pengajuan-surat', compact('warga', 'templates'));
    }

    // Proses penyimpanan pengajuan surat
    public function store(Request $request)
    {
        $request->validate([
            'nomor_wa' => 'required|string|max:15',
            'template_id' => 'required|exists:templates_surat,id',
        ]);

        $warga = DataWarga::find(session('warga_id'));
        $template = TemplateSurat::find($request->template_id);
        $isiSurat = SuratHelper::replaceVariables(
            $template->isi_template,
            $warga
        );

        $pengajuan = PengajuanSurat::create([
            'warga_id'      => $warga->id,
            'nik'            => $warga->nik,
            'nama'           => $warga->nama,
            'template_id'    => $template->id,
            'nomor_wa'      => $request->nomor_wa,
            'nomor_surat'    => $template->nomor_surat,
            'isi_surat'      => $isiSurat,
            'kepada'         => null,
            'status'         => 'menunggu',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('pengajuan-surat-sukses', $pengajuan->id);
    }

    public function sukses($id)
    {
        // Ambil satu data pengajuan berdasarkan ID
        $pengajuan = PengajuanSurat::with('template')->findOrFail($id);

        // Format tanggal & waktu (mengikuti zona waktu Jakarta)
        $tanggal = $pengajuan->tanggal_pengajuan
            ? $pengajuan->tanggal_pengajuan->timezone('Asia/Jakarta')->format('d F Y')
            : now()->timezone('Asia/Jakarta')->format('d F Y');

        $jam = $pengajuan->created_at
            ? $pengajuan->created_at->timezone('Asia/Jakarta')->format('H:i')
            : now()->timezone('Asia/Jakarta')->format('H:i');

        return view('frontend.pengajuan-surat-sukses', compact('pengajuan', 'tanggal', 'jam'));
    }

    public function pelacakan()
    {
        return view('frontend.pelacakan-surat');
    }
}
