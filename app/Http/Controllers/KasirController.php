<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'semua') {
            $query->where('type', $request->category);
        }

        $products = $query
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('order.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        // 🔍 DEBUG (aktifkan kalau masih error)
        // dd($request->all());

        if (!$request->cart || count($request->cart) == 0) {
            return response()->json(['error' => 'Cart kosong'], 400);
        }

        $cash = $request->cash ?? 0;

        // 🔥 SIMPAN ORDER
        $order = Order::create([
            'customer_name'  => $request->customer_name ?? null,
            'table_number'   => $request->table ?? '-',
            'cash'           => (int) $cash, // FIX HARD
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'status'         => 'done',
        ]);

        $total = 0;

        foreach ($request->cart as $item) {

            $product = Product::find($item['id']);
            if (!$product) continue;

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'price'      => $product->price,
                'quantity'   => $item['qty'],
            ]);

            $total += $product->price * $item['qty'];
        }

        $order->update([
            'total_price' => $total
        ]);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'cash' => $cash,
            'total' => $total
        ]);
    }
}
