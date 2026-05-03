<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'customer_name'  => 'nullable|string|max:100',
            'table_number'   => 'required|string|max:20',
            'payment_method' => 'required|in:cash,transfer_bank,e_wallet',
            'items'          => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ], [
            'table_number.required'   => 'Nomor meja wajib diisi.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'items.required'          => 'Keranjang belanja kosong.',
            'items.min'               => 'Minimal 1 item harus dipesan.',
        ]);

        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalPrice += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ];
            }

            $order = Order::create([
                'customer_name'  => $request->customer_name,
                'table_number'   => $request->table_number,
                'payment_method' => $request->payment_method,
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

            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
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