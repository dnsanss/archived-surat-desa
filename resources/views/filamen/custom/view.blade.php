<!-- tampilan detail pada menu arsip surat -->
<x-filament::page>
    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <strong>Nomor Surat :</strong>{{ $record->nomor_surat }} <br>
                <strong>Nama Surat :</strong>{{ $record->nama_surat }} <br>
                <strong>Perihal :</strong>{{ $record->perihal }} <br>
            </div>
        </div>

        <hr class="my-4">
        <br>
        @if(Str::endsWith($record->dokumen, '.pdf'))
        <iframe src="{{ route('surat-masuk.view', ['filename' => basename($record->dokumen)]) }}"
            width="100%" height="600px"></iframe>
        @else
        <a href="{{ route('surat-masuk.view', ['filename' => basename($record->dokumen)]) }}"
            class="text-blue-600 underline" target="_blank">
            Lihat Dokumen
        </a>
        @endif
    </div>
</x-filament::page>