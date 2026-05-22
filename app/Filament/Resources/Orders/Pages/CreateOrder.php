<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'pending';

        return OrderResource::mutateOrderData($data);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->record]);
    }

    protected function afterCreate(): void
    {
        OrderResource::syncOrderTotals($this->record);
    }
}
