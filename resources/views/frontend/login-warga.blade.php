@include('layouts.navbar')

<div class="min-h-screen flex items-center justify-center bg-green-50 px-4 pt-24 pb-10">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">

        {{-- LOGO --}}
        <div class="flex justify-center mb-4">
            <img src="{{ asset('assets/images/logo-kabpas.png') }}"
                alt="Logo Kabupaten Pasuruan"
                class="w-20 h-auto">
        </div>

        {{-- JUDUL --}}
        <h2 class="text-2xl font-extrabold text-center text-green-700">
            Login SISEKAR
        </h2>
        <p class="text-center text-gray-600 text-sm mb-6">
            Aplikasi Surat Elektronik Desa Karangasem
        </p>

        {{-- ERROR --}}
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
            @csrf

            {{-- NAMA --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Nama
                </label>
                <input type="text" name="nama"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2
                           focus:outline-none focus:ring-2 focus:ring-green-600"
                    required>
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Password
                </label>

                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12
                               focus:outline-none focus:ring-2 focus:ring-green-600"
                        required>

                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 flex items-center px-3
                               text-gray-500 hover:text-green-700">
                        <span id="eyeIcon" class="material-icons">
                            visibility
                        </span>
                    </button>
                </div>
            </div>

            <button
                class="w-full bg-green-700 hover:bg-green-800
                       text-white font-semibold py-3 rounded-xl
                       transition duration-200">
                Masuk
            </button>
        </form>

        {{-- REGISTER --}}
        <p class="text-center mt-4 text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}"
                class="text-green-700 font-semibold hover:underline">
                Daftar
            </a>
        </p>

    </div>

</div>

{{-- SCRIPT --}}
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>