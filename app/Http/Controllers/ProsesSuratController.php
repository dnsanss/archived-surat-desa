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

        // Format data warga untuk tampilan di isi surat
        $warga->tanggal_lahir = Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y');
        $warga->jenis_kelamin = $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';

        // Ambil isi surat final yang sudah disimpan / diedit admin
        $isiSuratFinal = $pengajuan->isi_surat;

        // Jika kosong (fallback), generate dari template
        if (empty($isiSuratFinal)) {
            $isiSuratFinal = SuratHelper::replaceVariables(
                $template->isi_template,
                $warga
            );
        }

        // Ganti placeholder spesifik (nomor_surat, kepada, nama_template)
        $isiSuratFinal = str_replace(
            [
                '{{nomor_surat}}',
                '{{kepada}}',
                '{{nama_template}}',
            ],
            [
                $pengajuan->nomor_surat ?? '-',
                $pengajuan->kepada ?? '-',
                $template->nama_template ?? '-',
            ],
            $isiSuratFinal
        );

        // Simpan kembali isi_surat final ke pengajuan (agar persistent)
        $pengajuan->isi_surat = $isiSuratFinal;
        $pengajuan->save();

        // Pastikan public storage symlink ada
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        // Generate token verifikasi
        $qrToken = Str::uuid();
        $urlVerifikasi = route('verifikasi.surat', ['token' => $qrToken]);

        // Generate QR Code (PNG)
        $qrCode = new QrCode($urlVerifikasi);
        $qrCode->setSize(150);
        $writer = new PngWriter();

        // Simpan file QR ke storage/app/public/qrcodes
        $qrFileName = 'qr_' . $pengajuan->id . '_' . time() . '.png';
        $qrPath = 'qrcodes/' . $qrFileName;
        Storage::disk('local')->put($qrPath, $writer->write($qrCode)->getString());

        // Base64 untuk dimasukkan ke PDF
        $qrBase64 = 'data:image/png;base64,' . base64_encode(Storage::disk('local')->get($qrPath));

        // Generate PDF menggunakan isi surat final
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

        // Simpan PDF ke storage/app/public/surat-keluar
        $fileName = 'surat_' . $warga->nik . '_' . now()->format('YmdHis') . '.pdf';
        $filePath = 'surat-keluar/' . $fileName;
        Storage::disk('local')->put($filePath, $pdf->output());

        // Simpan metadata surat ke DB (path publikable via /storage/...)
        SuratTerbit::create([
            'pengajuan_id'      => $pengajuan->id,
            'nomor_surat'       => $pengajuan->nomor_surat,
            'nama_ttd'          => $template->nama_ttd,
            'kepada'            => $pengajuan->kepada,
            'file_pdf'          => 'storage/' . $filePath,
            'tanggal_pengajuan' => now()->setTimezone('Asia/Jakarta'),
            'qrcode_path'       => 'storage/' . $qrFileName,
            'qr_token'          => $qrToken,
        ]);

        // Update status pengajuan
        $pengajuan->update(['status' => 'selesai']);

        // Redirect ke Filament
        return redirect()->route('filament.karangasem.resources.surat-keluars.index')
            ->with('success', '✅ Surat berhasil diterbitkan dan disimpan ke arsip.');
    }
}
