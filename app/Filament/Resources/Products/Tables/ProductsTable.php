<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Menampilkan Nama Produk
                TextColumn::make('name')
                    ->label('Nama Menu')
                    ->searchable()
                    ->sortable(),

                // 2. Menampilkan Harga dengan format Rupiah
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                // 3. Menampilkan Stok
                TextColumn::make('stock')
                    ->label('Stok Tersedia')
                    ->badge() // Membuat tampilan stok seperti label/badge
                    ->color(fn (int $state): string => $state <= 5 ? 'danger' : 'success') // Merah jika stok <= 5
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([ // Gunakan bulkActions, bukan toolbarActions untuk Delete
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}