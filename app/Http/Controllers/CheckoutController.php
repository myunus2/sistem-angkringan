<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Jobs\SendWhatsAppNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Halaman checkout
     */
    public function index(Request $request)
    {
        $paymentMethods = PaymentMethod::where('is_active', true)->get()->groupBy('type');
        return view('checkout.index', compact('paymentMethods'));
    }

    /**
     * Proses order dari customer
     */
    public function store(Request $request)
    {
        // NOTE: frontend `resources/views/order/index.blade.php` mengirim payload:
        // {
        //   customer_name, phone, table_number, notes,
        //   items: [{ id, name, price, qty, image, ... }]
        // }
        // Jadi backend harus menyesuaikan skema input.
        $request->validate([
            'customer_name' => 'nullable|string|max:100',
            'phone'          => 'required|string|max:30',
            'table_number'  => 'required|string|max:20',
            'notes'          => 'nullable|string|max:500',
            'items'         => 'required|array|min:1',
            'items.*.id'    => 'required|exists:products,id',
            'items.*.qty'   => 'required|integer|min:1',
        ], [
            'table_number.required' => 'Nomor meja wajib diisi.',
            'phone.required'        => 'Nomor HP wajib diisi.',
            'items.required'        => 'Keranjang belanja kosong.',
            'items.min'             => 'Minimal 1 item harus dipesan.',
        ]);


        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                // payload dari frontend: { id, qty, ... }
                $productId = $item['id'] ?? null;
                $qty = $item['qty'] ?? 0;

                $product = Product::findOrFail($productId);
                $subtotal = $product->price * $qty;
                $totalPrice += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $product->price,
                ];
            }


            $order = Order::create([
                'customer_name'  => $request->customer_name,
                'phone'          => $request->phone,
                'table_number'   => $request->table_number,
                'notes'          => $request->notes,
                // Default untuk order online (sesuai kebutuhan pending order)
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'total_price'    => $totalPrice,
                'status'         => 'pending',
            ]);


            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            // Upload bukti bayar jika ada (untuk transfer/ewallet)
            if ($request->hasFile('proof_of_payment')) {
                $path = $request->file('proof_of_payment')->store('proofs', 'public');
                $order->update([
                    'proof_of_payment' => $path,
                    'payment_status'   => 'paid',
                ]);
            }

            DB::commit();

            // 🔥 Dispatch Event untuk Real-time & Job untuk WhatsApp (Wrapped in try-catch)
            try {
                event(new OrderCreated($order));
                dispatch(new SendWhatsAppNotification($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Real-time or WhatsApp notification failed: ' . $e->getMessage());
            }

            // Endpoint /api/checkout mengharapkan JSON.
            // Frontend mengirim Accept: application/json, tapi beberapa setting Laravel bisa membuat expects/wantsJson tidak terdeteksi.
            // Jadi pakai deteksi path juga.
            if (
                $request->expectsJson() ||
                $request->wantsJson() ||
                $request->is('api/checkout')
            ) {
                return response()->json([
                    'status'   => 'success',
                    'message'  => 'Pesanan berhasil dibuat.',
                    'order_id' => $order->id,
                    'total'    => $totalPrice,
                ], 200);
            }

            return redirect()->route('checkout.success', $order->id);


        } catch (\Exception $e) {
            DB::rollBack();

            if (
                $request->expectsJson() ||
                $request->wantsJson() ||
                $request->is('api/checkout')
            ) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Gagal membuat pesanan: ' . $e->getMessage(),
                ], 500);
            }


            return back()->withErrors(['error' => 'Gagal membuat pesanan. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Halaman sukses setelah order
     */
    public function success(Order $order)
    {
        $order->load('items.product');
        return view('checkout.success', compact('order'));
    }
}
