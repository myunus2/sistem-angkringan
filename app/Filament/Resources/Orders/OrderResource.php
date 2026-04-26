<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Pesanan';

    protected static ?string $label = 'Pesanan';

    protected static ?string $pluralLabel = 'Pesanan';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }

    public static function calculateTotalFromItems(array $items): float
    {
        return collect($items)
            ->sum(function (array $item): float {
                $productId = $item['product_id'] ?? null;
                $quantity = (int) ($item['quantity'] ?? 0);
                $price = Product::query()->find($productId)?->price ?? 0;

                return (float) $price * max($quantity, 0);
            });
    }

    public static function mutateOrderData(array $data): array
    {
        $items = $data['items'] ?? [];
        $isPaid = ($data['payment_status'] ?? 'unpaid') === 'paid';

        $data['status'] ??= 'pending';
        $data['total_price'] = static::calculateTotalFromItems($items);
        $data['payment_method'] = $isPaid ? 'cash' : null;

        if (($data['status'] ?? null) !== 'done') {
            $data['completed_at'] = null;
        }

        return $data;
    }

    public static function syncOrderTotals(Order $order): void
    {
        $total = (float) $order->items()
            ->selectRaw('COALESCE(SUM(price * quantity), 0) as total')
            ->value('total');

        $order->updateQuietly([
            'total_price' => $total,
        ]);
    }
}
