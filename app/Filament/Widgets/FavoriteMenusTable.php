<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FavoriteMenusTable extends Widget
{
    protected string $view = 'filament.widgets.favorite-menus-table';

    protected int | string | array $columnSpan = ['default' => 'full', 'xl' => 1];

    protected function getViewData(): array
    {
        return [
            'favoriteMenus' => $this->getFavoriteMenus(),
        ];
    }

    protected function getFavoriteMenus(): Collection
    {
        // Cache the result for 60 minutes to avoid running this heavy query on every page load.
        return cache()->remember('widget.favorite_menus', now()->addHour(), function () {
            return OrderItem::query()
                ->select('product_id')
                ->selectRaw('MIN(id) as id')
                ->selectRaw('SUM(quantity) as total_ordered')
                ->selectRaw('SUM(quantity * price) as total_revenue')
                // Perbaikan: Secara eksplisit memuat kolom yang dibutuhkan dari relasi product.
                // Ini memastikan 'image_url' accessor mendapatkan data kolom 'image'.
                ->with('product:id,name,images')
                ->whereHas('order', fn (Builder $query) => $query->where('status', 'done'))
                ->groupBy('product_id')
                ->orderByDesc('total_ordered')
                ->limit(5)
                ->get();
        });
    }
}
