<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use App\Models\DataWarga;
use App\Models\TemplateSurat;
use App\Models\SuratTerbit;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ProsesSuratController extends Controller
{
    public function generate($id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $template = TemplateSurat::findOrFail($pengajuan->template_id);
        $warga = DataWarga::where('nik', $pengajuan->nik)->first();

        if (!$warga) {
            abort(404, 'Data warga tidak ditemukan.');
        }

        // Ganti placeholder di template dengan data sebenarnya
        $isi_surat = $template->isi_template;
        $isi_surat = str_replace(
            ['{{nama}}', '{{nik}}', '{{alamat}}', '{{tempat_lahir}}', '{{tanggal_lahir}}', '{{jenis_kelamin}}'],
            [$warga->nama, $warga->nik, $warga->alamat, $warga->tempat_lahir, $warga->tanggal_lahir, $warga->jenis_kelamin],
            $isi_surat
        );

        $pdf = Pdf::loadView('pdf.template-surat', [
            'nama_template' => $template->nama_template,
            'isi_surat' => $isi_surat,
        ]);

        $fileName = 'surat_' . $warga->nik . '_' . now()->format('YmdHis') . '.pdf';
        $filePath = 'surat-pdf/' . $fileName;

        Storage::disk('local')->put($filePath, $pdf->output());

        // Simpan ke tabel surat_terbit
        SuratTerbit::create([
            'pengajuan_id' => $pengajuan->id,
            'nomor_surat' => 'SK-' . strtoupper(uniqid()),
            'file_pdf' => $filePath,
            'tanggal_terbit' => now(),
        ]);

        // Ubah status pengajuan menjadi selesai
        $pengajuan->update(['status' => 'selesai']);

        return response()->download(storage_path('app/' . $filePath));
    }
}
