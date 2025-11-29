@include('layouts.navbar')
<style>
    .success-card {
        background: #f8fffa;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 420px;
        margin: 40px auto;
        text-align: center;
    }

    .check-circle {
        width: 120px;
        height: 120px;
        background: #23a84f;
        border-radius: 50%;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .check-circle i {
        font-size: 60px;
        color: white;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 8px;
        color: white;
        font-size: 13px;
    }

    .status-menunggu {
        background: #d63031;
    }

    .status-selesai {
        background: #23a84f;
    }

    .btn-green {
        width: 100%;
        padding: 12px;
        background: #1f8f45;
        color: white;
        border-radius: 10px;
        display: block;
        text-decoration: none;
        margin-top: 20px;
        font-weight: 600;
    }

    .btn-outline {
        width: 100%;
        padding: 12px;
        border: 2px solid #1f8f45;
        color: #1f8f45;
        border-radius: 10px;
        display: block;
        text-decoration: none;
        margin-top: 12px;
        font-weight: 600;
    }
</style>

<div class="success-card">

    <div class="check-circle">
        <i class="fas fa-check"></i>
    </div>

    <h2 style="margin-top: 15px; font-weight: 800;">BERHASIL</h2>

    <p style="margin-top: -5px;">MELAKUKAN PENGAJUAN SURAT PADA :</p>

    <div style="text-align: left; margin-top: 15px;">
        <p><strong>Tanggal :</strong> {{ $tanggal }}</p>
        <p><strong>Pukul :</strong> {{ $jam }}</p>
        <p><strong>Jenis Surat :</strong> {{ $pengajuan->templateSurat->nama_template }}</p>
        <p><strong>Nama :</strong> {{ $pengajuan->nama }}</p>
        <p><strong>NIK :</strong> {{ $pengajuan->nik }}</p>
        <p><strong>Status :</strong>
            @if($pengajuan->status == 'menunggu')
            <span class="status-badge status-menunggu">Belum diproses</span>
            @else
            <span class="status-badge status-selesai">Selesai</span>
            @endif
        </p>
    </div>

    <hr style="margin: 20px 0;">

    <p style="font-size: 13px; text-align: left;">
        <strong>Note*</strong>: Surat akan diproses pada saat jam kerja.
        Jika pengajuan dilakukan pada hari Sabtu, Minggu, atau hari libur nasional,
        maka pengajuan akan diproses pada saat jam kerja kembali normal.
    </p>

    <a href="{{ route('pelacakan.surat') }}" class="btn-green">Lacak Pengajuan Surat</a>

    <a href="{{ route('pengajuan-surat') }}" class="btn-outline">Kembali ke Beranda</a>

</div>

@include('layouts.footer')