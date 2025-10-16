<!-- halaman struktur pemerintahan desa -->

@include('layouts.navbar')
<section class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-6">Struktur Pemerintahan Desa</h2>

        <p class="text-gray-700 mb-8">
            Berikut adalah struktur organisasi dan pemerintahan Desa Karangasem.
        </p>

        {{-- Contoh struktur (bisa diganti dengan tabel, grid, atau card) --}}
        <div class="grid md:grid-cols-3 gap-6 text-center">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-green-700 font-semibold">Kepala Desa</h3>
                <p>Nama Kepala Desa</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-green-700 font-semibold">Sekretaris Desa</h3>
                <p>Nama Sekretaris Desa</p>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-green-700 font-semibold">Bendahara Desa</h3>
                <p>Nama Bendahara Desa</p>
            </div>
        </div>
    </div>
</section>
@include('layouts.footer')