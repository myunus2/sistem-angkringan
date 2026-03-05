<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
   // 1. Menampilkan menu untuk pelanggan
public function index() // <-- Hapus ($table_number) di sini
{
    $products = Product::where('stock', '>', 0)->get(); 
    
    // Kirim ke view tanpa variabel table_number karena nanti diisi pelanggan di form
    return view('order.index', compact('products')); 
}

    // 2. Memproses pesanan pelanggan
    public function store(Request $request)
    {
        // Gunakan Database Transaction agar jika satu gagal, semua batal (aman untuk stok)
        DB::transaction(function () use ($request) {
            
            // Buat data pesanan utama
            $order = Order::create([
                'table_number' => $request->table_number,
                'total_price' => $request->total_price,
                'status' => 'pending'
            ]);

            // Loop setiap item yang dibeli
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                // Validasi stok sekali lagi
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi!");
                }

                // KURANGI STOK DI DATABASE
                $product->decrement('stock', $item['quantity']);

                // Simpan detail pesanan
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ]);
            }
        });

        return response()->json(['message' => 'Pesanan berhasil! Silakan tunggu di meja.']);
    }
}