@include('layouts.navbar')

<section class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-green-700 mb-6">
            Struktur Pemerintahan Desa
        </h2>

        <p class="text-gray-700 mb-8">
            Berikut adalah struktur organisasi dan pemerintahan Desa Karangasem.
        </p>

        @if ($struktur->isEmpty())
        <div class="bg-white rounded-lg p-6 shadow text-center text-gray-500">
            Data struktur pemerintahan belum tersedia.
        </div>
        @else
        <div class="grid md:grid-cols-3 gap-6 text-center">
            @foreach ($struktur as $item)
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-green-700 font-semibold text-lg mb-2">
                    {{ $item->nama }}
                </h3>
                <p class="text-gray-800">
                    {{ $item->jabatan }}
                </p>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</section>

@include('layouts.footer')