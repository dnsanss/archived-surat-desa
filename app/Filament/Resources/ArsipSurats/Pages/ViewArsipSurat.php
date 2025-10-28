<?php

namespace App\Filament\Resources\ArsipSuratResource\Pages;

use App\Filament\Resources\ArsipSurats\ArsipSuratResource;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\ViewRecord;

class ViewArsipSurat extends ViewRecord
{
    protected static string $resource = ArsipSuratResource::class;

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download')
                ->label('Download Dokumen')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn() => route('surat-masuk.view', ['filename' => basename($this->record->dokumen)]))
                ->openUrlInNewTab(),
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->url(fn() => static::getResource()::getUrl('index')),

        ];
    }

    protected function getViewData(): array
    {
        return [
            'fileUrl' => Storage::url($this->record->dokumen),
        ];
    }

    public function getView(): string
    {
        return 'filamen.custom.view';
    }
}
