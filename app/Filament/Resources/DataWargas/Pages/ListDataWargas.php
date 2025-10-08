<?php

namespace App\Filament\Resources\DataWargas\Pages;

use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DataWargas\DataWargaResource;
use App\Filament\Resources\DataWargas\Widgets\DataWargaStatsOverview;

class ListDataWargas extends ListRecords
{

    protected static ?string $title = 'Data Warga Desa Karangasem';

    protected static string $resource = DataWargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DataWargaStatsOverview::class,
        ];
    }
}
