<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        $adminPhone = config('services.fonnte.admin_phone') ?: env('ADMIN_PHONE');
        $fonnteToken = config('services.fonnte.token') ?: env('FONNTE_TOKEN');

        if (!$adminPhone || !$fonnteToken) {
            Log::warning('WhatsApp Notification skipped: ADMIN_PHONE or FONNTE_TOKEN not set.');
            return;
        }

        // Load items if not loaded
        $this->order->load('items.product');

        $itemsText = "";
        foreach ($this->order->items as $item) {
            $itemsText .= "- " . ($item->product?->name ?? 'Produk') . " (x" . $item->quantity . ")\n";
        }

        $message = "*PESANAN BARU !* \n\n" .
                   " *Pelanggan:* " . ($this->order->customer_name ?: 'Tanpa Nama') . "\n" .
                   " *Meja:* " . ($this->order->table_number ?: '-') . "\n" .
                   " *No HP:* " . ($this->order->phone ?: '-') . "\n\n" .
                   " *Detail Pesanan:*\n" . $itemsText . "\n" .
                   " *Total Tagihan:* Rp " . number_format($this->order->total_price, 0, ',', '.') . "\n\n" .
                   "--- sistem angkringan ---";

        try {
            $response = Http::withHeaders([
                'Authorization' => $fonnteToken,
            ])->post('https://api.fonnte.com/send', [
                'target' => $adminPhone,
                'message' => $message,
                'delay' => '2',
                'countryCode' => '62', // Default Indonesia
            ]);

            if (!$response->successful()) {
                Log::error('Fonnte API Error: ' . $response->body());
            } else {
                Log::info('WhatsApp Notification sent successfully to ' . $adminPhone);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp notification: ' . $e->getMessage());
        }
    }
}
