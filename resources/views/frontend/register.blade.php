@include('layouts.navbar')

<div class="min-h-screen bg-green-50 flex items-center justify-center px-4 pt-24 pb-10">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">

        <div class="flex justify-center mb-4">
            <img src="{{ asset('assets/images/logo-kabpas.png') }}"
                alt="Logo Kabupaten Pasuruan"
                class="w-20 h-20 object-contain">
        </div>

        <h2 class="text-2xl font-bold text-center text-green-700 mb-1">
            Registrasi Akun
        </h2>
        <p class="text-center text-gray-600 mb-6 text-sm">
            Lengkapi data diri untuk mendaftar
            <span class="font-semibold text-green-700">SISEKAR</span>
        </p>

        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg mb-4 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
            @csrf

            <input type="text" name="nama" placeholder="Nama Lengkap"
                class="w-full rounded-xl border border-gray-300 px-4 py-2
                       focus:outline-none focus:ring-2 focus:ring-green-600"
                required>

            <input type="text" name="nik" placeholder="NIK"
                class="w-full rounded-xl border border-gray-300 px-4 py-2
                       focus:outline-none focus:ring-2 focus:ring-green-600"
                required>

            <input type="text" name="nomor_hp" placeholder="Nomor WhatsApp"
                class="w-full rounded-xl border border-gray-300 px-4 py-2
                       focus:outline-none focus:ring-2 focus:ring-green-600"
                required>

            {{-- PASSWORD --}}
            <div class="relative">
                <input type="password" id="reg_password" name="password"
                    placeholder="Password"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12
                           focus:outline-none focus:ring-2 focus:ring-green-600"
                    required>

                <span onclick="togglePassword('reg_password', this)"
                    class="material-icons absolute right-4 top-1/2 -translate-y-1/2
                           cursor-pointer text-gray-500">
                    visibility
                </span>
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div class="relative">
                <input type="password" id="reg_password_confirm"
                    name="password_confirmation"
                    placeholder="Konfirmasi Password"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12
                           focus:outline-none focus:ring-2 focus:ring-green-600"
                    required>

                <span onclick="togglePassword('reg_password_confirm', this)"
                    class="material-icons absolute right-4 top-1/2 -translate-y-1/2
                           cursor-pointer text-gray-500">
                    visibility
                </span>
            </div>

            <button
                class="w-full bg-green-700 hover:bg-green-800
                       text-white font-semibold py-3 rounded-xl transition">
                Daftar
            </button>
        </form>

        <p class="text-center mt-5 text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}"
                class="text-green-700 font-semibold hover:underline">
                Login
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