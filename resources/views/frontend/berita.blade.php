@include('layouts.navbar')

<div class="max-w-6xl mx-auto mt-24 px-4">
    <h2 class="text-center text-2xl font-bold mb-8 border-b-4 border-green-600 pb-2 text-green-700">
        BERITA TERBARU
    </h2>

    {{-- Jika tidak ada berita --}}
    @if ($beritas->isEmpty())
        <p class="text-center text-gray-600">Belum ada berita yang dipublikasikan.</p>
    @else
        {{-- ==== BERITA UTAMA ==== --}}
        @php $utama = $beritas->first(); @endphp
        <div class="bg-white shadow-lg rounded-xl p-5 flex flex-col md:flex-row items-center gap-5 mb-10 border border-green-300">
            {{-- Gambar utama --}}
            @if ($utama->gambar)
                <img src="{{ asset('storage/' . $utama->gambar) }}" 
                    alt="{{ $utama->judul }}" 
                    class="w-full md:w-1/3 h-56 object-cover rounded-lg border-2 border-green-600">
            @endif

            {{-- Konten utama --}}
            <div class="flex-1">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-bold text-gray-800 hover:text-green-700 transition">
                        <a href="{{ route('berita.judul', $utama->id) }}">{{ $utama->judul }}</a>
                    </h3>
                    <span class="text-gray-600 text-sm">
                        {{ \Carbon\Carbon::parse($utama->tanggal_publikasi)->format('d M Y') }}
                    </span>
                </div>
                <p class="text-gray-700 mb-3">
                    {{ Str::limit(strip_tags($utama->isi), 150, '...') }}
                </p>
                <p class="text-sm italic text-gray-500 mb-3">
                    {{ $utama->penulis }}
                </p>
                <a href="{{ route('berita.judul', $utama->id) }}" 
                   class="text-green-700 font-semibold hover:underline">
                    BACA SELENGKAPNYA...
                </a>
            </div>
        </div>

        {{-- ==== BERITA LAINNYA ==== --}}
        <h3 class="text-center text-lg font-semibold text-green-700 mb-5">Berita Lainnya</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($beritas->skip(1) as $item)
                <div class="bg-white shadow-md rounded-xl p-3 hover:shadow-lg transition flex flex-col items-center border border-green-200">
                    @if ($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" 
                            alt="{{ $item->judul }}" 
                            class="w-full h-40 object-cover rounded-lg border-2 border-green-600 mb-3">
                    @endif

                    <h4 class="text-md font-bold text-center hover:text-green-700 transition mb-1">
                        <a href="{{ route('berita.judul', $item->id) }}">{{ $item->judul }}</a>
                    </h4>

                    <p class="text-sm text-gray-500 mb-2">
                        {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y') }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- PAGINATION --}}
    <div class="mt-10 flex justify-center">
        {{ $beritas->links('pagination::tailwind') }}
    </div>
</div>

@include('layouts.footer')