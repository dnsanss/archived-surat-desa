<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataWarga;
use App\Models\SuratTerbit;
use App\Models\TemplateSurat;
use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;


class ProsesSuratController extends Controller
{
    public function generate($id)
    {
        // Ambil data pengajuan dan relasi template
        $pengajuan = PengajuanSurat::findOrFail($id);
        $template = TemplateSurat::findOrFail($pengajuan->template_id);
        $warga = DataWarga::where('nik', $pengajuan->nik)->first();

        if (!$warga) {
            abort(404, 'Data warga tidak ditemukan.');
        }

        // Format tanggal & jenis kelamin
        $warga->tanggal_lahir = Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y');
        $warga->jenis_kelamin = $warga->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';

        // Gantikan semua placeholder dalam template
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
            ],
            $template->isi_template
        );

        // Generate PDF dari view template
        $pdf = Pdf::loadView('pdf.template-surat', [
            'nama_template' => $template->nama_template,
            'isi_template' => $isi_template,
        ]);

        // Simpan file ke storage
        $fileName = 'surat_' . $warga->nik . '_' . now()->format('YmdHis') . '.pdf';
        $filePath = 'surat-keluar/' . $fileName;
        Storage::disk('local')->put($filePath, $pdf->output());

        // Buat symbolic link ke public kalau belum ada
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        // Simpan ke tabel surat_terbit
        SuratTerbit::create([
            'pengajuan_id' => $pengajuan->id,
            'nomor_surat' => $pengajuan->nomor_surat,
            'kepada' => $pengajuan->kepada,
            'file_pdf' => $filePath,
            'tanggal_pengajuan' => now()->setTimezone('Asia/Jakarta'),
        ]);

        // Update status pengajuan
        $pengajuan->update(['status' => 'selesai']);

        // Redirect ke halaman surat keluar di Filament (bukan download langsung)
        return redirect()->route('filament.karangasem.resources.surat-keluars.index')
            ->with('success', 'Surat berhasil diterbitkan dan disimpan ke arsip.');
    }
}
