<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print_receipt')
                ->label('Cetak Struk')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->visible(fn (): bool => $this->record->payment_status === 'paid')
                ->url(fn (): string => route('admin.orders.receipt', $this->record), shouldOpenInNewTab: true),
            Action::make('finish')
                ->label('Selesai')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (): bool => $this->record->status === 'pending' && $this->record->payment_status === 'paid')
                ->action(function (): void {
                    /** @var Order $record */
                    $record = $this->record;

                    $record->update([
                        'status' => 'done',
                        'completed_at' => now(),
                    ]);

                    $this->record = $record->fresh();

                    Notification::make()
                        ->title('Pesanan selesai dan masuk ke total pesanan')
                        ->success()
                        ->send();
                }),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return OrderResource::mutateOrderData($data);
    }

    protected function afterSave(): void
    {
        OrderResource::syncOrderTotals($this->record);
        $this->record = $this->record->fresh();
    }
}
