<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout – Angkringan Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .fade-in { animation: fadeIn .25s ease; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body class="bg-[#F8F8F8] min-h-screen pb-10">

    {{-- Header --}}
    <div class="bg-white shadow-sm sticky top-0 z-30">
        <div class="max-w-2xl mx-auto px-4 py-4 flex items-center gap-3">
            <a href="{{ route('index') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-orange-50 text-orange-500 hover:bg-orange-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-lg font-extrabold text-gray-800">Checkout</h1>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 mt-6 space-y-5">

        {{-- Error --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Ringkasan Pesanan --}}
        <div class="bg-white rounded-3xl shadow-sm p-5">
            <h2 class="font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-2 h-5 bg-orange-500 rounded-full"></span>
                Pesanan Saya
            </h2>
            <div id="cart-items" class="space-y-3 min-h-[60px]">
                <p id="cart-empty" class="text-gray-400 text-sm text-center py-4">Keranjang kosong. <a href="{{ route('index') }}" class="text-orange-500 font-semibold">Tambah menu →</a></p>
            </div>
            <div id="cart-summary" class="hidden mt-4 pt-4 border-t border-dashed border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Total</span>
                    <span id="cart-total" class="text-xl font-extrabold text-orange-500">Rp 0</span>
                </div>
                <a href="{{ route('index') }}" class="mt-3 inline-block text-sm text-orange-500 font-semibold hover:underline">+ Tambah menu lagi</a>
            </div>
        </div>

        {{-- Form Checkout --}}
        <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <input type="hidden" name="items_json" id="items-json">

            {{-- Info Pelanggan --}}
            <div class="bg-white rounded-3xl shadow-sm p-5 space-y-4">
                <h2 class="font-extrabold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-5 bg-orange-500 rounded-full"></span>
                    Info Pelanggan
                </h2>
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama (opsional)</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                           placeholder="Contoh: Budi"
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor Meja <span class="text-red-500">*</span></label>
                    <input type="text" name="table_number" value="{{ old('table_number') }}"
                           placeholder="Contoh: 5"
                           required
                           class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="bg-white rounded-3xl shadow-sm p-5 space-y-4">
                <h2 class="font-extrabold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-5 bg-orange-500 rounded-full"></span>
                    Metode Pembayaran
                </h2>

                {{-- Cash --}}
                <label class="flex items-center gap-3 p-4 rounded-2xl border-2 cursor-pointer transition payment-option
                    {{ old('payment_method') == 'cash' ? 'border-orange-500 bg-orange-50' : 'border-gray-100 bg-gray-50 hover:border-orange-200' }}">
                    <input type="radio" name="payment_method" value="cash" class="hidden payment-radio" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100 text-green-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm">Tunai (Cash)</p>
                        <p class="text-xs text-gray-500">Bayar langsung ke kasir</p>
                    </div>
                    <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-300 check-circle flex items-center justify-center flex-shrink-0">
                        <div class="w-2.5 h-2.5 rounded-full bg-orange-500 hidden check-dot"></div>
                    </div>
                </label>

                {{-- Transfer Bank --}}
                @if(isset($paymentMethods['bank']) && $paymentMethods['bank']->count())
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Transfer Bank</p>
                    @foreach($paymentMethods['bank'] as $method)
                    <label class="flex items-center gap-3 p-4 rounded-2xl border-2 cursor-pointer transition payment-option mb-2
                        {{ old('payment_method') == 'transfer_bank' ? 'border-orange-500 bg-orange-50' : 'border-gray-100 bg-gray-50 hover:border-orange-200' }}">
                        <input type="radio" name="payment_method" value="transfer_bank" class="hidden payment-radio" {{ old('payment_method') == 'transfer_bank' ? 'checked' : '' }}>
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ $method->name }}</p>
                            <p class="text-xs text-gray-500">{{ $method->account_number }} – {{ $method->account_holder }}</p>
                        </div>
                        <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-300 check-circle flex items-center justify-center flex-shrink-0">
                            <div class="w-2.5 h-2.5 rounded-full bg-orange-500 hidden check-dot"></div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @endif

                {{-- E-Wallet --}}
                @if(isset($paymentMethods['ewallet']) && $paymentMethods['ewallet']->count())
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">E-Wallet</p>
                    @foreach($paymentMethods['ewallet'] as $method)
                    <label class="flex items-center gap-3 p-4 rounded-2xl border-2 cursor-pointer transition payment-option mb-2
                        {{ old('payment_method') == 'e_wallet' ? 'border-orange-500 bg-orange-50' : 'border-gray-100 bg-gray-50 hover:border-orange-200' }}">
                        <input type="radio" name="payment_method" value="e_wallet" class="hidden payment-radio" {{ old('payment_method') == 'e_wallet' ? 'checked' : '' }}>
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">{{ $method->name }}</p>
                            <p class="text-xs text-gray-500">{{ $method->account_number }} – {{ $method->account_holder }}</p>
                        </div>
                        <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-300 check-circle flex items-center justify-center flex-shrink-0">
                            <div class="w-2.5 h-2.5 rounded-full bg-orange-500 hidden check-dot"></div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @endif

                {{-- Upload Bukti Bayar --}}
                <div id="proof-section" class="hidden fade-in">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Upload Bukti Pembayaran <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-orange-300 rounded-2xl p-6 cursor-pointer hover:bg-orange-50 transition bg-orange-50/50">
                        <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span id="proof-label" class="text-sm text-gray-500">Klik untuk pilih foto bukti transfer</span>
                        <input type="file" name="proof_of_payment" id="proof-input" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>

            {{-- Tombol Pesan --}}
            <button type="submit" id="submit-btn"
                class="w-full py-4 rounded-2xl bg-orange-500 text-white font-extrabold text-base shadow-lg hover:bg-orange-600 active:scale-95 transition disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>
                Pesan Sekarang 🍽️
            </button>
        </form>
    </div>

