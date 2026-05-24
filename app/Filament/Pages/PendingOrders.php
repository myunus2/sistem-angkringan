<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class PendingOrders extends Page implements HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $title = 'Pesanan Pending';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->mountInteractsWithTable();
    }

    public function getHeading(): string | Htmlable | null
    {
        return 'Pesanan yang Masih Pending';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->with(['items.product'])
                    ->where('status', 'pending')
                    ->latest('created_at')
            )
            ->description(fn (): string => 'Jumlah pesanan pending: ' . number_format(Order::query()->where('status', 'pending')->count()))
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items_summary')
                    ->label('Pesanan')
                    ->state(fn (Order $record): string => $record->items
                        ->map(fn ($item): string => ($item->product?->name ?? 'Produk dihapus') . ' x' . $item->quantity)
                        ->join(', '))
                    ->wrap()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('table_number')
                    ->label('No Meja')
                    ->placeholder('-'),
            ])
            ->actions([
                Action::make('confirm')
                    ->label('Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Order $record): void {
                        $record->update([
                            'status' => 'done',
                            'completed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pesanan dikonfirmasi dan dipindah ke total pesanan')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation(),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            EmbeddedTable::make(),
        ]);
    }
}
