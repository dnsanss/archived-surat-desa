<?php

namespace App\Filament\Resources\TemplateSurats\Pages;

use App\Filament\Resources\TemplateSurats\TemplateSuratResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTemplateSurats extends ListRecords
{
    protected static string $resource = TemplateSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
