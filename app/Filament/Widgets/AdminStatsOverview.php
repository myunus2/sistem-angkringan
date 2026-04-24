<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\OrdersReport;
use App\Filament\Pages\PendingOrders;
use App\Filament\Pages\RevenueReport;
use App\Filament\Resources\Products\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Angkringan';

    protected function getStats(): array
    {
        $totalPesanan = Order::count();
        $totalPendapatan = (float) Order::sum('total_price');
        $jumlahMenu = Product::count();
        $pesananPending = Order::where('status', 'pending')->count();

        return [
            Stat::make('Total Pesanan', number_format($totalPesanan))
                ->description('Jumlah seluruh order')
                ->color('primary')
                ->url(OrdersReport::getUrl()),
            Stat::make('Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Akumulasi dari semua pesanan')
                ->color('success')
                ->url(RevenueReport::getUrl()),
            Stat::make('Jumlah Menu', number_format($jumlahMenu))
                ->description('Produk yang tersedia')
                ->color('warning')
                ->url(ProductResource::getUrl('index')),
            Stat::make('Pending', number_format($pesananPending))
                ->description('Pesanan yang belum selesai')
                ->color('danger')
                ->url(PendingOrders::getUrl()),
        ];
    }
}
