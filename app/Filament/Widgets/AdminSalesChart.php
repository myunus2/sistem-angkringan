<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\CarbonPeriod;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AdminSalesChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Pendapatan 7 Hari Terakhir';

    protected ?string $description = 'Ringkasan pendapatan (status done) per hari.';

    protected ?string $maxHeight = '320px';

    protected int | string | array $columnSpan = ['default' => 'full', 'xl' => 1];

    protected function getData(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $cacheKey = 'admin.sales_chart.revenue.' . $startDate->format('Ymd') . '.' . $endDate->format('Ymd');
        $salesByDate = cache()->remember($cacheKey, 30, function () use ($startDate, $endDate) {
            return Order::query()
                ->selectRaw('DATE(created_at) as order_date, COALESCE(SUM(total_price), 0) as total_sales')
                ->where('status', 'done')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('order_date')
                ->get()
                ->keyBy('order_date');
        });

        $period = CarbonPeriod::create($startDate->toDateString(), $endDate->toDateString());

        $labels = [];
        $data = [];

        foreach ($period as $date) {
            $dateKey = $date->format('Y-m-d');

            $labels[] = $date->translatedFormat('D, d M');
            $data[] = (float) ($salesByDate[$dateKey]->total_sales ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $data,
                    'backgroundColor' => '#f97316',
                    'borderColor' => '#f97316',
                    'borderWidth' => 1,
                    'borderRadius' => 8,
                    'barThickness' => 34,
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
                    'display' => true,
                    'position' => 'top',
                    'align' => 'end',
                ],
                'tooltip' => [
                    'backgroundColor' => '#111827',
                    'titleColor' => '#ffffff',
                    'bodyColor' => '#ffffff',
                    'padding' => 12,
                    'cornerRadius' => 8,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}