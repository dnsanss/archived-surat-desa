<!-- halaman sukses setelah mengajukan surat -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Surat Sukses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-md rounded-lg p-8 text-center max-w-md w-full">
        <h1 class="text-2xl font-bold text-green-600 mb-4">Pengajuan Berhasil!</h1>
        <p class="text-gray-700 mb-6">
            Pengajuan surat Anda telah diterima. Silakan datang ke kantor Kepala Desa Karangasem
            untuk mengambil surat dalam bentuk hardfile.
        </p>
        <a href="{{ route('pengajuan-surat') }}"
            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
            Kembali ke Halaman Pengajuan
        </a>
    </div>

</body>

</html>