<?php

namespace App\Filament\Widgets;

use App\Models\DataWarga;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JumlahWargaWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Statistik Jumlah Keseluruhan Warga Desa';
    protected function getStats(): array
    {
        $laki = DataWarga::where('jenis_kelamin', 'L')->count();
        $perempuan = DataWarga::where('jenis_kelamin', 'P')->count();
        $total = DataWarga::count();

        return [
            Stat::make('Total Warga', $total)
                ->icon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Warga Laki-laki', $laki)
                ->icon('heroicon-o-user')
                ->color('primary'),

            Stat::make('Warga Perempuan', $perempuan)
                ->icon('heroicon-o-users')
                ->color('pink'),
        ];
    }
}
