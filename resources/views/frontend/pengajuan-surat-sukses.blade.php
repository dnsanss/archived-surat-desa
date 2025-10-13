<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengajuan Surat Sukses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-50">

    <div class="max-w-md mx-auto mt-20 bg-white shadow-md rounded-lg p-8 text-center">
        <h1 class="text-2xl font-bold text-green-700 mb-4">Pengajuan Berhasil!</h1>
        <p class="text-gray-700">
            Pengajuan surat Anda telah diterima. Silakan datang ke kantor Kepala Desa Karangasem
            untuk mengambil surat dalam bentuk hardfile.
        </p>

        <a href="{{ route('pengajuan-surat') }}"
            class="inline-block mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kembali ke Halaman Pengajuan
        </a>
    </div>

</body>

</html>