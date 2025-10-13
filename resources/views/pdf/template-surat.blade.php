<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $nama_template }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 40px;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 0;
        }

        p {
            line-height: 1.6;
            text-align: justify;
        }
    </style>
</head>

<body>
    <div style="text-align:center; margin-bottom:30px;">
        <h2>PEMERINTAH DESA KARANGASEM</h2>
        <h3>{{ strtoupper($nama_template) }}</h3>
        <hr>
    </div>

    {!! $isi_template !!}

    <div style="margin-top:50px; text-align:right;">
        <p>Karangasem, {{ now()->translatedFormat('d F Y') }}</p>
        <p><strong>Kepala Desa Karangasem</strong></p>
        <br><br><br>
        <p><u>Sumali</u></p>
    </div>
</body>

</html>