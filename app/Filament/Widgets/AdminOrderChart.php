<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\CarbonPeriod;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AdminOrderChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Jumlah Pesanan 7 Hari Terakhir';

    protected ?string $description = 'Jumlah transaksi selesai per hari.';

    protected ?string $maxHeight = '320px';

   protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $ordersByDate = Order::query()
            ->selectRaw('DATE(created_at) as order_date, COUNT(*) as total_orders')
            ->where('status', 'done')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('order_date')
            ->get()
            ->keyBy('order_date');

        $period = CarbonPeriod::create($startDate->toDateString(), $endDate->toDateString());

        $labels = [];
        $orderCounts = [];

        foreach ($period as $date) {
            $dateKey = $date->format('Y-m-d');

            $labels[] = $date->translatedFormat('D, d M');
            $orderCounts[] = (int) ($ordersByDate[$dateKey]->total_orders ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan',
                    'data' => $orderCounts,
                    'borderColor' => '#0f172a',
                    'backgroundColor' => '#0f172a',
                    'borderWidth' => 3,
                    'pointBackgroundColor' => '#ffffff',
                    'pointBorderColor' => '#0f172a',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
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