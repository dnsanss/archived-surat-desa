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
        $pengguna = session('data_pengguna');

        $warga = DataWarga::where('nik', $pengguna->nik)->first();
        $templates = TemplateSurat::all();

        return view('frontend.form-pengajuan-surat', compact('warga', 'templates'));
    }

    // Proses penyimpanan pengajuan surat
    public function store(Request $request)
    {
        $pengguna = session('data_pengguna');
        if (!$pengguna) {
            return redirect()->route('login');
        }

        // Ambil warga via NIK pengguna
        $warga = DataWarga::where('nik', $pengguna->nik)->first();
        if (!$warga) {
            return back()->with('error', 'Data warga tidak ditemukan.');
        }

        // Ambil template
        $template = TemplateSurat::findOrFail($request->template_id);

        // Generate isi surat
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
            'kepada'            => null,
            'tanggal_pengajuan' => now(),
            'status'            => 'menunggu',
        ]);

        return redirect()
            ->route('pengajuan-surat-sukses', $pengajuan->id)
            ->with('success', 'Pengajuan surat berhasil dikirim.');
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
