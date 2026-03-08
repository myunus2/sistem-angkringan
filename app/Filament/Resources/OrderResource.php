<?php

namespace App\Filament\Resources;

use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?string $navigationLabel = 'Pesanan';

    protected static ?string $pluralModelLabel = 'Pesanan';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            // Form fields will be added here if needed
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('table_number')
                    ->label('Nomor Meja')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jumlah Item')
                    ->counts('items')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('payment_method')
                    ->label('Metode Bayar')
                    ->colors([
                        'info' => 'transfer_bank',
                        'success' => 'e_wallet',
                        'warning' => 'cash',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'transfer_bank' => '🏦 Transfer Bank',
                        'e_wallet' => '💰 E-Wallet',
                        'cash' => '💵 Tunai',
                        default => $state
                    }),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total (Rp)')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'pending' => 'Menunggu ⏳',
                        'completed' => 'Selesai ✓',
                        'cancelled' => 'Dibatalkan ✗',
                        default => $state
                    }),

                Tables\Columns\ImageColumn::make('proof_of_payment')
                    ->label('Bukti Bayar')
                    ->visibility('public'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Pesan')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'transfer_bank' => 'Transfer Bank',
                        'e_wallet' => 'E-Wallet',
                        'cash' => 'Uang Tunai',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\OrderResource\Pages\ListOrders::route('/'),
            'edit' => \App\Filament\Resources\OrderResource\Pages\EditOrder::route('/{record}/edit'),
            'view' => \App\Filament\Resources\OrderResource\Pages\ViewOrder::route('/{record}'),
        ];
    }
}
