@include('layouts.navbar')

<div class="max-w-3xl mx-auto px-4 pt-24 pb-10">

    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold text-lg">
            List Pelacakan Surat :
        </h3>
        <a class="font-semibold text-lg text-green-600 hover:text-green-700 transision"
            href="{{ route('pengajuan-surat') }}">
            Kembali
        </a>
    </div>

    @forelse($pengajuan as $item)
    <a href="{{ route('pelacakan.show', $item->id) }}"
        class="block">
        <div
            class="bg-green-50 rounded-xl shadow p-4 mb-3
                       flex justify-between items-center
                       hover:bg-white transition">

            <div>
                <p class="font-bold">
                    {{ $item->template->nama_template ?? 'Template tidak ditemukan' }}
                </p>
                <p class="text-sm text-gray-600">
                    {{ $item->tanggal_jakarta }}
                </p>
            </div>

            @if($item->status === 'selesai')
            <span class="px-3 py-1 rounded-full text-white bg-green-600 text-sm">
                Selesai
            </span>
            @else
            <span class="px-3 py-1 rounded-full text-white bg-red-600 text-sm">
                Belum diproses
            </span>
            @endif
        </div>
    </a>
    @empty
    <p class="text-center text-gray-500 mt-6">
        Belum ada pengajuan surat.
    </p>
    @endforelse

</div>

@include('layouts.footer')