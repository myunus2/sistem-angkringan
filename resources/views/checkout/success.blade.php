<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil – Angkringan Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bounce { animation: bounce .6s ease; }
        @keyframes bounce {
            0%,100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="bg-[#F8F8F8] min-h-screen">
    <div class="max-w-lg mx-auto px-4 py-12 space-y-6">
        <div class="bg-white rounded-3xl shadow-sm p-8 text-center">
            <div class="bounce text-6xl mb-4">🎉</div>
            <h1 class="text-2xl font-extrabold text-gray-800 mb-2">Pesanan Masuk!</h1>
            <p class="text-gray-500 text-sm">Pesanan kamu sudah kami terima. Silakan tunggu, ya!</p>
            <div class="mt-6 inline-flex items-center gap-2 bg-orange-50 rounded-2xl px-5 py-3">
                <span class="text-xs text-gray-500 font-medium">No. Pesanan</span>
                <span class="font-extrabold text-orange-500 text-lg">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        <div class="bg-white rounded-3xl shadow-sm p-6 space-y-4">
            <h2 class="font-extrabold text-gray-800 flex items-center gap-2">
                <span class="w-2 h-5 bg-orange-500 rounded-full"></span>
                Detail Pesanan
            </h2>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="bg-gray-50 rounded-2xl px-4 py-3">
                    <p class="text-xs text-gray-400 mb-0.5">Nama</p>
                    <p class="font-bold text-gray-800">{{ $order->customer_name ?: '(Tidak diisi)' }}</p>
                </div>
                <div class="bg-gray-50 rounded-2xl px-4 py-3">
                    <p class="text-xs text-gray-400 mb-0.5">Meja</p>
                    <p class="font-bold text-gray-800">No. {{ $order->table_number }}</p>
                </div>
                <div class="bg-gray-50 rounded-2xl px-4 py-3">
                    <p class="text-xs text-gray-400 mb-0.5">Metode Bayar</p>
                    <p class="font-bold text-gray-800">
                        {{ match($order->payment_method) {
                            'cash' => '💵 Tunai',
                            'transfer_bank' => '🏦 Transfer Bank',
                            'e_wallet' => '📱 E-Wallet',
                            default => $order->payment_method
                        } }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-2xl px-4 py-3">
                    <p class="text-xs text-gray-400 mb-0.5">Status Bayar</p>
                    @if($order->payment_status === 'paid')
                        <span class="inline-block bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-lg">✅ Dibayar</span>
                    @else
                        <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded-lg">⏳ Belum Bayar</span>
                    @endif
                </div>
            </div>
            <div class="border-t border-dashed border-gray-200 pt-4 space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center gap-3">
                    @if($item->product?->images)
                        <img src="{{ asset('storage/' . $item->product->images) }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 bg-gray-100">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-300 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ $item->product?->name ?? 'Produk dihapus' }}</p>
                        <p class="text-xs text-gray-400">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="text-sm font-extrabold text-gray-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            <div class="bg-orange-50 rounded-2xl px-5 py-4 flex justify-between items-center">
                <span class="font-semibold text-gray-700">Total Pembayaran</span>
                <span class="text-xl font-extrabold text-orange-500">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            @if($order->proof_of_payment)
            <div class="border-t border-dashed border-gray-200 pt-4">
                <p class="text-xs text-gray-500 mb-2 font-semibold">Bukti Pembayaran</p>
                <img src="{{ asset('storage/' . $order->proof_of_payment) }}" class="w-full max-h-56 object-contain rounded-2xl border border-gray-100 bg-gray-50">
            </div>
            @endif
        </div>
        <div class="bg-orange-500 rounded-3xl p-6 text-white text-center shadow-lg">
            <p class="text-3xl mb-2">🍜</p>
            <p class="font-extrabold text-lg mb-1">Pesanan sedang diproses!</p>
            <p class="text-sm opacity-90">Kasir akan segera mengkonfirmasi pesananmu. Terima kasih!</p>
        </div>
        <a href="{{ route('index') }}" class="block w-full text-center py-4 rounded-2xl bg-white border-2 border-orange-500 text-orange-500 font-extrabold text-sm hover:bg-orange-50 transition shadow-sm">
            ← Pesan Lagi
        </a>
    </div>
</body>
</html>