<?php

namespace App\Filament\Resources\DataWargas\Pages;

use App\Filament\Resources\DataWargas\DataWargaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDataWarga extends CreateRecord
{
    protected static string $resource = DataWargaResource::class;

    //setelah menambah data, diarahkan ke halaman list data warga
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
