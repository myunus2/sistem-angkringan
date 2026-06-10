<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminSalesChart;
<<<<<<< HEAD
use App\Filament\Widgets\AdminOrderCountChart;
=======
use App\Filament\Widgets\AdminOrderChart;
>>>>>>> 2292e59c6dfba701eae5cbd6fab8c6367bd7b54f
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\FavoriteMenusTable;
use App\Filament\Widgets\LatestOrdersTable;


class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard Admin';

    public function getWidgets(): array
    {
        return [
<<<<<<< HEAD
            AdminStatsOverview::class,
            AdminSalesChart::class,
            AdminOrderCountChart::class,
            FavoriteMenusTable::class,
            LatestOrdersTable::class,
        ];
=======
    AdminStatsOverview::class,
    AdminSalesChart::class,
    AdminOrderChart::class,
    FavoriteMenusTable::class,
    LatestOrdersTable::class,
];
>>>>>>> 2292e59c6dfba701eae5cbd6fab8c6367bd7b54f
    }

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
<<<<<<< HEAD
=======
            'md' => 2,
>>>>>>> 2292e59c6dfba701eae5cbd6fab8c6367bd7b54f
            'xl' => 2,
        ];
    }
}
