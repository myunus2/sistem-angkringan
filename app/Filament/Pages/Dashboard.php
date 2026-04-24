<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminSalesChart;
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\LatestOrdersTable;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard Admin';

    public function getWidgets(): array
    {
        return [
            AdminStatsOverview::class,
            AdminSalesChart::class,
            LatestOrdersTable::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 1;
    }
}
