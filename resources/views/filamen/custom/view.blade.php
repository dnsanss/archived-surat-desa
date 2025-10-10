<x-filament::page>
    <div class="space-y-6">
        <div class="mb-4">
            <h2 class="text-lg font-bold">Nomor Surat: {{ $record->nomor_surat }}</h2>
            <h2 class="text-gray-600">Nama Surat: {{ $record->nama_surat }}</h2>
            <h2 class="text-gray-600">Perihal: {{ $record->perihal }}</h2>
        </div>

        @if(Str::endsWith($record->dokumen, '.pdf'))
        <iframe src="{{ route('arsip.view', ['filename' => basename($record->dokumen)]) }}"
            width="100%" height="600px"></iframe>
        @else
        <a href="{{ route('arsip.view', ['filename' => basename($record->dokumen)]) }}"
            class="text-blue-600 underline" target="_blank">
            Lihat Dokumen
        </a>
        @endif
    </div>
</x-filament::page>