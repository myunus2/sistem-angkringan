<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminSalesChart;
use App\Filament\Widgets\AdminOrderChart;
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
    AdminOrderChart::class,
    FavoriteMenusTable::class,
    LatestOrdersTable::class,
];
    }

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'md' => 2,
            'xl' => 2,
        ];
    }
}
