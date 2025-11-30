<div class="p-4 bg-white rounded-xl shadow">

    <p class="font-bold text-lg">
        Pengajuan {{ $surat->template->nama_template ?? '-' }}, dilakukan pada :
    </p>

    <div class="mt-3 space-y-1 text-gray-700">
        <p>Tanggal : {{ $surat->tanggal_pengajuan->format('d F Y') }}</p>
        <p>Pukul : {{ $surat->created_at->format('H:i') }}</p>
        <p>Jenis Surat : {{ $surat->template->nama_template ?? '-' }}</p>
        <p>Nama : {{ $surat->nama }}</p>
        <p>NIK : {{ $surat->nik }}</p>
        <p>
            Status :
            <span class="px-2 py-1 rounded text-white
                @if ($surat->status == 'belum') bg-red-500
                @elseif($surat->status == 'proses') bg-yellow-500
                @else bg-green-600
                @endif
            ">
                {{ ucfirst($surat->status) }}
            </span>
        </p>
    </div>

    <hr class="my-4">

    <p class="text-sm text-gray-600">
        <strong>Note*</strong>: Surat akan diproses pada saat jam kerja.
        Jika pengajuan dilakukan pada hari Sabtu, Minggu, atau hari libur nasional,
        maka pengajuan akan diproses pada saat jam kerja kembali normal.
    </p>

    <a href="{{ route('pelacakan.surat') }}"
        class="block mt-6 text-center bg-green-700 text-white py-2 rounded-lg">
        Kembali
    </a>

</div>