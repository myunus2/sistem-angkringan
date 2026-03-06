<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select; // Import Select
use Filament\Schemas\Components\Section;

class ProductForm
{
    public static function configure($form)
    {
        return $form
            ->schema([
                Section::make('Informasi Produk')
                    ->schema([
                        // 1. Menambahkan Dropdown Tipe Menu
                        Select::make('type')
                            ->label('Tipe Menu')
                            ->options([
                                'makanan' => 'Makanan',
                                'minuman' => 'Minuman',
                                'snack' => 'Snack',
                            ])
                            ->required()
                            ->native(false) // Membuat tampilan lebih modern
                            ->placeholder('Pilih tipe menu'),

                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->placeholder('Masukkan nama makanan/minuman'),

                        TextInput::make('price')
                            ->label('Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        TextInput::make('stock')
                            ->label('Stok')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        FileUpload::make('images')
                            ->label('Gambar Produk')
                            ->image()
                            ->disk('public')
                            ->directory('products')
                            ->visibility('public')
                            ->nullable()
                            ->columnSpanFull(), // Agar gambar mengambil baris penuh jika diinginkan
                    ])->columns(2),
            ]);
    }
}