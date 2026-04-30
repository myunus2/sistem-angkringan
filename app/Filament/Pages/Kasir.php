<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Order;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class Kasir extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationLabel = 'Kasir';
    protected static ?string $title = 'Kasir';

    protected string $view = 'filament.pages.kasir';

    public $search = '';
    public $cart = [];
    // 1. Tambahkan properti untuk kategori aktif
    public $activeCategory = 'Semua';

    // 2. Fungsi untuk mengubah kategori saat tombol diklik
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

        DB::transaction(function () {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $this->total,
                'status' => 'done',
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'completed_at' => now(),
            ]);

            foreach ($this->cart as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                ]);
            }
        });

        $this->cart = [];
        Notification::make()->title('Transaksi Berhasil Disimpan!')->success()->send();
    }

    // 3. Perbarui pengambilan data agar mendukung filter kategori
    protected function getViewData(): array
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->activeCategory !== 'Semua') {
            // Pastikan kolom di database kamu namanya 'category'
            $query->where('category', $this->activeCategory);
        }

        return [
            'products' => $query->get(),
            // Daftar kategori yang akan muncul sebagai tombol
            'categories' => ['Semua', 'Makanan', 'Minuman', 'Snack'],
        ];
    }
    // Fungsi untuk menambah jumlah qty
public function incrementQty($productId)
{
    if (isset($this->cart[$productId])) {
        $this->cart[$productId]['qty']++;
    }
}

// Fungsi untuk mengurangi jumlah qty
public function decrementQty($productId)
{
    if (isset($this->cart[$productId])) {
        if ($this->cart[$productId]['qty'] > 1) {
            $this->cart[$productId]['qty']--;
        } else {
            // Jika qty tinggal 1 dan dikurangi, maka hapus dari keranjang
            $this->removeItem($productId);
        }
    }
}
}