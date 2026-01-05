@include('layouts.navbar')

<div class="max-w-2xl mx-auto px-4 pt-24 pb-10">

    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold text-lg">
            List Penyimpanan Surat :
        </h3>
        <a class="font-semibold text-lg text-green-600 hover:text-green-700 transision"
            href="{{ route('pengajuan-surat') }}">
            Kembali
        </a>
    </div>
    @if($suratTersimpan->isEmpty())
    <p class="text-gray-500">
        Belum ada surat yang diterbitkan.
    </p>
    @endif

    @foreach($suratTersimpan as $surat)
    <div class="bg-white rounded-2xl shadow p-5 mb-4">

        <div class="flex items-center justify-between gap-4">

            <!-- INFORMASI SURAT -->
            <div>
                <p class="font-semibold text-gray-800">
                    {{ $surat->pengajuan?->template?->nama_template ?? 'Jenis Surat Tidak Ditemukan' }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $surat->tanggal_jakarta }}
                </p>
            </div>

            <!-- BUTTON -->
            <a href="{{ route('penyimpanan.show', $surat->id) }}"
                class="ml-auto text-green-600 font-semibold hover:text-green-700 transition
          text-sm px-4 py-2 rounded-lg text-right">
                Lihat Detail Surat
            </a>


        </div>

    </div>
    @endforeach

</div>

@include('layouts.footer')