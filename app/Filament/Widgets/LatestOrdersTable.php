<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrdersTable extends TableWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getLatestOrdersQuery())
            ->defaultPaginationPageOption(5)
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
                    ->formatStateUsing(fn (?string $state): string => $state === 'paid' ? 'Dibayar' : 'Belum Dibayar')
                    ->color(fn (?string $state): string => $state === 'paid' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'ready' => 'Siap',
                        'done' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => str($state)->headline()->toString(),
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'ready' => 'info',
                        'done' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ]);
    }

    protected function getLatestOrdersQuery(): Builder
    {
        return Order::query()->latest('created_at');
    }
}
