<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Pemesan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_items')
                    ->label('Jumlah Item')
                    ->state(fn (Order $record): int => $record->items->sum('quantity')),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Dibayar',
                        default => 'Belum Dibayar',
                    })
                    ->color(fn (string $state): string => $state === 'paid' ? 'success' : 'warning'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'done' => 'Selesai',
                        'pending' => 'Pending',
                        'ready' => 'Siap',
                        'cancelled' => 'Dibatalkan',
                        default => str($state)->headline()->toString(),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'done' => 'success',
                        'pending' => 'warning',
                        'ready' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'unpaid' => 'Belum Dibayar',
                        'paid' => 'Dibayar',
                    ]),
                SelectFilter::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Pending',
                        'done' => 'Selesai',
                        'ready' => 'Siap',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                Action::make('print_receipt')
                    ->label('Cetak Struk')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->visible(fn (Order $record): bool => $record->payment_status === 'paid')
                    ->url(fn (Order $record): string => route('admin.orders.receipt', $record), shouldOpenInNewTab: true),
                Action::make('finish')
                    ->label('Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Order $record): bool => $record->status === 'pending' && $record->payment_status === 'paid')
                    ->action(function (Order $record): void {
                        $record->update([
                            'status' => 'done',
                            'completed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pesanan dipindahkan ke total pesanan')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make(),
            ]);
    }
}
