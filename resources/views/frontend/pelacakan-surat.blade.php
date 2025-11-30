@include('layouts.navbar')

<div class="container px-4 py-4">

    <h3 class="font-semibold text-lg mb-2">List Pelacakan Surat :</h3>

    @forelse($pengajuan as $item)
    <div class="bg-white rounded-xl shadow p-4 mb-3 flex justify-between items-center">

        <div>
            <p class="font-bold">{{ $item->template->nama_template ?? 'Template tidak ditemukan' }}
            </p>
            <p class="text-sm text-gray-600">{{ $item->tanggal_jakarta }}</p>
        </div>

        @if($item->status === 'selesai')
        <span class="px-3 py-1 rounded-full text-white bg-green-600 text-sm">Selesai</span>
        @else
        <span class="px-3 py-1 rounded-full text-white bg-red-600 text-sm">Belum diproses</span>
        @endif

    </div>
    @empty
    <p class="text-center text-gray-500 mt-4">Belum ada pengajuan surat.</p>
    @endforelse

</div>

@include('layouts.footer')