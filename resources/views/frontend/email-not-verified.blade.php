<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Email Belum Diverifikasi</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded shadow w-full max-w-md text-center">
        <h2 class="text-xl font-bold mb-2">Verifikasi Email</h2>
        <p class="text-gray-600 mb-4">
            Akun Anda belum diverifikasi.
            Silakan cek email Anda dan klik link verifikasi.
        </p>

        <form method="POST" action="{{ route('email.resend') }}">
            @csrf
            <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <a href="{{ route('logout') }}"
            class="block mt-4 text-sm text-red-500">
            Logout
        </a>
    </div>

</body>

</html>