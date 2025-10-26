@include('layouts.navbar')

<div class="max-w-150 mx-auto mt-28 px-6 py-10 bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-center mb-6">Halaman Berita Desa</h1>

    <p class="text-center mb-6">Selamat datang di halaman berita desa. Berikut adalah informasi dan kabar terbaru dari desa kami.</p>

    {{-- Contoh daftar berita --}}
    <div class="space-y-6">
        <div class="border-b pb-4">
            <h2 class="text-xl font-semibold mb-2">Gotong Royong Pembersihan Lingkungan</h2>
            <p class="text-gray-600 text-sm mb-2">Tanggal: 20 Oktober 2025</p>
            <p class="text-justify">Warga desa melaksanakan kegiatan gotong royong membersihkan area sekitar balai desa dan jalan utama. Kegiatan ini rutin dilakukan setiap bulan.</p>
        </div>

        <div class="border-b pb-4">
            <h2 class="text-xl font-semibold mb-2">Pelatihan Digital untuk UMKM Desa</h2>
            <p class="text-gray-600 text-sm mb-2">Tanggal: 18 Oktober 2025</p>
            <p class="text-justify">Pemerintah desa mengadakan pelatihan digital untuk para pelaku UMKM agar dapat memasarkan produk secara online melalui media sosial dan marketplace.</p>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-2">Peringatan Hari Jadi Desa</h2>
            <p class="text-gray-600 text-sm mb-2">Tanggal: 10 Oktober 2025</p>
            <p class="text-justify">Warga merayakan hari jadi desa dengan acara kesenian, lomba, dan pagelaran budaya yang diikuti seluruh lapisan masyarakat.</p>
        </div>
    </div>
</div>

@include('layouts.footer')