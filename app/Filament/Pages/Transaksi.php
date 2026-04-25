<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class Transaksi extends Page implements HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $title = 'Transaksi';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    public function mount(): void
    {
        $this->mountInteractsWithTable();
    }

    public function getHeading(): string | Htmlable | null
    {
        return 'Semua Transaksi';
    }

    public static function getNavigationLabel(): string
    {
        return 'Transaksi';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->whereIn('status', ['pending', 'done'])
                    ->latest('created_at')
            )
            ->description(fn (): string => 'Menampilkan semua transaksi dengan status pending dan selesai.')
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('table_number')
                    ->label('Meja')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'paid' ? 'Dibayar' : 'Belum Dibayar')
                    ->color(fn (string $state): string => $state === 'paid' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'done' => 'Selesai',
                        default => str($state)->headline()->toString(),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'done' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'done' => 'Selesai',
                    ]),
            ])
            ->actions([
                Action::make('change_payment')
                    ->label('Ubah Pembayaran')
                    ->icon('heroicon-o-credit-card')
                    ->color('info')
                    ->fillForm(fn (Order $record): array => [
                        'payment_status' => $record->payment_status,
                    ])
                    ->schema([
                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'unpaid' => 'Belum Dibayar',
                                'paid' => 'Dibayar',
                            ])
                            ->native(false)
                            ->required(),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $isPaid = ($data['payment_status'] ?? 'unpaid') === 'paid';

                        $record->update([
                            'payment_status' => $data['payment_status'],
                            'payment_method' => $isPaid ? ($record->payment_method ?: 'cash') : null,
                        ]);

                        Notification::make()
                            ->title('Status pembayaran berhasil diubah')
                            ->success()
                            ->send();
                    }),
                Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Order $record): bool => $record->status === 'pending')
                    ->action(function (Order $record): void {
                        $record->update([
                            'status' => 'done',
                            'completed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Transaksi dipindahkan ke pesanan selesai')
                            ->success()
                            ->send();
                    }),
                Action::make('print_receipt')
                    ->label('Cetak Struk')
                    ->icon('heroicon-o-printer')
                    ->color('warning')
                    ->url(fn (Order $record): string => '/admin/order-receipts/' . $record->id)
                    ->openUrlInNewTab(),
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