<div class="container my-4">

    <h3 class="mb-4">Detail Surat Terbit</h3>

    <div class="card shadow-sm">
        <p class="font-bold text-lg">
            Pengajuan {{ $surat->pengajuan?->template->nama_template ?? '-' }}, dilakukan pada :
        </p>
        <div class="card-body">
            <p><strong>Tanggal :</strong>
                {{ $surat->created_at?->timezone('Asia/Jakarta')->format('d F Y') }}
            </p>

            <p><strong>Pukul :</strong> {{ $surat->created_at->format('H:i') }}</p>
            <p><strong>Jenis Surat :</strong>
                {{ $surat->pengajuan?->template->nama_template ?? '-' }}
            </p>

            <p><strong>Nama :</strong>
                {{ $surat->warga->nama 
                    ?? $surat->pengajuan?->warga?->nama 
                ?? '-' }}
            </p>
            <p><strong>NIK :</strong>
                {{ $surat->warga->nik ?? $surat->pengajuan?->warga?->nik ?? '-' }}
            </p>
            <p><strong>Nomor Surat:</strong>
                {{ $surat->nomor_surat ?? '-' }}
            </p>


            <hr>

            <p><strong>File Surat:</strong></p>
            @if($surat->file_pdf)
            <a href="{{ route('surat.download', $surat->id) }}"
                class="btn btn-success">
                Download Surat
            </a>
            <a href="{{ route('penyimpanan.surat') }}"
                class="btn btn-secondary">
                Kembali ke Penyimpanan Surat
            </a>

            @else
            <p class="text-danger">File surat tidak tersedia.</p>
            @endif

        </div>
    </div>

</div>