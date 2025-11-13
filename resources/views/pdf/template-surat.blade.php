<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $nama_template }}</title>
    <style>
        @page {
            size: 210mm 330mm;
            margin: 25mm 20mm 25mm 20mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 30px;
            font-size: 12pt;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 4px double black;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .kop-surat img {
            width: 75px;
            height: auto;
            float: left;

        }

        .kop-teks {
            text-align: center;
            flex: 1;
        }

        .kop-teks h1,
        .kop-teks h2,
        .kop-teks h3 {
            margin: 0;
            line-height: 1.0;
        }

        .kop-teks h1 {
            font-size: 12pt;
            font-weight: bold;
        }

        .kop-teks h2 {
            font-size: 14pt;
            font-weight: bold;
        }

        .kop-teks h3 {
            font-size: 16pt;
            font-weight: bold;
        }

        .alamat {
            font-style: italic;
            font-size: 8.5pt;
            margin-top: 2px;
            text-align: center;
        }

        p {
            line-height: 1.5;
            text-align: justify;
        }

        .container-tanda-tangan {
            margin-top: 10px;
            width: 100%;
        }

        .tanda-tangan {
            display: inline-block;
            text-align: center;
            width: 40%;
            float: right;
            vertical-align: top;
            min-height: 160px;
        }

        .qr-table {
            border-collapse: collapse;
            margin: 0 auto;
        }

        .qr-table td {
            vertical-align: left;
            padding: 0 6px;
        }

        .qr-img {
            width: 100px;
            height: 100px;
            display: block;
            margin: 0 auto;
        }

        .nama-ttd {
            text-decoration: underline;
            font-weight: bold;
            margin-top: 6px;
        }

        /* fallback clear float */
        .clearfix::after {
            content: "";
            display: block;
            clear: both;
        }
    </style>
</head>

<body>

    @php
    $path = public_path('assets/images/logo-kabpas.png');
    $logoBase64 = null;
    if (file_exists($path)) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
    @endphp

    <div class="kop-surat">
        @if ($logoBase64)
        <img src="{{ $logoBase64 }}" alt="Logo Kabupaten Pasuruan">
        @endif
        <div class="kop-teks">
            <h1>PEMERINTAH KABUPATEN PASURUAN</h1>
            <h2>KECAMATAN LUMBANG</h2>
            <h3>DESA KARANGASEM</h3>
            <p class="alamat">Jln. Dusun Krajan, Desa Karangasem, Kecamatan Lumbang, Kab. Pasuruan Kode Pos 67183</p>
        </div>
    </div>

    <!-- ISI SURAT -->
    {!! $isi_template !!}

    <!-- 🔹 TANDA TANGAN -->
    <div class="container-tanda-tangan clearfix">
        <div class="tanda-tangan">
            <div class="tanggal-jabatan" style="text-align: left; margin-bottom: 8px;">
                Karangasem, {{ now()->translatedFormat('d F Y') }}<br>
                <strong>Kepala Desa Karangasem</strong>
            </div>

            <!-- 🔹 QR Code + Deskripsi -->
            <table class="qr-table" style="margin-bottom: 8px;">
                <tr>
                    <td style="width:110px; text-align:left; vertical-align:left;">
                        <img src="{{ $qrCode }}" alt="QR Code" class="qr-img">
                    </td>
                </tr>
            </table>

            <!-- 🔹 Nama Penandatangan -->
            <p class="nama-ttd" style="margin-top: 5px;">Sumali</p>
        </div>
    </div>

</body>

</html>