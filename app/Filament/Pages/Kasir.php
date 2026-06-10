<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Order;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\DB;

class Kasir extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Pesanan';
    protected static ?string $title = 'Pesanan';

    protected string $view = 'filament.pages.kasir';

    public $search = '';
    public $cart = [];
    public $customerName = '';
    public $tableNumber = '';
    
    // 🔥 1. Tambahkan Properti Livewire Baru untuk No HP dan Notes Kasir
    public $phone = '';
    public $notes = '';
    
    public $activeCategory = 'Semua';

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }

    public function setCategory($category)
    {
        $this->activeCategory = $category;
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['qty']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
                'image' => $product->image_url,
            ];
        }
    }

    public function removeItem($productId)
    {
        unset($this->cart[$productId]);
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['qty']);
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            Notification::make()->title('Keranjang Kosong')->danger()->send();
            return;
        }

        if (!trim($this->customerName) || !trim($this->tableNumber)) {
            Notification::make()->title('Nama dan nomor meja wajib diisi')->danger()->send();
            return;
        }

        DB::transaction(function () {
            // 🔥 2. Simpan Data ke Tabel Orders (Termasuk phone, notes, dan order_type => 'manual')
            $order = Order::create([
                'customer_name'  => $this->customerName,
                'table_number'   => $this->tableNumber,
                'phone'          => $this->phone ? trim($this->phone) : null, // Masukkan No HP
                'notes'          => $this->notes ? trim($this->notes) : null, // Masukkan Catatan Kasir
                'total_price'    => $this->total,
                'status'         => 'pending',
                'order_type'     => 'manual', // Menandakan pesanan langsung diinput manual oleh Kasir
                'payment_status' => 'unpaid',
                'payment_method' => 'cash',
            ]);

            foreach ($this->cart as $item) {
                // 🔥 3. Sinkronisasi kolom 'qty' agar sesuai dengan migrasi order_items Anda
                $order->items()->create([
                    'product_id' => $item['id'],
                    'name'       => $item['name'], // Pastikan nama produk ikut tersimpan ke item pesanan
                    'quantity'   => $item['qty'],  // Kolom di tabel order_items adalah `quantity` (sesuai migrasi)
                    'price'      => $item['price'],
                ]);
            }
        });

        // 🔥 4. Reset Seluruh State Inputan Form Menjadi Kosong Kembali
        $this->cart = [];
        $this->customerName = '';
        $this->tableNumber = '';
        $this->phone = '';
        $this->notes = '';
        
        Notification::make()->title('Transaksi Berhasil Disimpan!')->success()->send();
    }

    protected function getViewData(): array
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->activeCategory !== 'Semua') {
            $query->where('type', $this->activeCategory);
        }

        return [
            'products' => $query
                ->select(['id', 'name', 'price', 'type', 'description', 'image', 'model_3d'])
                ->simplePaginate(36)
                ->withQueryString(),
            'categories' => ['Semua', 'makanan', 'minuman', 'snack'],
        ];
    }

    public function incrementQty($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['qty']++;
        }
    }

    public function decrementQty($productId)
    {
        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['qty'] > 1) {
                $this->cart[$productId]['qty']--;
            } else {
                $this->removeItem($productId);
            }
        }
    }
}