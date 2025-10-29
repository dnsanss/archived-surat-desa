@include('layouts.navbar')

<div class="bg-green-50 min-h-screen py-16 px-6">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-2xl p-8">

        {{-- Judul Berita --}}
        <h1 class="text-4xl font-extrabold text-green-700 text-center mb-4">
            {{ $berita->judul }}
        </h1>

        {{-- Info tambahan --}}
        <p class="text-center text-sm text-gray-500 mb-6">
            Dipublikasikan pada 
            <span class="font-medium text-green-700">
                {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') }}
            </span>
            oleh 
            <span class="font-semibold text-gray-800">{{ $berita->penulis }}</span>
        </p>

        {{-- Gambar Berita --}}
        @if ($berita->gambar)
            <img src="{{ asset('storage/' . $berita->gambar) }}" 
                 alt="{{ $berita->judul }}" 
                 class="w-full h-[450px] object-cover rounded-xl mb-8 shadow-md border">
        @endif

        {{-- Isi Berita --}}
        <div class="prose max-w-none text-gray-800 leading-relaxed text-justify mb-10">
            {!! nl2br(e($berita->isi)) !!}
        </div>

        {{-- Tombol kembali --}}
        <div class="text-center">
            <a href="{{ route('berita') }}" 
               class="bg-green-600 text-white font-semibold px-6 py-3 rounded-full shadow hover:bg-green-700 transition">
                ← Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</div>

@include('layouts.footer')