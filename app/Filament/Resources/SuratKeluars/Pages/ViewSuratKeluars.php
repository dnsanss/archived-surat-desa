<?php

namespace App\Filament\Resources\SuratKeluarResource\Pages;

use Filament\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SuratKeluars\SuratKeluarResource;

class ViewSuratKeluar extends ViewRecord
{
    protected static string $resource = SuratKeluarResource::class;

    // Override header actions to add download button
    protected function getHeaderActions(): array
    {
        return [
            Action::make('download')
                ->label('Download Surat')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn() => route('surat-keluar.view', ['filename' => basename($this->record->file_pdf)]))
                ->openUrlInNewTab(),

            Action::make('back')
                ->label('Kembali ke List')
                ->icon('heroicon-o-arrow-left')
                ->url(fn() => static::getResource()::getUrl('index')),
        ];
    }

    // Override untuk mengirim data ke view custom
    protected function getViewData(): array
    {
        return [
            'filePath' => $this->record->file_pdf,
        ];
    }

    // Override untuk menggunakan blade view custom
    public function getView(): string
    {
        return 'filamen.custom.view-surat-keluar';
    }
}
