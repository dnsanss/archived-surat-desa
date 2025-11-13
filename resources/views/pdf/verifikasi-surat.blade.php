<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Surat | Desa Karangasem</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f6fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            background: #ffffff;
            text-align: center;
            padding: 30px 15px 10px;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .header h1 {
            font-size: 28px;
            margin: 10px 0 0;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 13px;
            margin-top: 4px;
            color: #555;
        }

        .content {
            max-width: 550px;
            background: #fff;
            margin: 25px auto;
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .hash {
            font-size: 14px;
            color: #d32f2f;
            word-wrap: break-word;
            margin: 8px 0 15px;
            text-align: center;
        }

        .info p {
            font-size: 15px;
            line-height: 1.6;
            margin: 6px 0;
        }

        .info strong {
            color: #222;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #777;
        }

        .btn-download {
            display: inline-block;
            background: #e53935;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s;
        }

        .btn-download:hover {
            background: #c62828;
        }

        @media (max-width: 600px) {
            .content {
                width: 90%;
                padding: 20px;
            }

            .header img {
                width: 80px;
            }
        }
    </style>
</head>

<body>

    <!-- 🔹 ISI VERIFIKASI -->
    <div class="content">
        <div class="header">
            @php
            $path = public_path('assets/images/logo-kabpas.png');
            $logoBase64 = null;
            if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            @endphp
            @if ($logoBase64)
            <img src="{{ $logoBase64 }}" alt="Logo Kabupaten Pasuruan">
            @endif

            <h1>DESA KARANGASEM</h1>
            <p>Sistem Informasi Kearsipan Digital Terintegrasi</p>
        </div>

        <hr>

        @if($valid)
        <h2>✅ Surat Ini Terverifikasi</h2>

        <p class="hash">Kode Verifikasi: <strong>{{ $surat->qr_token }}</strong></p>

        <div class="info">
            <p>Nomor Surat: <Strong>{{ $surat->nomor_surat }}</Strong></p>
            <p>Nama Surat: <Strong>{{ $template->nama_template ?? '-' }}</Strong></p>
            <p>Pengaju Surat: <Strong>{{ $warga->nama ?? '-' }}</Strong></p>
            <p>Nama Penandatangan: <Strong>Sumali</Strong></p>
            <p>Jabatan: <Strong>Kepala Desa</Strong></p>
            <p>Instansi: <Strong>Pemerintah Desa Karangasem</Strong></p>
            <p>Tanggal Ditandatangani:<Strong>
                    {{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->translatedFormat('l, d F Y') }}
                </Strong></p>
        </div>

        <hr>

        <div style="text-align:center;">
            <a href="{{ route('verifikasi.download', $surat->qr_token) }}" class="btn-download">DOWNLOAD FILE DIGITAL</a>
        </div>

        @else
        <h2>❌ Surat Tidak Valid</h2>
        <p style="text-align:center; color:#b71c1c;">
            {{ $message }}
        </p>
        @endif

        <div class="footer">
            © {{ date('Y') }} Pemerintah Desa Karangasem — Sistem Arsip Digital
        </div>
    </div>

</body>

</html>