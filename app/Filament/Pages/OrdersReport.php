<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Support\SimplePdfExport;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class OrdersReport extends Page implements HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $title = 'Detail Total Pesanan';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->mountInteractsWithTable();
    }

    public function getHeading(): string | Htmlable | null
    {
        return 'Semua Pesanan';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action('exportPdf'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getFilteredOrdersQuery())
            ->defaultSort('created_at', 'desc')
            ->description(fn (): string => 'Total pesanan pada filter ini: ' . number_format($this->getFilteredOrdersCount()))
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('table_number')
                    ->label('Meja')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Pembayaran')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'transfer_bank' => 'Transfer Bank',
                        'e_wallet' => 'E-Wallet',
                        'cash' => 'Cash',
                        default => '-',
                    }),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'ready' => 'Siap',
                        'done' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => str($state)->headline()->toString(),
                    })
                    ->color(fn (string $state): string => match ($state) {
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
            ])
            ->filters([
                Filter::make('created_at')
                    ->label('Filter Tanggal')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $this->applyDateFilter($query, $data);
                    }),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            EmbeddedTable::make(),
        ]);
    }

    public function exportPdf()
    {
        $orders = $this->getFilteredOrdersQuery()->get();
        $lines = [];

        foreach ($orders as $index => $order) {
            $lines[] = sprintf(
                '%d. %s | Meja %s | %s | Rp %s | %s | %s',
                $index + 1,
                $order->customer_name ?: '-',
                $order->table_number ?: '-',
                $this->formatPaymentMethod($order->payment_method),
                number_format((float) $order->total_price, 0, ',', '.'),
                $this->formatStatus($order->status),
                $order->created_at?->format('d-m-Y H:i') ?? '-',
            );
        }

        if ($lines === []) {
            $lines[] = 'Tidak ada data pesanan untuk filter tanggal yang dipilih.';
        }

        $lines[] = '';
        $lines[] = 'Total pesanan: ' . number_format($orders->count());

        return SimplePdfExport::download(
            'laporan-total-pesanan.pdf',
            'Laporan Total Pesanan',
            $lines,
        );
    }

    protected function getFilteredOrdersQuery(): Builder
    {
        $query = Order::query();

        return $this->applyDateFilter($query, $this->getDateFilterData())
            ->latest('created_at');
    }

    protected function getFilteredOrdersCount(): int
    {
        return (clone $this->getFilteredOrdersQuery())->count();
    }

    protected function getDateFilterData(): array
    {
        return $this->tableFilters['created_at'] ?? [];
    }

    protected function applyDateFilter(Builder $query, array $data): Builder
    {
        return $query
            ->when(
                $data['created_from'] ?? null,
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
            )
            ->when(
                $data['created_until'] ?? null,
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
            );
    }

    protected function formatPaymentMethod(?string $state): string
    {
        return match ($state) {
            'transfer_bank' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'cash' => 'Cash',
            default => '-',
        };
    }

    protected function formatStatus(string $state): string
    {
        return match ($state) {
            'pending' => 'Pending',
            'ready' => 'Siap',
            'done' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => str($state)->headline()->toString(),
        };
    }
}
