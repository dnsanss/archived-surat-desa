@include('layouts.navbar')

<div class="flex justify-center px-4 pt-24 pb-10">
    <div class="w-full max-w-md bg-green-50 rounded-2xl shadow-lg p-6 text-center">

        <h2 class="text-2xl font-extrabold mb-1">DETAIL SURAT TERBIT</h2>

        <p class="text-sm text-gray-700 mb-4">
            Pengajuan {{ $surat->pengajuan?->template->nama_template ?? '-' }},
            dilakukan pada :
        </p>

        {{-- DETAIL --}}
        <div class="text-left text-gray-800 space-y-1">
            <p>
                <strong>Tanggal :</strong>
                {{ $surat->created_at?->timezone('Asia/Jakarta')->format('d F Y') }}
            </p>

            <p>
                <strong>Pukul :</strong>
                {{ $surat->created_at->format('H:i') }}
            </p>

            <p>
                <strong>Jenis Surat :</strong>
                {{ $surat->pengajuan?->template->nama_template ?? '-' }}
            </p>

            <p>
                <strong>Nama :</strong>
                {{ $surat->warga->nama 
                    ?? $surat->pengajuan?->warga?->nama 
                    ?? '-' }}
            </p>

            <p>
                <strong>NIK :</strong>
                {{ $surat->warga->nik 
                    ?? $surat->pengajuan?->warga?->nik 
                    ?? '-' }}
            </p>

            <p>
                <strong>Nomor Surat :</strong>
                {{ $surat->nomor_surat ?? '-' }}
            </p>

            <p>
                <strong>Diproses Oleh :</strong>
                {{ $surat->diproses_oleh ?? '-' }}
            </p>
        </div>

        <hr class="my-4">

        {{-- FILE SURAT --}}
        <div class="text-left">
            @if($surat->file_pdf)
            <a href="{{ route('surat.download', $surat->qr_token) }}"
                class="block w-full text-center bg-red-700 hover:bg-red-800 hover:shadow-xl
                          text-white font-semibold py-3 rounded-xl shadow-lg mb-3 transition">
                Download Surat
            </a>

            <a href="{{ route('penyimpanan.surat') }}"
                class="block w-full text-center border-2 border-green-700
                          text-green-700 font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transition">
                Kembali ke Penyimpanan Surat
            </a>
            @else
            <p class="text-red-600">File surat tidak tersedia.</p>
            @endif
        </div>

    </div>
</div>

@include('layouts.footer')