<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
// PERBAIKAN FATAL: Di Filament v5+, Action diimport dari Filament\Actions
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
                    // Jika ingin gambar bisa diklik dan memperbesar/buka di tab baru:
                    ->openUrlInNewTab()
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
                TextColumn::make('composition')
                    ->label('Komposisi')
                    ->limit(20)
                    ->tooltip(fn ($record) => $record->composition),

                // 5. Deskripsi
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->description),
                        
            ])
            ->filters([
                SelectFilter::make('type')
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
            ->bulkActions([ 
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}