<?php

namespace App\Filament\Widgets;

use App\Models\ArsipSurat;
use App\Models\SuratTerbit;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuratStatWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Statistik Surat';
    protected function getColumns(): int
    {
        return 2;
    }

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Surat Keluar', SuratTerbit::count())
                ->icon('heroicon-o-document-arrow-up')
                ->color('warning'),

            Stat::make('Total Surat Masuk', ArsipSurat::count())
                ->icon('heroicon-o-document-arrow-down')
                ->color('info'),
        ];
    }
}
