<?php

namespace App\Filament\Resources\StrukturPemerintahans\Pages;

use App\Filament\Resources\StrukturPemerintahans\StrukturPemerintahanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStrukturPemerintahans extends ListRecords
{
    protected static string $resource = StrukturPemerintahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
