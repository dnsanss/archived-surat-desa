<!-- halaman profil desa -->

@include('layouts.navbar')
<!-- Hero Section -->
{{-- SECTION: Hero Profil Desa --}}
<div class="pt-10 font-['Montserrat']">
    <section class="text-center">
        <div class="relative">
            {{-- Gambar background --}}
            <img src="{{ asset('assets/images/bg1.jpg') }}"
                class="w-full h-130 object-cover">

            {{-- Overlay transparan (Tailwind v4 syntax) --}}
            <div class="absolute inset-0 bg-black/25"></div>

            {{-- Teks di atas gambar --}}
            <div
                class="absolute inset-0 flex flex-col justify-center items-center text-white px-6 sm:px-10 md:px-16 lg:px-24 text-center">
                <h3 class="text-3xl sm:text-4xl md:text-5xl drop-shadow-lg leading-tight font-['Karla']">
                    SELAMAT DATANG DI
                </h3>
                <h1
                    class="text-5xl sm:text-5xl md:text-6xl font-extrabold drop-shadow-lg leading-tight font-['Montserrat']">
                    DESA KARANGASEM
                </h1>
            </div>
            <div
                class="absolute inset-0 flex flex-col justify-center items-center text-white px-6 sm:px-10 md:px-16 lg:px-24 text-center -translate-y-6 sm:-translate-y-10">
            </div>
    </section>

    <!-- Section Profil Desa dengan Carousel Gambar -->
    <section class="container max-w-6xl mx-auto px-12 py-12 flex flex-col md:flex-row gap-8">
        <!-- Bagian Carousel Gambar -->
        <div class="relative w-full md:w-1/2 h-80  overflow-hidden rounded-lg shadow-lg">
            <!-- Gambar Carousel -->
            <div id="carousel" class="w-full h-full relative">
                <img src="{{ asset('assets/images/gambar1.jpg') }}"
                    class="absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-700"
                    alt="Gambar 1">
                <img src="{{ asset('assets/images/gambar2.jpg') }}"
                    class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700"
                    alt="Gambar 2">
                <img src="{{ asset('assets/images/gambar3.jpg') }}"
                    class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700"
                    alt="Gambar 3">
                <img src="{{ asset('assets/images/gambar4.jpg') }}"
                    class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700"
                    alt="Gambar 4">
                <img src="{{ asset('assets/images/gambar5.jpg') }}"
                    class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700"
                    alt="Gambar 5">
            </div>

            <!-- Tombol Navigasi -->
            <button id="prevBtn"
                class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full hover:bg-green-600 transition">
                &#10094;
            </button>
            <button id="nextBtn"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full hover:bg-green-600 transition">
                &#10095;
            </button>

            <!-- Indikator Bulatan -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                <span
                    class="dot w-3 h-3 rounded-full bg-white opacity-50 cursor-pointer transition-all duration-300"></span>
                <span
                    class="dot w-3 h-3 rounded-full bg-white opacity-50 cursor-pointer transition-all duration-300"></span>
                <span
                    class="dot w-3 h-3 rounded-full bg-white opacity-50 cursor-pointer transition-all duration-300"></span>
                <span
                    class="dot w-3 h-3 rounded-full bg-white opacity-50 cursor-pointer transition-all duration-300"></span>
                <span
                    class="dot w-3 h-3 rounded-full bg-white opacity-50 cursor-pointer transition-all duration-300"></span>
            </div>
        </div>

        <!-- Bagian Teks Profil Desa -->
        <div class="md:w-1/2 md-">
            <h2 class="text-3xl font-bold text-green-700 mb-4">Profil Desa Karangasem</h2>
            <p class="text-gray-700 leading-relaxed">
                Desa Karangasem merupakan desa yang berada di wilayah Kecamatan Lumbang, Kabupaten Pasuruan, Jawa Timur.
                Dengan luas wilayah secara keseluruhan 477 Hektar dan jumlah penduduk 1997 jiwa. Rata-rata penduduknya
                bekerja
                sebagai petani. Desa Karangasem memiliki potensi alam yang melimpah dan masyarakat yang ramah dan memiliki
                sikap toleransi antar umat beragama serta budaya yang masih kental.
            </p>
        </div>
    </section>

    <script>
        const images = document.querySelectorAll('#carousel img');
        const dots = document.querySelectorAll('.dot');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let current = 0;

        function showImage(index) {
            images.forEach((img, i) => {
                img.classList.remove('opacity-100');
                img.classList.add('opacity-0');
                dots[i].classList.remove('opacity-100', 'scale-110');
                dots[i].classList.add('opacity-50');
            });
            images[index].classList.remove('opacity-0');
            images[index].classList.add('opacity-100');
            dots[index].classList.remove('opacity-50');
            dots[index].classList.add('opacity-100', 'scale-110');
        }

        function nextImage() {
            current = (current + 1) % images.length;
            showImage(current);
        }

        function prevImage() {
            current = (current - 1 + images.length) % images.length;
            showImage(current);
        }

        nextBtn.addEventListener('click', nextImage);
        prevBtn.addEventListener('click', prevImage);

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                current = index;
                showImage(current);
            });
        });

        // Ganti gambar otomatis setiap 5 detik
        setInterval(nextImage, 5000);

        showImage(current);
    </script>

    <!-- Section Visi dan Misi -->
    <section class="max-w-6xl mx-auto px-12 py-6">
        <div class="flex flex-col md:flex-row md:space-x-12">

            <!-- Visi -->
            <div class="md:w-1/2">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">Visi</h2>
                <p class="text-gray-700 leading-relaxed text-justify">
                    Terwujudnya Desa Karangasem yang Maju, Transparan, dan Berdaya Saing melalui Tata Kelola Pemerintahan yang
                    Baik
                    serta Pemberdayaan Masyarakat yang Agamis, Partisipatif, dan Berkelanjutan.
                </p>
            </div>

            <!-- Misi -->
            <div class="md:w-1/2 mt-8 md:mt-0">
                <h2 class="text-2xl font-semibold text-green-700 mb-4">Misi</h2>
                <ul class="list-disc pl-5 space-y-3">
                    <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                        Menciptakan tata kelola pemerintahan yang baik (good governance) berdasarkan demokratisasi,
                        transparansi, partisipatif, akuntabilitas dan mengutamakan pelayanan kepada masyarakat.
                    </li>
                    <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                        Meningkatkan sistem Perencanaan Pembangunan Desa yang partisipatif dengan menekankan pada
                        konsepsi DOUM (Dari, Oleh dan Untuk Masyarakat).
                    </li>
                    <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                        Transparansi Informasi Penyelenggaraan
                        Pembangunan Desa (IPPD).
                    </li>
                    <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                        Meningkatkan pembangunan infrastruktur Desa secara berkesinambungan berdasarkan skala
                        prioritas dan pembidangan.
                    </li>
                    <li class="text-gray-700 leading-relaxed text-justify text-indent:-1em pl-[1em]">
                        Meningkatkan pembangunan dibidang ilmu pengetahuan untuk mendorong peningkatan kualitas
                        sumber daya manusia agar memiliki kecerdasan dan daya saing yang lebih baik.
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Section Berita Terkini -->
    <section class="max-w-6xl mx-auto px-12 py-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-green-700">Berita Terkini</h2>
            <a href="{{ route('berita') }}" class="text-green-600 hover:text-green-800 text-sm font-semibold">
                Lihat Semua →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($berita_terbaru as $item)
                <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                        class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 text-lg mb-2 line-clamp-2">{{ $item->judul }}</h3>
                        <p class="text-gray-500 text-sm mb-3">
                            {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') }}
                        </p>
                        <a href="{{ route('berita.judul', $item->id) }}"
                            class="text-green-600 font-medium text-sm hover:underline">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

@include('layouts.footer')