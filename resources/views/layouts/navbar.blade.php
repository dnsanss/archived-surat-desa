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
                    <a href="{{ route('profil-desa') }}"
                        @class([ 'hover:text-green-600' , 'text-green-700 border-b-2'=> request()->routeIs('profil-desa'),
                        ])>
                        Profil Desa
                    </a>
                    <a href="{{ route('struktur-pemerintahan') }}"
                        @class([ 'hover:text-green-600' , 'text-green-700 border-b-2'=> request()->routeIs('struktur-pemerintahan'),
                        ])>
                        Struktur Pemerintahan Desa
                    </a>
                    <a href="#" class="hover:text-green-600">Berita</a>
                    <a href="#" class="hover:text-green-600">Pengajuan Surat</a>
                    <a href="{{ url('/admin') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-900 transition">
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
                <a href="#" class="hover:text-green-600 hover:font-semibold">Struktur Pemerintahan Desa</a>
                <a href="#" class="hover:text-green-600 hover:font-semibold">Berita</a>
                <a href="#" class="hover:text-green-600 hover:font-semibold">Pengajuan Surat</a>
                <a href="{{ url('/admin') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                    Admin
                </a>
            </div>
        </div>
    </nav>