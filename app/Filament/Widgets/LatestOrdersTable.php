<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\Transaksi;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class LatestOrdersTable extends TableWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';

    protected int | string | array $columnSpan = ['default' => 'full', 'xl' => 1];

    #[On('echo:orders,OrderCreated')]
    public function refresh(): void
    {
        // This will trigger a re-render of the table
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getLatestOrdersQuery())
            ->defaultPaginationPageOption(5)
            ->recordClasses(fn (Order $record) => 
                $record->created_at->gt(now()->subMinutes(1)) ? 'animate-pulse-orange' : null
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('table_number')
                    ->label('Meja')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                ->label('Pembayaran')
                ->badge()
                ->color(fn (?string $state): string => $state === 'paid' ? 'info' : 'danger') // ✅ color SEBELUM format
                ->formatStateUsing(fn (?string $state): string => $state === 'paid' ? 'Dibayar' : 'Belum Dibayar'),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (?string $state): string => match ($state) { // ✅ color SEBELUM format
                    'pending' => 'warning',
                    'ready' => 'info',
                    'done' => 'info',
                    'cancelled' => 'danger',
                    default => 'gray',
                })
                ->formatStateUsing(fn (?string $state): string => match ($state) {
                    'pending' => 'Pending',
                    'ready' => 'Siap',
                    'done' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default => $state ?? '-',
                }),
            ])
            ->actions([
                Action::make('edit')
                    ->label('Ubah')
                    ->icon('heroicon-o-pencil-square')
                    ->iconButton()
                    ->tooltip('Ubah data pesanan')
                    ->url(fn (): string => Transaksi::getUrl()),
                Action::make('view')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->iconButton()
                    ->color('info')
                    ->tooltip('Lihat detail pesanan')
                    ->url(fn (): string => Transaksi::getUrl()),
            ]);
    }

    protected function getLatestOrdersQuery(): Builder
    {
        return Order::query()->latest('created_at');
    }
}