<script>
    const CART_KEY = 'angkringan_cart';
    function getCart() {
        try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; }
        catch { return []; }
    }
    function formatRupiah(n) {
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    }
    function renderCart() {
        const cart = getCart();
        const container = document.getElementById('cart-items');
        const emptyMsg  = document.getElementById('cart-empty');
        const summary   = document.getElementById('cart-summary');
        const totalEl   = document.getElementById('cart-total');
        const submitBtn = document.getElementById('submit-btn');
        const itemsJson = document.getElementById('items-json');
        if (!cart.length) {
            emptyMsg.classList.remove('hidden');
            summary.classList.add('hidden');
            submitBtn.disabled = true;
            itemsJson.value = '[]';
            container.querySelectorAll('.cart-row').forEach(el => el.remove());
            return;
        }
        emptyMsg.classList.add('hidden');
        summary.classList.remove('hidden');
        submitBtn.disabled = false;
        container.querySelectorAll('.cart-row').forEach(el => el.remove());
        let total = 0;
        cart.forEach((item) => {
            const subtotal = item.price * item.qty;
            total += subtotal;
            const row = document.createElement('div');
            row.className = 'cart-row flex items-center gap-3 fade-in';
            row.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 bg-gray-100">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-800 truncate">${item.name}</p>
                    <p class="text-xs text-orange-500 font-semibold">${formatRupiah(item.price)}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <button type="button" onclick="changeQty(${item.id}, -1)" class="w-7 h-7 rounded-full bg-gray-100 text-gray-600 font-bold hover:bg-orange-100 hover:text-orange-600 transition text-base flex items-center justify-center">−</button>
                    <span class="w-6 text-center text-sm font-bold text-gray-800">${item.qty}</span>
                    <button type="button" onclick="changeQty(${item.id}, 1)" class="w-7 h-7 rounded-full bg-orange-500 text-white font-bold hover:bg-orange-600 transition text-base flex items-center justify-center">+</button>
                </div>
                <p class="text-sm font-extrabold text-gray-800 w-20 text-right flex-shrink-0">${formatRupiah(subtotal)}</p>
            `;
            container.appendChild(row);
        });
        totalEl.textContent = formatRupiah(total);
        const itemsForForm = cart.map(item => ({ product_id: item.id, quantity: item.qty }));
        itemsJson.value = JSON.stringify(itemsForForm);
    }
    function changeQty(productId, delta) {
        let cart = getCart();
        const idx = cart.findIndex(i => i.id === productId);
        if (idx === -1) return;
        cart[idx].qty += delta;
        if (cart[idx].qty <= 0) cart.splice(idx, 1);
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        renderCart();
    }
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const cart = getCart();
        if (!cart.length) { e.preventDefault(); alert('Keranjang belanja kosong!'); return; }
        this.querySelectorAll('[name^="items["]').forEach(el => el.remove());
        cart.forEach((item, idx) => {
            const pid = document.createElement('input');
            pid.type = 'hidden'; pid.name = `items[${idx}][product_id]`; pid.value = item.id;
            const qty = document.createElement('input');
            qty.type = 'hidden'; qty.name = `items[${idx}][quantity]`; qty.value = item.qty;
            this.appendChild(pid); this.appendChild(qty);
        });
        localStorage.removeItem(CART_KEY);
    });
    document.querySelectorAll('.payment-option').forEach(label => {
        label.addEventListener('click', function() {
            document.querySelectorAll('.payment-option').forEach(l => {
                l.classList.remove('border-orange-500', 'bg-orange-50');
                l.classList.add('border-gray-100', 'bg-gray-50');
                l.querySelector('.check-dot')?.classList.add('hidden');
            });
            this.classList.add('border-orange-500', 'bg-orange-50');
            this.classList.remove('border-gray-100', 'bg-gray-50');
            this.querySelector('.check-dot')?.classList.remove('hidden');
            const val = this.querySelector('input[type=radio]')?.value;
            document.getElementById('proof-section').classList.toggle('hidden', val === 'cash');
        });
    });
    document.getElementById('proof-input')?.addEventListener('change', function() {
        if (this.files[0]) document.getElementById('proof-label').textContent = '✅ ' + this.files[0].name;
    });
    renderCart();
</script>
</body>
</html>