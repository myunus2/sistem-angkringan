<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;

class OrderReceiptController extends Controller
{
    public function show(Order $order): View
    {
        $order->loadMissing('items.product');

        return view('admin.orders.receipt', [
            'order' => $order,
        ]);
    }
}
