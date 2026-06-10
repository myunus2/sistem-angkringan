<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminSalesChart;
use App\Filament\Widgets\AdminOrderCountChart;
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\FavoriteMenusTable;
use App\Filament\Widgets\LatestOrdersTable;


class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard Admin';

    public function getWidgets(): array
    {
        return [
            AdminStatsOverview::class,
            AdminSalesChart::class,
            AdminOrderCountChart::class,
            FavoriteMenusTable::class,
            LatestOrdersTable::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'xl' => 2,
        ];
    }
}
