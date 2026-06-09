<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        
            ->columns([
                
                // 0. Menampilkan Gambar Produk
                ImageColumn::make('images')
                    ->label('Gambar')
                    ->disk('public')
                    ->url(fn ($state) => $state ? asset('storage/' . $state) : null)
                    ->width(80)
                    ->height(80),

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

                TextColumn::make('model_3d')
                    ->label('Model 3D')
                    ->formatStateUsing(fn (?string $state): string => $state ? 'Tersedia' : 'Belum ada')
                    ->badge()
                    ->color(fn (?string $state): string => $state ? 'success' : 'gray'),
                    // 4. Komposisi
                    TextColumn::make('komposisi')
                        ->label('Komposisi')
                        ->limit(20)
                        ->tooltip(fn ($record) => $record->komposisi),

                    // 5. Deskripsi
                    TextColumn::make('deskripsi')
                        ->label('Deskripsi')
                        ->limit(30)
                        ->tooltip(fn ($record) => $record->deskripsi),
                        
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('type')
                    ->label('Filter Tipe')
            ->options([
            'makanan' => 'Makanan',
            'minuman' => 'Minuman',
            'snack' => 'Snack',
        ])

            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([ // Gunakan bulkActions, bukan toolbarActions untuk Delete
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
