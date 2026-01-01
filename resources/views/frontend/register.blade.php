<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow">

        <h2 class="text-2xl font-bold text-center mb-4">Registrasi</h2>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('register.submit') }}" class="space-y-3">
            @csrf

            <input type="text" name="nama" placeholder="Nama Lengkap"
                class="w-full border rounded px-3 py-2" required>

            <input type="text" name="nik" placeholder="NIK"
                class="w-full border rounded px-3 py-2" required>

            <input type="email" name="email" placeholder="Email"
                class="w-full border rounded px-3 py-2" required>

            <input type="text" name="nomor_hp" placeholder="Nomor HP"
                class="w-full border rounded px-3 py-2" required>

            <input type="password" name="password" placeholder="Password"
                class="w-full border rounded px-3 py-2" required>

            <input type="password" name="password_confirmation"
                placeholder="Konfirmasi Password"
                class="w-full border rounded px-3 py-2" required>

            <button class="w-full bg-green-600 text-white py-2 rounded">
                Daftar
            </button>
        </form>

        <p class="text-center mt-4 text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold">
                Login
            </a>
        </p>
    </div>

</body>

</html>