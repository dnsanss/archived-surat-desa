@include('layouts.navbar')

{{-- FLASH MESSAGE --}}
@if (session('success'))
<div class="max-w-5xl mx-auto mt-4 px-4">
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
</div>
@endif

@if (session('error'))
<div class="max-w-5xl mx-auto mt-4 px-4">
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg">
        {{ session('error') }}
    </div>
</div>
@endif

<div class="max-w-5xl mx-auto px-4 pt-24">

    {{-- CEK STATUS LOGIN --}}
    @if (!session('pengguna_login'))

    <div class="text-center bg-white rounded-xl shadow p-8">
        <h3 class="text-xl font-semibold mb-2">Anda belum masuk</h3>
        <p class="text-gray-600 mb-4">
            Silakan masuk terlebih dahulu untuk mengakses fitur pengajuan surat.
        </p>
        <a href="{{ route('login') }}"
            class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
            Masuk Disini
        </a>
    </div>

    @else

    {{-- SELAMAT DATANG + LOGOUT --}}
    <div class="bg-green-50 p-4 rounded-2xl shadow-sm mb-8">

        <div class="flex items-center justify-between">

            {{-- KIRI: AVATAR + TEKS (CLICKABLE DI MOBILE) --}}
            <div
                class="flex items-center gap-4 cursor-pointer select-none"
                onclick="toggleLogout()">
                <img src="{{ asset('assets/images/avatar.png') }}"
                    alt="Avatar"
                    class="w-16 h-16 rounded-full bg-white p-1">

                <div>
                    <p class="text-green-700 font-bold text-lg uppercase">
                        Halo, {{ session('data_pengguna.nama') }}.
                    </p>
                    <p class="text-gray-700">
                        Selamat datang di <span class="font-semibold text-green-700">SISEKAR.</span>
                    </p>
                </div>
            </div>

            {{-- LOGOUT DESKTOP --}}
            <a href="{{ route('logout') }}"
                class="hidden sm:inline-block px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                Keluar
            </a>
        </div>

        {{-- LOGOUT MOBILE (HIDDEN DEFAULT) --}}
        <div id="logoutMobile" class="hidden mt-4 sm:hidden">
            <a href="{{ route('logout') }}"
                class="block w-full text-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                Logout
            </a>
        </div>

    </div>

    <script>
        function toggleLogout() {
            const el = document.getElementById('logoutMobile');
            el.classList.toggle('hidden');
        }
    </script>


    {{-- JUDUL --}}
    <h2 class="text-green-700 font-bold text-lg mb-6">
        Surat Elektronik
    </h2>

    {{-- MENU --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center">

        {{-- Pengajuan Surat --}}
        <a href="{{ route('form.pengajuan.surat') }}"
            class="group bg-green-50 rounded-2xl p-6 shadow hover:shadow-lg transition">
            <div class="flex justify-center mb-4">
                {{-- ICON SVG --}}
                <img src="{{ asset('assets/images/pengajuan.png') }}"
                    class="w-16 h-16 group-hover:scale-110 transition">
            </div>
            <p class="font-semibold text-gray-700">
                Pengajuan<br>Surat
            </p>
        </a>

        {{-- Pelacakan --}}
        <a href="{{ route('pelacakan.surat') }}"
            class="group bg-green-50 rounded-2xl p-6 shadow hover:shadow-lg transition">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/images/lacak.png') }}"
                    class="w-16 h-16 group-hover:scale-110 transition">
            </div>
            <p class="font-semibold text-gray-700">
                Lacak<br>Pengajuan
            </p>
        </a>

        {{-- Penyimpanan --}}
        <a href="{{ route('penyimpanan.surat') }}"
            class="group bg-green-50 rounded-2xl p-6 shadow hover:shadow-lg transition">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/images/penyimpanan.png') }}"
                    class="w-16 h-16 group-hover:scale-110 transition">
            </div>
            <p class="font-semibold text-gray-700">
                Penyimpanan<br>Surat
            </p>
        </a>

    </div>

    <!-- {{-- LOGOUT --}}
    <div class="text-center mt-10">
        <a href="{{ route('logout') }}"
            class="inline-block text-red-600 hover:underline">
            Logout
        </a>
    </div> -->

    @endif

</div>

@include('layouts.footer')