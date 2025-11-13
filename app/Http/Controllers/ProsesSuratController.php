<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataWarga;
use App\Models\SuratTerbit;
use Illuminate\Support\Str;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class ProsesSuratController extends Controller
{
    public function generate($id)
    {
        // 🔹 Ambil data pengajuan dan relasi template
        $pengajuan = PengajuanSurat::findOrFail($id);
        $template = TemplateSurat::findOrFail($pengajuan->template_id);
        $warga = DataWarga::where('nik', $pengajuan->nik)->firstOrFail();

        // 🔹 Format tanggal & jenis kelamin
        $warga->tanggal_lahir = Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y');
        $warga->jenis_kelamin = $warga->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';

        // 🔹 Ganti placeholder di template
        $isi_template = str_replace(
            [
                '{{nama}}',
                '{{nik}}',
                '{{alamat}}',
                '{{tempat_lahir}}',
                '{{tanggal_lahir}}',
                '{{jenis_kelamin}}',
                '{{kewarganegaraan}}',
                '{{agama}}',
                '{{status_perkawinan}}',
                '{{pekerjaan}}',
                '{{kelurahan}}',
                '{{kecamatan}}',
                '{{nama_template}}',
                '{{nomor_surat}}',
                '{{kepada}}'
            ],
            [
                $warga->nama,
                $warga->nik,
                $warga->alamat,
                $warga->tempat_lahir,
                $warga->tanggal_lahir,
                $warga->jenis_kelamin,
                $warga->kewarganegaraan,
                $warga->agama,
                $warga->status_perkawinan,
                $warga->pekerjaan,
                $warga->kelurahan,
                $warga->kecamatan,
                $template->nama_template,
                $pengajuan->nomor_surat,
                $pengajuan->kepada
            ],
            $template->isi_template
        );

        // 🔹 Generate token verifikasi unik
        $qrToken = Str::uuid();
        $urlVerifikasi = route('verifikasi.surat', ['token' => $qrToken]);

        // 🔹 Generate QR Code (PNG base64)
        $qrCode = new QrCode($urlVerifikasi);
        $qrCode->setSize(130);
        $writer = new PngWriter();

        // Simpan file QR ke storage
        $qrFileName = 'qr_' . $pengajuan->id . '_' . time() . '.png';
        $qrDir = storage_path('app/qrcodes');

        // Pastikan folder qrcodes ada
        if (!file_exists($qrDir)) {
            mkdir($qrDir, 0777, true);
        }

        $qrPath = $qrDir . '/' . $qrFileName;
        $writer->write($qrCode)->saveToFile($qrPath);

        // Konversi ke base64 agar bisa langsung ditampilkan di PDF
        $qrBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($qrPath));

        // 🔹 Buat symbolic link jika belum ada
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        // 🔹 Generate PDF
        $pdf = Pdf::loadView('pdf.template-surat', [
            'nama_template' => $template->nama_template,
            'isi_template' => $isi_template,
            'qrCode' => $qrBase64,
        ])->setPaper([0, 0, 595.28, 935.43], 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        // 🔹 Simpan file PDF ke storage
        $fileName = 'surat_' . $warga->nik . '_' . now()->format('YmdHis') . '.pdf';
        $filePath = 'surat-keluar/' . $fileName;
        Storage::disk('local')->put($filePath, $pdf->output());

        // 🔹 Simpan metadata surat ke database
        SuratTerbit::create([
            'pengajuan_id' => $pengajuan->id,
            'nomor_surat' => $pengajuan->nomor_surat,
            'kepada' => $pengajuan->kepada,
            'file_pdf' => 'storage/' . $filePath,
            'tanggal_pengajuan' => now()->setTimezone('Asia/Jakarta'),
            'qrcode_path' => 'qrcodes/' . $qrFileName,
            'qr_token' => $qrToken,
        ]);

        // 🔹 Update status pengajuan surat
        $pengajuan->update(['status' => 'selesai']);

        // 🔹 Redirect kembali ke halaman surat keluar
        return redirect()->route('filament.karangasem.resources.surat-keluars.index')
            ->with('success', '✅ Surat berhasil diterbitkan dan disimpan ke arsip.');
    }
}
