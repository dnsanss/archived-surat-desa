<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataWarga;
use Endroid\QrCode\QrCode;
use App\Models\SuratTerbit;
use Illuminate\Support\Str;
use App\Helpers\SuratHelper;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ProsesSuratController extends Controller
{
    public function edit($id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $template  = TemplateSurat::findOrFail($pengajuan->template_id);
        $warga     = DataWarga::where('nik', $pengajuan->nik)->firstOrFail();

        // Jika isi_surat masih kosong → isi otomatis pertama kali
        if (empty($pengajuan->isi_surat)) {
            $pengajuan->isi_surat = SuratHelper::replaceVariables(
                $template->isi_template,
                $warga
            );
            $pengajuan->save();
        }

        return view('surat.proses', compact('pengajuan', 'warga'));
    }

    public function generate($id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $template  = TemplateSurat::findOrFail($pengajuan->template_id);
        $warga     = DataWarga::where('nik', $pengajuan->nik)->firstOrFail();

        // Format data warga
        $warga->tanggal_lahir = Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y');
        $warga->jenis_kelamin = $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';

        // Ambil isi surat final
        $isiSuratFinal = $pengajuan->isi_surat;

        if (empty($isiSuratFinal)) {
            $isiSuratFinal = SuratHelper::replaceVariables(
                $template->isi_template,
                $warga
            );
        }

        $isiSuratFinal = str_replace(
            ['{{nomor_surat}}', '{{kepada}}', '{{nama_template}}'],
            [
                $pengajuan->nomor_surat ?? '-',
                $pengajuan->kepada ?? '-',
                $template->nama_template ?? '-',
            ],
            $isiSuratFinal
        );

        $pengajuan->update(['isi_surat' => $isiSuratFinal]);

        // Generate token QR
        $qrToken = Str::uuid();
        $urlVerifikasi = route('verifikasi.surat', ['token' => $qrToken]);

        // Generate QR Code
        $qrCode = new QrCode($urlVerifikasi);
        $qrCode->setSize(150);
        $writer = new PngWriter();

        // PATH QR
        $qrFileName = 'qr_' . $pengajuan->id . '_' . time() . '.png';
        $qrPath = 'qrcodes/' . $qrFileName;

        Storage::disk('supabase')->put(
            'qrcodes/' . $qrFileName,
            $writer->write($qrCode)->getString(),
            'public'
        );


        // Base64 QR untuk PDF
        $qrBase64 = 'data:image/png;base64,' . base64_encode(
            Storage::disk('supabase')->get($qrPath)
        );

        // Generate PDF
        $pdf = Pdf::loadView('pdf.template-surat', [
            'nama_template' => $template->nama_template,
            'isi_template'  => $isiSuratFinal,
            'qrCode'        => $qrBase64,
            'nama_ttd'      => $template->nama_ttd,
        ])->setPaper([0, 0, 595.28, 935.43], 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        // PATH PDF
        $fileName = 'surat_' . $warga->nik . '_' . now()->format('YmdHis') . '.pdf';
        $filePath = 'surat-keluar/' . $fileName;

        Storage::disk('supabase')->put(
            $filePath,
            $pdf->output(),
            'public'
        );

        // Simpan metadata ke DB (TANPA awalan storage/)
        SuratTerbit::create([
            'pengajuan_id'      => $pengajuan->id,
            'warga_id'          => $pengajuan->warga_id,
            'nomor_surat'       => $pengajuan->nomor_surat,
            'kepada'            => $pengajuan->kepada,
            'diproses_oleh'     => $pengajuan->diproses_oleh,
            'file_pdf'          => $filePath,      // ✅
            'tanggal_pengajuan' => now()->setTimezone('Asia/Jakarta'),
            'qrcode_path'       => $qrPath,        // ✅
            'qr_token'          => $qrToken,
        ]);

        // Update status
        $pengajuan->update(['status' => 'selesai']);

        return redirect()
            ->route('filament.karangasem.resources.surat-keluars.index')
            ->with('success', '✅ Surat berhasil diterbitkan.');
    }
}
