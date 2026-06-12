<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;

class PendingOrders extends Page
{
    protected static ?string $title = 'Pesanan Pending';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected string $view = 'filament.pages.pending-orders';

    protected static bool $shouldRegisterNavigation = false;

    public ?int $selectedOrderId = null;

    public function mount(): void
    {
        $this->selectedOrderId = null;
    }

    public function getHeading(): string | Htmlable | null
    {
        return 'Pesanan Pending';
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
        ];
    }

    public function getOrdersProperty(): Collection
    {
        return Order::query()
            ->with(['items.product'])
            ->where('status', 'pending')
            ->latest('created_at')
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

    public function selectOrder(int $orderId): void
    {
        if ($this->selectedOrderId === $orderId) {
            $this->selectedOrderId = null;
        } else {
            $this->selectedOrderId = $orderId;
        }
    }

    #[On('echo:orders,OrderCreated')]
    public function handleOrderCreated(): void
    {
        // Refresh orders
    }

    public function confirmOrder(int $orderId): void
    {
        $order = Order::find($orderId);

        if (! $order) {
            return;
        }

        $order->update([
            'status' => 'done',
            'completed_at' => now(),
        ]);

        if ($this->selectedOrderId === $orderId) {
            $this->selectedOrderId = null;
        }

        Notification::make()
            ->title('Pesanan Selesai')
            ->body('Pesanan telah dikonfirmasi dan dipindahkan ke transaksi.')
            ->success()
            ->send();
    }

    public function deleteOrder(int $orderId): void
    {
        $order = Order::find($orderId);

        if (! $order) {
            return;
        }

        $order->delete();

        if ($this->selectedOrderId === $orderId) {
            $this->selectedOrderId = null;
        }

        Notification::make()
            ->title('Pesanan Dihapus')
            ->success()
            ->send();
    }
}
