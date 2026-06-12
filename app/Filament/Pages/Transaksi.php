<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Url;

class Transaksi extends Page
{
    protected static ?string $title = 'Transaksi';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected string $view = 'filament.pages.transaksi';

    public ?int $selectedOrderId = null;

    public string $paymentMethod = 'cash';

    public int|string|null $cash = null;

    public bool $showPaymentResult = false;

    public bool $mobileDetailOpen = false;

    #[Url]
    public string $statusFilter = 'all';

    public function mount(): void
    {
        $this->selectedOrderId = null;

        $this->syncPaymentState();
    }

    public function getHeading(): string | Htmlable | null
    {
        return 'Transaksi';
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

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }

    protected function getViewData(): array
    {
        return [
            'orders' => $this->orders,
            'selectedOrder' => $this->selectedOrder,
            'change' => $this->change,
            'showPaymentResult' => $this->showPaymentResult,
            'mobileDetailOpen' => $this->mobileDetailOpen,
        ];
    }

    public function getOrdersProperty(): Collection
    {
        return Order::query()
            ->with(['items.product'])
            ->where('status', 'done')
            ->when(
                $this->statusFilter === 'unpaid',
                fn ($query) => $query->where('payment_status', 'unpaid'),
            )
            ->when(
                $this->statusFilter === 'paid',
                fn ($query) => $query->where('payment_status', 'paid'),
            )
            ->latest('created_at')
            ->limit(80)
            ->get();
    }

    public function getSelectedOrderProperty(): ?Order
    {
        if (! $this->selectedOrderId) {
            return null;
        }

        return Order::query()
            ->with(['items.product'])
            ->find($this->selectedOrderId);
    }

    public function getChangeProperty(): float
    {
        $order = $this->selectedOrder;

        if (! $order) {
            return 0;
        }

        return $this->parseCurrency($this->cash) - (float) $order->total_price;
    }

    public function selectOrder(int $orderId): void
    {
        $this->selectedOrderId = $orderId;
        $this->syncPaymentState();
        $this->mobileDetailOpen = true;
    }

    public function updatedStatusFilter(): void
    {
        $this->selectedOrderId = null;
        $this->syncPaymentState();
        $this->mobileDetailOpen = false;
    }

    public function closeMobileDetail(): void
    {
        $this->mobileDetailOpen = false;
    }

    public function finishCashInput(int|string|null $value): void
    {
        $this->cash = (string) (int) $this->parseCurrency($value);
        $this->showPaymentResult = true;
    }

    public function paySelected(): void
    {
        $order = $this->selectedOrder;

        if (! $order) {
            return;
        }

        $paid = $this->parseCurrency($this->cash);

        if ($paid < (float) $order->total_price) {
            Notification::make()
                ->title('Nominal pembayaran kurang')
                ->body('Jumlah dibayar harus sama dengan atau lebih dari total pesanan.')
                ->danger()
                ->send();

            return;
        }

        $order->update([
            'payment_method' => $this->paymentMethod,
            'cash' => (int) $paid,
            'payment_status' => 'paid',
            'status' => 'done',
            'completed_at' => $order->completed_at ?: now(),
        ]);

        Notification::make()
            ->title('Pembayaran berhasil disimpan')
            ->body('Kembalian: Rp ' . number_format($this->change, 0, ',', '.'))
            ->success()
            ->send();

        $this->syncPaymentState();
    }

    public function confirmSelected(): void
    {
        $order = $this->selectedOrder;

        if (! $order) {
            return;
        }

        $order->update([
            'status' => 'done',
            'completed_at' => $order->completed_at ?: now(),
        ]);

        Notification::make()
            ->title('Pesanan dikonfirmasi')
            ->success()
            ->send();
    }

    public function deleteSelected(): void
    {
        $order = $this->selectedOrder;

        if (! $order) {
            return;
        }

        $order->delete();

        $this->selectedOrderId = $this->orders->first()?->id;
        $this->syncPaymentState();
        $this->mobileDetailOpen = false;

        Notification::make()
            ->title('Pesanan dihapus')
            ->success()
            ->send();
    }

    protected function syncPaymentState(): void
    {
        $order = $this->selectedOrder;

        if (! $order) {
            $this->paymentMethod = 'cash';
            $this->cash = '0';
            $this->showPaymentResult = false;

            return;
        }

        $this->paymentMethod = $order->payment_method ?: 'cash';
        $this->cash = (string) ($order->cash ?: 0);
        $this->showPaymentResult = $order->payment_status === 'paid';
    }

    protected function parseCurrency(int|string|null $value): float
    {
        return (float) preg_replace('/[^0-9]/', '', (string) $value);
    }

}
