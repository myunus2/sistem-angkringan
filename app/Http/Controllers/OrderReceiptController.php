<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderReceiptController extends Controller
{
    public function show(Order $order)
    {
        $order->load('items.product');

        return view('admin.orders.receipt', compact('order'));
    }
}
