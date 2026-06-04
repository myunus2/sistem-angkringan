<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FavoriteMenusTable extends Widget
{
    protected string $view = 'filament.widgets.favorite-menus-table';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    protected function getViewData(): array
    {
        return [
            'favoriteMenus' => $this->getFavoriteMenus(),
        ];
    }

    protected function getFavoriteMenus(): Collection
    {
        return OrderItem::query()
            ->select('product_id')
            ->selectRaw('MIN(id) as id')
            ->selectRaw('SUM(quantity) as total_ordered')
            ->selectRaw('SUM(quantity * price) as total_revenue')
            ->with('product')
            ->whereHas('order', fn (Builder $query) => $query->where('status', 'done'))
            ->groupBy('product_id')
            ->orderByDesc('total_ordered')
            ->limit(5)
            ->get();
    }
}
