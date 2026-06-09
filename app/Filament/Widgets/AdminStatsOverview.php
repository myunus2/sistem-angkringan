<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\PendingOrders;
use App\Filament\Pages\RevenueReport;
use App\Filament\Pages\Transaksi;
use App\Filament\Resources\Products\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Ringkasan Angkringan';

    protected int | string | array $columnSpan = 'full';

    protected int | array | null $columns = [
        'default' => 1,
        'md' => 2,
        'xl' => 5,
    ];

    protected function getStats(): array
    {
        $totalPesanan = cache()->remember('admin.stats.total_pesanan', 30, fn () => Order::where('status', 'done')->count());
        $totalPendapatan = cache()->remember('admin.stats.total_pendapatan', 30, fn () => (float) Order::where('status', 'done')->sum('total_price'));
        $jumlahMenu = cache()->remember('admin.stats.jumlah_menu', 30, fn () => Product::count());
        $pesananPending = cache()->remember('admin.stats.pending', 30, fn () => Order::where('status', 'pending')->count());

        $salesTrend = cache()->remember('admin.stats.sales_trend', 30, fn () => collect(range(6, 0))
            ->map(fn (int $daysAgo): int => Order::query()
                ->where('status', 'done')
                ->whereDate('created_at', now()->subDays($daysAgo))
                ->count())
            ->all());

        $todayRevenue = cache()->remember('admin.stats.today_revenue', 30, fn () => (float) Order::query()
            ->where('status', 'done')
            ->whereDate('created_at', today())
            ->sum('total_price'));

        $yesterdayRevenue = cache()->remember('admin.stats.yesterday_revenue', 30, fn () => (float) Order::query()
            ->where('status', 'done')
            ->whereDate('created_at', today()->subDay())
            ->sum('total_price'));

        $growthPercentage = $yesterdayRevenue > 0
            ? (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100
            : ($todayRevenue > 0 ? 100 : 0);

        $menuCategories = cache()->remember('admin.stats.menu_categories', 30, fn () => Product::query()
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type'));

        return [
            Stat::make('Total Pesanan', number_format($totalPesanan))
                ->description('Tren pesanan 7 hari terakhir')
                ->chart($salesTrend)
                ->chartColor('warning')
                ->color('primary')
                ->icon('heroicon-o-receipt-percent')
                ->url(Transaksi::getUrl()),

            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description(($growthPercentage >= 0 ? '+' : '') . number_format($growthPercentage, 1, ',', '.') . '% dari kemarin')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->descriptionColor($growthPercentage >= 0 ? 'success' : 'danger')
                ->color('success')
                ->icon('heroicon-o-banknotes')
                ->url(RevenueReport::getUrl()),

            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Semua pendapatan dari pesanan selesai')
                ->color('success')
                ->icon('heroicon-o-currency-dollar')
                ->url(RevenueReport::getUrl()),

            Stat::make('Jumlah Menu', number_format($jumlahMenu))
                ->description('Makanan  ' . number_format((int) ($menuCategories['makanan'] ?? 0)) . ' | Minuman  ' . number_format((int) ($menuCategories['minuman'] ?? 0)) . ' | Snack ' . number_format((int) ($menuCategories['snack'] ?? 0)))
                ->color('warning')
                ->icon('heroicon-o-squares-2x2')
                ->url(ProductResource::getUrl('index')),

            Stat::make('Pending', number_format($pesananPending))
                ->description('Pesanan yang belum selesai')
                ->color('danger')
                ->icon('heroicon-o-clock')
                ->url(PendingOrders::getUrl()),
        ];
    }
}