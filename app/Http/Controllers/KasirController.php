<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class KasirController extends Controller
{
    // Tampilkan halaman kasir
    public function index()
    {
        $products = Product::all();
        return view('kasir', compact('products'));
    }

    // Proses checkout kasir
    public function checkout(Request $r)
    {
        // Validasi sederhana
        if (!$r->cart || count($r->cart) == 0) {
            return response()->json(['error' => 'Cart kosong'], 400);
        }

        // Simpan order
        $order = Order::create([
            'customer_name' => null,
            'table_number' => $r->table ?? '-',
            'payment_method' => $r->payment ?? 'cash',
            'payment_status' => 'paid',
            'status' => 'done',
        ]);

        $total = 0;

        foreach ($r->cart as $item) {
            $product = Product::find($item['id']);

            if (!$product) continue;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $item['qty'],
            ]);

            $total += $product->price * $item['qty'];
        }

        // Update total
        $order->update([
            'total_price' => $total
        ]);

        return response()->json([
            'success' => true,
            'id' => $order->id
        ]);
    }
}