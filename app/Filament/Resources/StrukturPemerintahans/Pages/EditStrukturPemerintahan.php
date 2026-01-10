<?php

namespace App\Filament\Resources\StrukturPemerintahans\Pages;

use App\Filament\Resources\StrukturPemerintahans\StrukturPemerintahanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStrukturPemerintahan extends EditRecord
{
    protected static string $resource = StrukturPemerintahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
