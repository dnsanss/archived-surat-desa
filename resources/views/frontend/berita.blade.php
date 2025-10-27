@include('layouts.navbar')

<div class="max-w-150 mx-auto mt-28 px-6 py-10 bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-center mb-6">Berita Desa</h1>

    {{-- Pesan sukses jika ada --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Jika tidak ada berita --}}
    @if ($beritas->isEmpty())
        <p class="text-center text-gray-600">Belum ada berita yang dipublikasikan.</p>
    @else
        {{-- Daftar berita --}}
        <div class="space-y-6">
            @foreach ($beritas as $berita)
                <div class="border rounded-lg shadow-sm hover:shadow-md transition p-4">
                    {{-- Gambar berita --}}
                    @if ($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" 
                             alt="{{ $berita->judul }}" 
                             class="w-full h-64 object-cover rounded-lg mb-4">
                    @endif

                    {{-- Judul berita --}}
                    <h2 class="text-xl font-semibold mb-2 text-gray-800">
                        <a href="{{ route('berita.judul', $berita->id) }}" 
                           class="hover:text-blue-600 transition">
                            {{ $berita->judul }}
                        </a>
                    </h2>

                    {{-- Info tambahan --}}
                    <p class="text-sm text-gray-500 mb-2">
                        Dipublikasikan pada {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') }}
                        oleh <span class="font-medium">{{ $berita->penulis }}</span>
                    </p>

                    {{-- Cuplikan isi berita --}}
                    <p class="text-gray-700 mb-3">
                        {{ Str::limit(strip_tags($berita->isi), 150, '...') }}
                    </p>

                    {{-- Tombol Baca Selengkapnya --}}
                    <a href="{{ route('berita.judul', $berita->id) }}" 
                       class="text-blue-600 hover:text-blue-800 font-semibold">
                        Baca Selengkapnya →
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

@include('layouts.footer')