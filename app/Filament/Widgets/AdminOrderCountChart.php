<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\CarbonPeriod;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AdminOrderCountChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Jumlah Pesanan 7 Hari Terakhir';

    protected ?string $description = 'Jumlah pesanan (status done) per hari.';

    protected ?string $maxHeight = '320px';

    protected int | string | array $columnSpan = ['default' => 'full', 'xl' => 1];

    protected function getData(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $cacheKey = 'admin.sales_chart.order_count.' . $startDate->format('Ymd') . '.' . $endDate->format('Ymd');
        $countsByDate = cache()->remember($cacheKey, 30, function () use ($startDate, $endDate) {
            return Order::query()
                ->selectRaw('DATE(created_at) as order_date, COUNT(*) as total_orders')
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
            $data[] = (int) ($countsByDate[$dateKey]->total_orders ?? 0);
        }

        return [
            'datasets' => [
                [
                    // DIUBAH: Menggunakan style bar chart warna oranye yang serasi
                    'label' => 'Jumlah Pesanan',
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
        // DIUBAH: Dari 'line' menjadi 'bar'
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
                        'display' => false, // Menghilangkan garis horizontal
                    ],
                    'ticks' => [
                        'precision' => 0, // Memastikan skala angka di kiri bulat (1, 2, 3...) bukan desimal
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false, // Menghilangkan garis vertikal
                    ],
                ],
            ],
        ];
    }
}