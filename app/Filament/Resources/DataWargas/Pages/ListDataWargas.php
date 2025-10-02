<?php

namespace App\Filament\Resources\DataWargas\Pages;

use App\Filament\Resources\DataWargas\DataWargaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDataWargas extends ListRecords
{

    protected static ?string $title = 'Data Warga';

    protected static string $resource = DataWargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
