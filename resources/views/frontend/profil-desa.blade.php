<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Desa Karangasem</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Top Bar -->
    <nav x-data="{ open: false }" class="bg-white/70 backdrop-blur-md fixed top-0 left-0 w-full shadow-sm z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <h1 class="text-xl font-bold text-green-700">DESA KARANGASEM</h1>

                {{-- Menu Tengah (Desktop) --}}
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('profil-desa') }}" class="text-green-700 hover:text-green-900 font-semibold transition">Profil Desa</a>
                    <a href="#" class="hover:text-green-600 hover:font-semibold transition">Struktur Organisasi</a>
                    <a href="#" class="hover:text-green-600 hover:font-semibold transition">Berita</a>
                    <a href="#" class="hover:text-green-600 hover:font-semibold transition">Pengajuan Surat</a>
                    <a href="{{ url('/admin') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                        Admin
                    </a>
                </div>

                {{-- Burger Button (Mobile) --}}
                <button @click="open = !open" class="md:hidden focus:outline-none">
                    {{-- Icon Burger --}}
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    {{-- Icon Back --}}
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Menu Mobile Dropdown --}}
        <div x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="md:hidden bg-white/90 backdrop-blur-lg border-t border-gray-200">
            <div class="flex flex-col items-center py-4 space-y-3">
                <a href="{{ route('profil-desa') }}" class="text-green-700 hover:text-green-900 font-semibold">Profil Desa</a>
                <a href="#" class="hover:text-green-600 hover:font-semibold">Struktur Organisasi</a>
                <a href="#" class="hover:text-green-600 hover:font-semibold">Berita</a>
                <a href="#" class="hover:text-green-600 hover:font-semibold">Pengajuan Surat</a>
                <a href="{{ url('/admin') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                    Admin
                </a>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    {{-- SECTION: Hero Profil Desa --}}
    <div class="pt-10">
        <section class="text-center">
            <div class="relative">
                {{-- Gambar background --}}
                <img src="{{ asset('assets/images/bg1.jpg') }}"
                    class="w-full h-130 object-cover">

                {{-- Overlay transparan (Tailwind v4 syntax) --}}
                <div class="absolute inset-0 bg-black/25"></div>

                {{-- Teks di atas gambar --}}
                <div class="absolute inset-0 flex flex-col justify-center items-center text-white px-6 sm:px-10 md:px-16 lg:px-24 text-center">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3 drop-shadow-lg leading-tight">
                        Profil Desa Karangasem
                    </h2>
                    <p class="max-w-2xl text-base sm:text-lg md:text-xl drop-shadow-md leading-relaxed">
                        Desa Karangasem adalah salah satu desa di wilayah Kecamatan Lumbang, Kabupaten Pasuruan, Provinsi Jawa Timur.
                        Terletak di daerah yang kaya akan budaya dan tradisi, desa ini memiliki potensi alam yang indah serta masyarakat yang ramah dan gotong royong.
                        Mari kita jelajahi lebih dalam tentang sejarah, visi, dan misi desa kami.
                    </p>
                </div>
                <div class="absolute inset-0 flex flex-col justify-center items-center text-white px-6 sm:px-10 md:px-16 lg:px-24 text-center -translate-y-6 sm:-translate-y-10">
                </div>
        </section>

        <!-- Konten Profil -->
        <section class="max-w-6xl mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row md:space-x-12">
                <!-- Visi -->
                <div class="md:w-1/2">
                    <h2 class="text-2xl font-semibold text-green-700 mb-4">Visi</h2>
                    <p class="text-gray-700 leading-relaxed text-justify">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus.
                    </p>
                </div>

                <!-- Misi -->
                <div class="md:w-1/2 mt-8 md:mt-0">
                    <h2 class="text-2xl font-semibold text-green-700 mb-4">Misi</h2>
                    <ul class="list-disc pl-5 space-y-3">
                        <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus omnis optio,
                            tenetur deleniti illum qui natus blanditiis.
                        </li>
                        <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </li>
                        <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </li>
                        <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-green-700 text-white mt-16">
            <div class="max-w-6xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bagian kiri: Peta -->
                <div class="w-full h-64 md:h-80 rounded-lg overflow-hidden shadow-lg">
                    <iframe
                        class="w-full h-full"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d842.3633709065442!2d112.95400192176739!3d-7.768887905983279!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7ca9555555555%3A0x125008136f9bb691!2sBalai%20Desa%20karangasem%20kecamatan%20Lumbang%20Pasuruan!5e1!3m2!1sid!2sid!4v1759729453699!5m2!1sid!2sid"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <!-- Bagian kanan: Informasi Kontak -->
                <div class="flex flex-col justify-center">
                    <h3 class="text-2xl font-semibold mb-3">Desa Karangasem</h3>
                    <p class="text-gray-100 mb-4 leading-relaxed">
                        Desa Karangasem, Kecamatan Lumbang, Kabupaten Pasuruan, Jawa Timur.<br>
                        Hubungi kami untuk informasi lebih lanjut mengenai layanan desa dan pengajuan surat online.
                    </p>
                    <p class="text-sm text-gray-300 mt-auto">
                        &copy; 2025 Desa Karangasem. Dilindungi Hak Cipta.
                    </p>
                </div>
            </div>
        </footer>

    </div>
</body>

</html>