<!-- halaman form pengajuan surat -->

@include('layouts.navbar')
<div class="max-w-150 mx-auto mt-28 px-6 py-10 bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-center mb-6">Form Pengajuan Surat</h1>

    @if ($errors->any())
    <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('pengajuan-surat.store') }}">
        @csrf

        <div class="mb-4">
            <label for="nik" class="block font-semibold">NIK</label>
            <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                class="w-full border rounded px-3 py-2" maxlength="16" required>
        </div>

        <div class="mb-4">
            <label for="nama" class="block font-semibold">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label for="template_id" class="block font-semibold">Jenis Surat</label>
            <select name="template_id" id="template_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Jenis Surat --</option>
                @foreach ($templates as $template)
                <option value="{{ $template->id }}">{{ $template->nama_template }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="catatan" class="block font-semibold">Catatan Tambahan (opsional)</label>
            <textarea name="catatan" id="catatan" rows="3"
                class="w-full border rounded px-3 py-2">{{ old('catatan') }}</textarea>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Kirim Pengajuan
        </button>
    </form>
</div>
@include('layouts.footer')