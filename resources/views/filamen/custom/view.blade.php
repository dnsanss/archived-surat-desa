<!-- tampilan detail pada menu arsip surat -->
<x-filament::page>
    <div class="space-y-6">

        <div>
            <strong>Nomor Surat :</strong> {{ $record->nomor_surat }} <br>
            <strong>Nama Surat :</strong> {{ $record->nama_surat }} <br>
            <strong>Perihal :</strong> {{ $record->perihal }} <br>
        </div>

        <hr class="my-4">

        @if(Str::endsWith($record->dokumen, '.pdf'))
        <iframe
            src="{{ route('surat-masuk.view', ['path' => $filePath]) }}"
            width="100%"
            height="650px"
            style="border:1px solid #ccc; border-radius:8px;">
        </iframe>
        @else
        <a
            href="{{ route('surat-masuk.view', ['path' => $filePath]) }}"
            target="_blank"
            class="text-blue-600 underline">
            Lihat Dokumen
        </a>
        @endif

    </div>
</x-filament::page>