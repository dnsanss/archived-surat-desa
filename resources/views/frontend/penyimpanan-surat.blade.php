@include('layouts.navbar')
<div class="container my-4">

    <h3 class="mb-3">Penyimpanan Surat</h3>

    @if($suratTersimpan->isEmpty())
    <p class="text-muted">Belum ada surat yang diterbitkan.</p>
    @endif

    @foreach($suratTersimpan as $surat)
    <div class="card mb-3 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-1">
                    {{ $surat->pengajuan?->template?->nama_template ?? 'Jenis Surat Tidak Ditemukan' }}
                </h5>
                <small class="text-muted">
                    {{ $surat->tanggal_jakarta }}
                </small>
            </div>

            <div>
                <a href="{{ route('penyimpanan.show', $surat->id) }}"
                    class="btn btn-primary btn-sm">
                    Lihat Detail Surat
                </a>
            </div>

        </div>
    </div>
    @endforeach
</div>
@include('layouts.footer')