@include('layouts.navbar')

<div class="max-w-150 mx-auto mt-28 px-6 py-10 bg-white shadow-md rounded-lg p-6">
    {{-- Judul Berita --}}
    <h1 class="text-3xl font-bold text-center mb-4">{{ $berita->judul }}</h1>

    {{-- Info tambahan --}}
    <p class="text-center text-sm text-gray-500 mb-6">
        Dipublikasikan pada {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') }}
        oleh <span class="font-medium">{{ $berita->penulis }}</span>
    </p>

    {{-- Gambar Berita --}}
    @if ($berita->gambar)
        <img src="{{ asset('storage/' . $berita->gambar) }}" 
             alt="{{ $berita->judul }}" 
             class="w-full h-96 object-cover rounded-lg mb-6">
    @endif

    {{-- Isi Berita --}}
    <div class="prose max-w-none text-gray-800 leading-relaxed">
        {!! nl2br(e($berita->isi)) !!}
    </div>

    {{-- Tombol kembali --}}
    <div class="text-center mt-8">
        <a href="{{ route('berita') }}" 
           class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
            ← Kembali ke Daftar Berita
        </a>
    </div>
</div>

@include('layouts.footer')