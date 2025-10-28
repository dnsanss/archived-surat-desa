<?php

namespace App\Filament\Resources\ArsipSurats\Pages;

use App\Filament\Resources\ArsipSurats\ArsipSuratResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArsipSurats extends ListRecords
{

    protected static ?string $title = 'Surat Masuk';

    protected static string $resource = ArsipSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
