<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center mb-4">Login</h2>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="text-sm list-disc pl-4">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label>Email</label>
                <input type="email" name="email"
                    class="w-full border rounded px-3 py-2"
                    required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2"
                    required>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded">
                Login
            </button>
        </form>

        <p class="text-center mt-4 text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold">
                Daftar
            </a>
        </p>
    </div>

</body>

</html>