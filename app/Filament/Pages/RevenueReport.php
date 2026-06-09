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

class RevenueReport extends Page implements HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $title = 'Detail Pendapatan';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->mountInteractsWithTable();
    }

    public function getHeading(): string | Htmlable | null
    {
        return 'Laporan Pendapatan';
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
            ->query($this->getFilteredRevenueQuery())
            ->defaultSort('created_at', 'desc')
            ->description(fn (): string => 'Total pendapatan pada filter ini: Rp ' . number_format($this->getFilteredRevenueTotal(), 0, ',', '.'))
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Pendapatan')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'paid' ? 'Dibayar' : 'Belum Dibayar')
                    ->color(fn (string $state): string => $state === 'paid' ? 'success' : 'warning'),
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
        $orders = $this->getFilteredRevenueQuery()->get();
        $totalRevenue = $orders->sum('total_price');
        $lines = [];

        foreach ($orders as $index => $order) {
            $lines[] = sprintf(
                '%d. %s | Rp %s | %s | %s | %s',
                $index + 1,
                $order->customer_name ?: '-',
                number_format((float) $order->total_price, 0, ',', '.'),
                $order->payment_status === 'paid' ? 'Dibayar' : 'Belum Dibayar',
                $this->formatStatus($order->status),
                $order->created_at?->format('d-m-Y H:i') ?? '-',
            );
        }

        if ($lines === []) {
            $lines[] = 'Tidak ada data pendapatan untuk filter tanggal yang dipilih.';
        }

        $lines[] = '';
        $lines[] = 'Total pendapatan: Rp ' . number_format((float) $totalRevenue, 0, ',', '.');

        return SimplePdfExport::download(
            'laporan-pendapatan.pdf',
            'Laporan Pendapatan',
            $lines,
        );
    }

    protected function getFilteredRevenueQuery(): Builder
    {
        $query = Order::query();

        return $this->applyDateFilter($query->where('status', 'done'), $this->getDateFilterData())
            ->latest('created_at');
    }

    protected function getFilteredRevenueTotal(): float
    {
        return (float) (clone $this->getFilteredRevenueQuery())->sum('total_price');
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
