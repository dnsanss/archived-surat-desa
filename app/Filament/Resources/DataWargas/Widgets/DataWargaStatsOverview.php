<?php

namespace App\Filament\Resources\DataWargas\Widgets;

use App\Models\DataWarga;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DataWargaStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = DataWarga::count();
        $laki = DataWarga::where('jenis_kelamin', 'L')->count();
        $perempuan = DataWarga::where('jenis_kelamin', 'P')->count();

        return [
            Stat::make('Total Warga', $total)
                ->icon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Laki-Laki', $laki)
                ->icon('heroicon-o-user')
                ->color('info'),

            Stat::make('Perempuan', $perempuan)
                ->icon('heroicon-o-users')
                ->color('pink'),
        ];
    }
}
