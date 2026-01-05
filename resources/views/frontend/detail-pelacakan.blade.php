@include('layouts.navbar')

<div class="max-w-md mx-auto px-4 pt-24 pb-10">

    <div class="bg-green-50 rounded-2xl shadow-lg p-6">

        <div class="flex items-center space-x-4">
            <!-- ICON + STATUS -->
            <div>
                <p class="font-bold text-lg">
                    {{ $surat->template->nama_template ?? '-' }}, Dilakukan pada :
                </p>
            </div>
        </div>

        <!-- DETAIL DATA -->
        <div class="mt-4 space-y-2 text-gray-700 text-sm">
            <p><span class="font-medium">Tanggal</span> : {{ $surat->tanggal_pengajuan->format('d F Y') }}</p>
            <p><span class="font-medium">Pukul</span> : {{ $surat->created_at->format('H:i') }}</p>
            <p><span class="font-medium">Jenis Surat</span> : {{ $surat->template->nama_template ?? '-' }}</p>
            <p><span class="font-medium">Nama</span> : {{ $surat->nama }}</p>
            <p><span class="font-medium">NIK</span> : {{ $surat->nik }}</p>
            <p><span class="font-medium">Diproses Oleh</span> : {{ $surat->diproses_oleh ?? '-' }}</p>
            <p class="flex items-center gap-2">
                Status :

                @if($surat->status === 'menunggu')
                <span class="px-3 py-1 rounded-lg text-xs font-semibold text-white bg-red-500">
                    Belum diproses
                </span>
                @else
                <span class="px-3 py-1 rounded-lg text-xs font-semibold text-white bg-green-600">
                    Selesai
                </span>
                @endif
            </p>
        </div>

        <hr class="my-5">

        <!-- NOTE -->
        <div class="text-sm text-gray-700 p-4 rounded-lg">
            <strong>Catatan*</strong>:
            Surat akan diproses pada saat jam kerja.
            Jika pengajuan dilakukan pada hari Sabtu, Minggu, atau hari libur nasional,
            maka pengajuan akan diproses pada saat jam kerja kembali normal.
        </div>

        <!-- BUTTON -->
        <a href="{{ route('pelacakan.surat') }}"
            class="block mt-6 text-center bg-green-700 hover:bg-green-800
                   transition text-white py-2 rounded-lg font-medium shadow-lg">
            Kembali
        </a>

    </div>

</div>

@include('layouts.footer')