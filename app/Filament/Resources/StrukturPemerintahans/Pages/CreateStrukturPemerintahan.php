<?php

namespace App\Filament\Resources\StrukturPemerintahans\Pages;

use App\Filament\Resources\StrukturPemerintahans\StrukturPemerintahanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStrukturPemerintahan extends CreateRecord
{
    protected static string $resource = StrukturPemerintahanResource::class;

    //override the redirect url after creating a record
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
