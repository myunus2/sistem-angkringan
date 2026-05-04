<div class="fi-page-content px-6 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[calc(100vh-4rem)]">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">Kasir POS</h1>
                    <p class="text-sm text-gray-500">Pilih produk untuk menambahkan ke keranjang.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($products as $p)
                    <div onclick="addToCart({{ $p->id }}, @js($p->name), {{ $p->price }})"
                         class="cursor-pointer rounded-2xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition">
                        <img src="{{ asset('images/' . $p->image) }}"
                             onerror="this.src='https://via.placeholder.com/150'"
                             class="h-36 w-full object-cover rounded-xl mb-4">

                        <div class="space-y-2">
                            <p class="font-semibold">{{ $p->name }}</p>
                            <p class="text-green-600">Rp {{ number_format($p->price) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col">
            <div class="mb-4">
                <h2 class="text-lg font-semibold">Keranjang</h2>
                <p class="text-sm text-gray-500">Periksa pesanan sebelum checkout.</p>
            </div>

            <div class="space-y-3 mb-4">
                <input type="text" id="customer_name"
                       placeholder="Nama pelanggan"
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-green-500 focus:outline-none" />

                <input type="text" id="table_number"
                       placeholder="Nomor meja"
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-green-500 focus:outline-none" />
            </div>

            <div id="cart" class="flex-1 overflow-y-auto space-y-3"></div>

            <div class="mt-4 border-t border-gray-200 pt-4 space-y-3">
                <div class="flex items-center justify-between font-semibold text-lg">
                    <span>Total</span>
                    <span id="total">Rp 0</span>
                </div>

                <input type="number" id="cash"
                       placeholder="Uang bayar"
                       class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-green-500 focus:outline-none" />

                <div class="text-sm font-semibold">
                    Kembalian: <span id="change">Rp 0</span>
                </div>

                <button onclick="checkout()"
                        class="w-full rounded-xl bg-green-600 px-4 py-3 text-white font-semibold hover:bg-green-700 transition">
                    Checkout
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];
    let totalAmount = 0;

    function addToCart(id, name, price) {
        let item = cart.find(i => i.id === id);

        if (item) {
            item.qty++;
        } else {
            cart.push({id, name, price, qty: 1});
        }

        renderCart();
    }

    function renderCart() {
        let html = "";
        totalAmount = 0;

        cart.forEach((item, i) => {
            totalAmount += item.price * item.qty;

            html += `
                <div class="rounded-2xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between gap-3 mb-3">
                        <div>
                            <p class="font-semibold">${item.name}</p>
                            <p class="text-sm text-gray-500">${item.qty} x Rp ${item.price}</p>
                        </div>
                        <button onclick="removeItem(${i})" class="text-red-500">x</button>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <button onclick="minus(${i})" class="rounded-full border border-gray-200 px-3 py-1">-</button>
                        <span>${item.qty}</span>
                        <button onclick="plus(${i})" class="rounded-full border border-gray-200 px-3 py-1">+</button>
                    </div>
                </div>`;
        });

        document.getElementById("cart").innerHTML = html;
        document.getElementById("total").innerText = "Rp " + totalAmount.toLocaleString();
        updateChange();
    }

    function plus(i) {
        cart[i].qty++;
        renderCart();
    }

    function minus(i) {
        cart[i].qty--;

        if (cart[i].qty <= 0) {
            cart.splice(i, 1);
        }

        renderCart();
    }

    function removeItem(i) {
        cart.splice(i, 1);
        renderCart();
    }

    function updateChange() {
        let cash = parseInt(document.getElementById('cash').value) || 0;
        let change = cash - totalAmount;

        if (change < 0) {
            change = 0;
        }

        document.getElementById('change').innerText = "Rp " + change.toLocaleString();
    }

    function checkout() {
        let customer_name = document.getElementById('customer_name').value;
        let table_number = document.getElementById('table_number').value;
        let cash = document.getElementById('cash').value;

        if (cart.length === 0) {
            alert("Keranjang kosong!");
            return;
        }

        if (!cash) {
            alert("Uang bayar wajib diisi!");
            return;
        }

        fetch("{{ route('kasir.checkout') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({
                cart: cart,
                customer_name: customer_name,
                table: table_number,
                cash: cash
            })
        })
            .then(res => res.json())
            .then(data => {
                alert("Transaksi berhasil!");

                cart = [];
                totalAmount = 0;
                renderCart();

                document.getElementById('cash').value = "";
                document.getElementById('customer_name').value = "";
                document.getElementById('table_number').value = "";
                document.getElementById('change').innerText = "Rp 0";
            });
    }
</script>