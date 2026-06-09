<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderReceiptController extends Controller
{
    // Fungsi bawaan Anda untuk menampilkan struk/nota
    public function show(Order $order)
    {
        $order->load('items.product');

        return view('admin.orders.receipt', compact('order'));
    }

    // FUNGSI BARU: Menangani kiriman pesanan online dari web depan
    public function checkout(Request $request)
    {
        // 1. Validasi data yang dikirim oleh JavaScript
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string',
            'table_number'  => 'required|string',
            'notes'         => 'nullable|string',
            'items'         => 'required|array|min:1',
        ]);

        // 2. Gunakan DB Transaction agar proses simpan data lebih aman
        DB::beginTransaction();

        try {
            // Hitung total harga otomatis dari item yang ada di keranjang
            $calculatedTotalPrice = 0;
            foreach ($request->items as $item) {
                $calculatedTotalPrice += $item['price'] * $item['qty'];
            }

            // 3. Simpan data utama ke tabel 'orders'
            $order = Order::create([
                'customer_name'  => $validated['customer_name'],
                'phone'          => $validated['phone'], // Pastikan kolom ini ada di database/fillable
                'table_number'   => $validated['table_number'],
                'notes'          => $validated['notes'], // Pastikan kolom ini ada di database/fillable
                'total_price'    => $calculatedTotalPrice,
                'status'         => 'pending',          // Otomatis masuk ke antrean pending order
                'order_type'     => 'online',           // Menandakan pesanan ini via web online (bukan kasir manual)
                'payment_method' => 'cash',             // Default pembayaran (bisa disesuaikan nanti)
                'payment_status' => 'unpaid',           // Status pembayaran awal belum lunas
            ]);

            // 4. Simpan semua rincian menu ke tabel 'order_items' menggunakan relasi model
            foreach ($request->items as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'name'       => $item['name'],
                    'price'      => $item['price'],
                    'qty'        => $item['qty'],
                ]);
            }

            DB::commit();

            // 5. Response sukses berbentuk JSON agar loading "Memproses..." di web berhenti
            return response()->json([
                'status'  => 'success',
                'message' => 'Pesanan online Anda berhasil dikirim ke antrean pending Filament!'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memproses pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}