<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\CarbonPeriod;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AdminSalesChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Penjualan 7 Hari Terakhir';

    protected ?string $maxHeight = '320px';

    protected function getData(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $salesByDate = Order::query()
            ->selectRaw('DATE(created_at) as order_date, COALESCE(SUM(total_price), 0) as total_sales')
            ->where('status', 'done')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('order_date')
            ->pluck('total_sales', 'order_date');

        $period = CarbonPeriod::create($startDate->toDateString(), $endDate->toDateString());

        $labels = [];
        $data = [];

        foreach ($period as $date) {
            $dateKey = $date->format('Y-m-d');

            $labels[] = $date->translatedFormat('D');
            $data[] = (float) ($salesByDate[$dateKey] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan',
                    'data' => $data,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                    'borderWidth' => 1,
                    'borderRadius' => 8,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array | RawJs | null
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
