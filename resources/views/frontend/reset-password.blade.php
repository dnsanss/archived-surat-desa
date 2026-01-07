@include('layouts.navbar')

<div class="min-h-screen bg-green-50 flex items-center justify-center px-4 pt-24 pb-10">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">

        <h2 class="text-2xl font-bold text-center text-green-700 mb-2">
            {{ isset($token) ? 'Reset Password' : 'Lupa Password' }}
        </h2>

        <p class="text-center text-gray-600 mb-6 text-sm">
            {{ isset($token)
                ? 'Masukkan password baru Anda'
                : 'Masukkan email untuk menerima link reset password'
            }}
        </p>

        {{-- ALERT --}}
        @if (session('status'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-4 text-sm">
            {{ session('status') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg mb-4 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- MODE RESET PASSWORD --}}
        @if(isset($token))

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            {{-- PASSWORD BARU --}}
            <div class="relative">
                <input
                    type="password"
                    id="new_password"
                    name="password"
                    placeholder="Password Baru"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12
               focus:outline-none focus:ring-2 focus:ring-green-600"
                    required>

                <span
                    onclick="togglePassword('new_password', this)"
                    class="material-icons absolute right-4 top-1/2 -translate-y-1/2
               cursor-pointer text-gray-500">
                    visibility
                </span>
            </div>

            {{-- KONFIRMASI PASSWORD BARU --}}
            <div class="relative">
                <input
                    type="password"
                    id="new_password_confirmation"
                    name="password_confirmation"
                    placeholder="Konfirmasi Password Baru"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12
               focus:outline-none focus:ring-2 focus:ring-green-600"
                    required>

                <span
                    onclick="togglePassword('new_password_confirmation', this)"
                    class="material-icons absolute right-4 top-1/2 -translate-y-1/2
               cursor-pointer text-gray-500">
                    visibility
                </span>
            </div>

            <button
                class="w-full bg-green-700 hover:bg-green-800
                       text-white font-semibold py-3 rounded-xl transition">
                Reset Password
            </button>
        </form>

        {{-- MODE KIRIM EMAIL --}}
        @else

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <input type="email" name="email"
                placeholder="Email terdaftar"
                class="w-full rounded-xl border border-gray-300 px-4 py-2
                       focus:outline-none focus:ring-2 focus:ring-green-600"
                required>

            <button
                class="w-full bg-green-700 hover:bg-green-800
                       text-white font-semibold py-3 rounded-xl transition">
                Kirim Link Reset
            </button>
        </form>

        @endif

        <p class="text-center mt-5 text-sm text-gray-600">
            <a href="{{ route('login') }}"
                class="text-green-700 font-semibold hover:underline">
                Kembali ke Login
            </a>
        </p>

    </div>
</div>

<script>
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);

        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "visibility_off";
        } else {
            input.type = "password";
            icon.textContent = "visibility";
        }
    }
</script>