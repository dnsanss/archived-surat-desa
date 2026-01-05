@include('layouts.navbar')

<div class="max-w-md mx-auto px-4 pt-24 pb-10">

    <div class="bg-green-50 rounded-2xl shadow-lg p-6">

        <h3 class="text-center text-lg font-bold mb-6">
            Form Pengajuan Surat
        </h3>

        {{-- ERROR --}}
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4 text-sm">
            <strong>Oops!</strong> Ada kesalahan pada input anda:
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('pengajuan.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- NAMA --}}
            <div>
                <label class="block font-semibold mb-1">
                    Masukkan Nama Lengkap
                </label>
                <input
                    type="text"
                    value="{{ session('data_pengguna')->nama }}"
                    readonly
                    class="w-full rounded-xl border border-green-500 px-4 py-2 bg-white focus:outline-none">
            </div>

            {{-- NIK --}}
            <div>
                <label class="block font-semibold mb-1">
                    Masukkan NIK
                </label>
                <input
                    type="text"
                    value="{{ session('data_pengguna')->nik }}"
                    readonly
                    class="w-full rounded-xl border border-green-500 px-4 py-2 bg-white focus:outline-none">
            </div>

            {{-- NOMOR WA --}}
            <div>
                <label class="block font-semibold mb-1">
                    Masukkan Nomor WhatsApp (WA)
                </label>
                <input
                    type="text"
                    value="{{ session('data_pengguna')->nomor_hp }}"
                    readonly
                    class="w-full rounded-xl border border-green-500 px-4 py-2 bg-white focus:outline-none">
            </div>

            {{-- PILIH SURAT --}}
            <div>
                <label class="block font-semibold mb-1">
                    Pilih Pengajuan Surat
                </label>
                <select
                    name="template_id"
                    required
                    class="w-full rounded-xl border border-green-500 px-4 py-2 bg-white focus:outline-none">
                    <option value="">-- Pilih Pengajuan Surat --</option>
                    @foreach ($templates as $template)
                    <option value="{{ $template->id }}">
                        {{ $template->nama_template }}
                    </option>
                    @endforeach
                </select>

                @error('template_id')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- NOTE --}}
            <p class="text-sm text-gray-600 mt-2">
                <strong>Note*</strong> : Harap masukkan nomor WhatsApp yang aktif
                agar pihak desa karangasem dapat menghubungimu ketika ada permasalahan.
            </p>

            {{-- SUBMIT --}}
            <button
                type="submit"
                class="w-full mt-4 bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 shadow-lg transition">
                Buat Pengajuan
            </button>

            {{-- BATAL --}}
            <a href="{{ route('pengajuan-surat') }}"
                class="block w-full mt-3 text-center py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-800 shadow-lg transition">
                Batal
            </a>

        </form>

    </div>

</div>

@include('layouts.footer')