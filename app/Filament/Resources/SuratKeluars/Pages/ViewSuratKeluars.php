<?php

namespace App\Filament\Resources\SuratKeluarResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SuratKeluars\SuratKeluarResource;

class ViewSuratKeluar extends ViewRecord
{
    protected static string $resource = SuratKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download')
                ->label('Download Surat')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn() => route('surat-keluar.download', [
                    'path' => $this->record->file_pdf
                ]))
                ->openUrlInNewTab(),

            Action::make('back')
                ->label('Kembali ke List')
                ->icon('heroicon-o-arrow-left')
                ->url(fn() => static::getResource()::getUrl('index')),
        ];
    }

    protected function getViewData(): array
    {
        return [
            // kirim FULL PATH Supabase
            'filePath' => $this->record->file_pdf,
        ];
    }

    public function getView(): string
    {
        return 'filamen.custom.view-surat-keluar';
    }
}
