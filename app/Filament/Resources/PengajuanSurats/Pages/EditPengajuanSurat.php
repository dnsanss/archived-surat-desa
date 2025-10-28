<?php

namespace App\Filament\Resources\PengajuanSurats\Pages;

use App\Filament\Resources\PengajuanSurats\PengajuanSuratResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanSurat extends EditRecord
{
    protected static string $resource = PengajuanSuratResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
