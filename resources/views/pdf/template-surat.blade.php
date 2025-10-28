<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $nama_template }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 18px;
            margin-top: 15px;
            font-size: 11pt;
            size: A4;
        }

        p {
            line-height: 1.6;
            text-align: justify;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 0;
        }

        .kop-surat h2 {
            margin-bottom: 0;
        }

        .container-tanda-tangan {
            margin-top: 25px;
            width: 100%;
            text-align: right;
            /* ⬅️ Gantikan flex dengan ini */
        }

        .tanda-tangan {
            display: inline-block;
            /* agar lebar mengikuti konten */
            text-align: center;
            width: 30%;
            margin-right: 10px;
            /* sedikit jarak dari tepi kanan */
        }

        .qr-space {
            height: 40px;
        }

        .nama-ttd {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <h2>PEMERINTAH DESA KARANGASEM</h2>
        <h5>Jln. Dusun Krajan, Desa Karangasem, Kecamatan Lumbang</h5>
        <hr>
    </div>

    {!! $isi_template !!}
    <div class="container-tanda-tangan">
        <div class="tanda-tangan">
            <p>Karangasem, {{ now()->translatedFormat('d F Y') }}</p>
            <p><strong>Kepala Desa Karangasem</strong></p>

            <!-- ✅ Ruang kosong untuk QR Code -->
            <div class="qr-space"></div>

            <p class="nama-ttd">Sutomo</p>
        </div>
    </div>
</body>

</html>