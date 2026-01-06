<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SuratKeluarChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Surat Keluar';

    protected int | string | array $columnSpan = 1;
    protected static ?int $sort = 2;

    protected function getFilters(): ?array
    {
        return [
            'daily' => 'Per Hari (7 Hari)',
            'weekly' => 'Per Minggu (7 Minggu)',
            'monthly' => 'Per Bulan (12 Bulan)',
        ];
    }

    protected function getData(): array
    {
        return match ($this->filter) {
            'weekly'  => $this->getWeeklyData(),
            'monthly' => $this->getMonthlyData(),
            default   => $this->getDailyData(),
        };
    }

    //data per 7 hari
    protected function getDailyData(): array
    {
        $start = Carbon::now()->subDays(6)->startOfDay();
        $end   = Carbon::now()->endOfDay();

        $rows = DB::table('surat_terbit')
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $labels = [];
        $data   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();

            $labels[] = Carbon::parse($date)->translatedFormat('d M');
            $data[]   = $rows[$date]->total ?? 0;
        }

        return $this->chartResult($labels, $data);
    }

    //data per 7 minggu
    protected function getWeeklyData(): array
    {
        $rows = DB::table('surat_terbit')
            ->selectRaw("
                DATE_TRUNC('week', created_at) as minggu,
                COUNT(*) total
            ")
            ->where('created_at', '>=', now()->subWeeks(6))
            ->groupBy('minggu')
            ->orderBy('minggu')
            ->get()
            ->keyBy(fn($row) => Carbon::parse($row->minggu)->format('Y-m-d'));

        $labels = [];
        $data   = [];

        for ($i = 6; $i >= 0; $i--) {
            $week = now()->subWeeks($i)->startOfWeek();
            $key  = $week->format('Y-m-d');

            $labels[] = 'Minggu ' . $week->weekOfYear;
            $data[]   = $rows[$key]->total ?? 0;
        }

        return $this->chartResult($labels, $data);
    }

    // data per bulan 12 bulan
    protected function getMonthlyData(): array
    {
        $rows = DB::table('surat_terbit')
            ->selectRaw("
                DATE_TRUNC('month', created_at) as bulan,
                COUNT(*) total
            ")
            ->where('created_at', '>=', now()->subMonths(11))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy(fn($row) => Carbon::parse($row->bulan)->format('Y-m'));

        $labels = [];
        $data   = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $key   = $month->format('Y-m');

            $labels[] = $month->translatedFormat('M Y');
            $data[]   = $rows[$key]->total ?? 0;
        }

        return $this->chartResult($labels, $data);
    }

    // format chart result
    protected function chartResult(array $labels, array $data): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Surat Keluar',
                    'data'  => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'ticks' => [
                        'precision' => 0,
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
