@include('layouts.navbar')

<div class="max-w-md mx-auto px-4 pt-24 pb-10">

    <div class="bg-green-50 rounded-3xl shadow-lg p-6 text-center">

        {{-- ICON CHECK --}}
        <div class="w-28 h-28 bg-white rounded-full flex items-center justify-center mx-auto">
            <img src="{{ asset('assets/images/checklist.png') }}"
                alt="Success"
                class="w-28 h-28">
        </div>

        {{-- TITLE --}}
        <h2 class="mt-4 text-2xl font-extrabold">
            BERHASIL
        </h2>

        <p class="mt-1 text-sm font-semibold">
            MELAKUKAN PENGAJUAN SURAT PADA :
        </p>

        {{-- DETAIL --}}
        <div class="text-left mt-5 space-y-1 text-sm">
            <p><strong>Tanggal :</strong> {{ $tanggal }}</p>
            <p><strong>Pukul :</strong> {{ $jam }}</p>
            <p><strong>Jenis Surat :</strong> {{ $pengajuan->template->nama_template }}</p>
            <p><strong>Nama :</strong> {{ $pengajuan->nama }}</p>
            <p><strong>NIK :</strong> {{ $pengajuan->nik }}</p>
            <p class="flex items-center gap-2">
                <strong>Status :</strong>

                @if($pengajuan->status == 'menunggu')
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

        {{-- DIVIDER --}}
        <hr class="my-5 border-gray-300">

        {{-- NOTE --}}
        <p class="text-left text-xs text-gray-700 leading-relaxed">
            <strong>Note*</strong>: Surat akan diproses pada saat jam kerja.
            Jika pengajuan dilakukan pada hari Sabtu, Minggu, atau hari libur nasional,
            maka pengajuan akan diproses pada saat jam kerja kembali normal.
        </p>

        {{-- BUTTONS --}}
        <a href="{{ route('pelacakan.surat') }}"
            class="block w-full mt-6 bg-green-600 text-white py-3 rounded-full shadow-lg font-semibold hover:bg-green-700 transition">
            Lacak Pengajuan Surat
        </a>

        <a href="{{ route('pengajuan-surat') }}"
            class="block w-full mt-3 py-3 rounded-full border-2 border-green-600 text-green-700 shadow-lg font-semibold hover:bg-green-100 transition">
            Kembali ke Beranda
        </a>

    </div>

</div>

@include('layouts.footer')