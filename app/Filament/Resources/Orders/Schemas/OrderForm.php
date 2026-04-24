<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Product;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\Alignment;

class OrderForm
{
    public static function configure($form)
    {
        return $form
            ->schema([
                Section::make('Informasi Pemesan')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Nama Pemesan')
                            ->required()
                            ->placeholder('Masukkan nama user'),
                        TextInput::make('table_number')
                            ->label('Nomor Meja')
                            ->placeholder('Contoh: 03'),
                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'unpaid' => 'Belum Dibayar',
                                'paid' => 'Dibayar Langsung',
                            ])
                            ->default('unpaid')
                            ->native(false)
                            ->required(),
                        TextInput::make('status')
                            ->label('Status Pesanan')
                            ->default('pending')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Section::make('Menu yang Dipesan')
                    ->description('Admin memilih menu yang dipesan user beserta jumlahnya.')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->label('Daftar Menu')
                            ->helperText('Satu pesanan bisa berisi banyak menu. Klik tombol "Tambah Menu" untuk menambahkan menu lain.')
                            ->defaultItems(1)
                            ->minItems(1)
                            ->addActionLabel('Tambah Menu')
                            ->addActionAlignment(Alignment::Start)
                            ->itemLabel(function (array $state): ?string {
                                $productId = $state['product_id'] ?? null;
                                $quantity = (int) ($state['quantity'] ?? 0);

                                if (! $productId) {
                                    return 'Menu baru';
                                }

                                $productName = Product::query()->find($productId)?->name;

                                if (! $productName) {
                                    return 'Menu baru';
                                }

                                return $quantity > 0
                                    ? "{$productName} x {$quantity}"
                                    : $productName;
                            })
                            ->table([
                                TableColumn::make('Menu')->markAsRequired(),
                                TableColumn::make('Jumlah')->markAsRequired()->width('120px'),
                            ])
                            ->schema([
                                Select::make('product_id')
                                    ->label('Menu')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->native(false)
                                    ->live(),
                                TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->live(),
                                Hidden::make('price'),
                            ])
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $data['price'] = Product::query()->find($data['product_id'] ?? null)?->price ?? 0;

                                return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                $data['price'] = Product::query()->find($data['product_id'] ?? null)?->price ?? 0;

                                return $data;
                            })
                            ->columnSpanFull(),

                        Placeholder::make('total_preview')
                            ->label('Estimasi Total')
                            ->state(function (Get $get): string {
                                $total = OrderResource::calculateTotalFromItems($get('items') ?? []);

                                return 'Rp ' . number_format($total, 0, ',', '.');
                            }),

                        Placeholder::make('admin_flow')
                            ->label('Alur Admin')
                            ->state('Pesanan baru otomatis Pending. Jika pembayaran sudah diterima, admin bisa Cetak Struk lalu menandai pesanan sebagai Selesai.'),
                    ]),
            ]);
    }
}
