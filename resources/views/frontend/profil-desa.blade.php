@include('layouts.navbar')
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
</div>

@include('layouts.footer')