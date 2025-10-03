<?php

namespace App\Filament\Resources\DataWargas\Pages;

use App\Filament\Resources\DataWargas\DataWargaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDataWarga extends EditRecord
{
    protected static string $resource = DataWargaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
