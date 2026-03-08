<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
   // 1. Menampilkan menu untuk pelanggan
public function index(Request $request)
{
    $category = $request->query('category');
    $search = $request->query('search'); // Ambil input pencarian

    $query = Product::query()->where('stock', '>', 0);

    // Filter berdasarkan Kategori
    if ($category && $category !== 'semua') {
        $query->where('type', $category);
    }

    // Filter berdasarkan Nama (Pencarian)
    if ($search) {
        $query->where('name', 'like', '%' . $search . '%');
    }

    $products = $query->get();
    
    // Ambil data payment methods untuk ditampilkan ke frontend
    $paymentMethods = PaymentMethod::where('is_active', true)->get();
    $bankAccounts = $paymentMethods->where('type', 'bank')->values();
    $ewalletAccounts = $paymentMethods->where('type', 'ewallet')->values();

    return view('order.index', compact('products', 'bankAccounts', 'ewalletAccounts')); 
}
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validationRules = [
                'customer_name' => 'required|string|max:100',
                'table_number' => 'required|string|max:50',
                'payment_method' => 'required|in:transfer_bank,e_wallet,cash',
                'total_price' => 'required|numeric|min:0',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|integer|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
            ];

            // Jika payment method bank atau ewallet, wajib upload bukti
            if (in_array($request->payment_method, ['transfer_bank', 'e_wallet'])) {
                $validationRules['proof_of_payment'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120'; // Max 5MB
            }

            $validated = $request->validate($validationRules);

            // Gunakan Database Transaction agar jika satu gagal, semua batal (aman untuk stok)
            DB::transaction(function () use ($request, $validated) {
                
                // Handle upload bukti pembayaran
                $proofPath = null;
                if ($request->hasFile('proof_of_payment')) {
                    $proofPath = $request->file('proof_of_payment')->store('payment_proofs', 'public');
                }

                // Buat data pesanan utama
                $order = Order::create([
                    'customer_name' => $validated['customer_name'],
                    'table_number' => $validated['table_number'],
                    'payment_method' => $validated['payment_method'],
                    'total_price' => $validated['total_price'],
                    'status' => 'pending',
                    'proof_of_payment' => $proofPath
                ]);

                // Loop setiap item yang dibeli
                foreach ($validated['items'] as $item) {
                    $product = Product::find($item['product_id']);

                    // Validasi stok sekali lagi
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi! Stok tersedia: {$product->stock}");
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

            return response()->json([
                'message' => 'Pesanan berhasil dibuat! Silakan tunggu di meja.',
                'success' => true
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true
            ], 400);
        }
    }
}