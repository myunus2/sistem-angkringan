<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Angkringan Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
            -webkit-appearance: none; margin: 0;
        }
    </style>
</head>
<body class="bg-[#FDFDFD] pb-32">

    <div class="relative w-full h-64 md:h-80 bg-orange-500 overflow-hidden shadow-md">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
        
        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&q=80" 
             class="w-full h-full object-cover transform scale-105" alt="Banner Angkringan">
        
        <div class="absolute bottom-8 left-8 z-20 text-white">
            <h1 class="text-3xl md:text-4xl font-black tracking-tight drop-shadow-xl">Angkringan Modern</h1>
            <p class="text-sm md:text-base font-medium opacity-90 mt-1 flex items-center gap-2">
                <span>Jl. Utama No. 12</span>
            </p>
        </div>
    </div>

    <div class="w-full px-4 py-8">
        <h2 class="text-xl font-extrabold text-gray-800 mb-6 px-1 flex items-center gap-2">
            <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
            Menu Terpopuler
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($products as $product)
            <div class="flex flex-col group">
                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50 mb-2">
                    @if($product->images)
                        <img src="{{ asset('storage/' . $product->images) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 font-bold uppercase text-[9px]">No Photo</div>
                    @endif
                    
                    <div class="absolute top-2 left-2">
                        <span class="bg-white/95 backdrop-blur-sm px-2 py-0.5 rounded-md text-[8px] font-black text-orange-600 shadow-sm">
                            STOK: {{ $product->stock }}
                        </span>
                    </div>
                </div>

                <div class="px-0.5">
                    <h3 class="font-bold text-gray-800 text-xs leading-tight mb-0.5 truncate">{{ $product->name }}</h3>
                    <p class="text-[11px] font-bold text-orange-600 mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                    <div class="flex items-center justify-between bg-white border border-gray-200 rounded-lg p-0.5 shadow-sm">
                        <button onclick="decreaseQty(this)" 
                                class="w-8 h-8 flex items-center justify-center rounded-md text-orange-500 font-black hover:bg-orange-50">−</button>
                        
                        <input type="number" value="0" min="0" max="{{ $product->stock }}" 
                               class="w-7 text-center bg-transparent font-black text-[10px] text-gray-800 qty-input"
                               data-id="{{ $product->id }}" data-price="{{ $product->price }}" readonly>
                        
                        <button onclick="increaseQty(this)" 
                                class="w-8 h-8 flex items-center justify-center bg-orange-500 rounded-md text-white font-black shadow-sm active:scale-90">+</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 p-4 z-50">
        <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-gray-100 flex items-center justify-between px-6">
            <div>
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Total Bayar</p>
                <p class="text-xl font-black text-gray-800" id="total-price">Rp 0</p>
            </div>
            <button onclick="submitOrder()" 
                    class="bg-orange-500 hover:bg-orange-600 text-white font-black px-12 py-3.5 rounded-xl shadow-md transition-all active:scale-95 text-sm">
                PESAN SEKARANG 🚀
            </button>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.qty-input');
        
        function increaseQty(btn) {
            const input = btn.previousElementSibling;
            if(parseInt(input.value) < parseInt(input.max)) {
                input.value = parseInt(input.value) + 1;
                updateTotal();
            }
        }
        
        function decreaseQty(btn) {
            const input = btn.nextElementSibling;
            if(parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                updateTotal();
            }
        }
        
        function updateTotal() {
            let total = 0;
            inputs.forEach(i => {
                total += parseInt(i.value) * parseInt(i.dataset.price);
            });
            document.getElementById('total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        function submitOrder() {
            let orderItems = [];
            let totalAll = 0;

            inputs.forEach(i => {
                if(i.value > 0) {
                    orderItems.push({ product_id: i.dataset.id, quantity: i.value });
                    totalAll += i.value * i.dataset.price;
                }
            });

            if(orderItems.length === 0) return alert('Pilih menu lezatnya dulu dong! 🥘');

            // Catatan: Karena input-meja dihapus, Anda perlu menyesuaikan backend 
            // agar menerima nomor meja dari session atau parameter URL lainnya.
            fetch('{{ route("order.store") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ 
                    // table_number bisa diisi default sementara atau dikirim null
                    table_number: 'QR-Meja', 
                    total_price: totalAll, 
                    items: orderItems 
                })
            })
            .then(res => res.json())
            .then(data => {
                alert('Pesanan dikirim! ✨');
                location.reload();
            })
            .catch(err => alert('Gagal mengirim pesanan.'));
        }
    </script>
</body>
</html>