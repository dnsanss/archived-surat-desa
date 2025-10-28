<?php

namespace App\Filament\Resources\TemplateSurats\Pages;

use App\Filament\Resources\TemplateSurats\TemplateSuratResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTemplateSurat extends EditRecord
{
    protected static string $resource = TemplateSuratResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
