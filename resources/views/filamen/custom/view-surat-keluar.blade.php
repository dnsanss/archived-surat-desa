<x-filament::page>
    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <strong>Nomor Surat:</strong> {{ $record->nomor_surat }} <br>
                <strong>Kepada:</strong> {{ $record->kepada ?? '-' }} <br>
                <strong>Tanggal Surat:</strong> {{ \Carbon\Carbon::parse($record->tanggal_surat)->translatedFormat('d F Y') }}
            </div>
        </div>

        <hr class="my-4">

        <div>
            <br>
            <iframe
                src="{{ route('surat-keluar.view', ['filename' => basename($record->file_pdf)]) }}"
                width="100%"
                height="750px"
                style="border:1px solid #ccc; border-radius:8px;">
            </iframe>
        </div>
    </div>
</x-filament::page>