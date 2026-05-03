<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kasir POS</title>
<script src="https://cdn.tailwindcss.com"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

<!-- MENU -->
<div class="w-2/3 p-4 overflow-y-auto">

    <h1 class="text-xl font-bold mb-4">Menu Produk</h1>

    <div class="grid grid-cols-3 gap-4">

        @foreach($products as $p)
        <div onclick="addToCart({{ $p->id }}, @js($p->name), {{ $p->price }})"
            class="cursor-pointer bg-white p-3 rounded shadow">

            <img src="{{ asset('images/' . $p->image) }}"
                 onerror="this.src='https://via.placeholder.com/150'"
                 class="h-24 w-full object-cover rounded">

            <p class="font-bold mt-2">{{ $p->name }}</p>
            <p class="text-green-600">Rp {{ number_format($p->price) }}</p>

        </div>
        @endforeach

    </div>
</div>

<!-- CART -->
<div class="w-1/3 bg-white p-4 flex flex-col">

    <h2 class="text-lg font-bold mb-2">Keranjang</h2>

    <input type="text" id="customer_name"
        placeholder="Nama pelanggan"
        class="border p-2 w-full mb-2 rounded">

    <select id="table_number"
        class="border p-2 w-full mb-3 rounded">
        <option value="">-- Pilih Meja --</option>
        <option value="1">Meja 1</option>
        <option value="2">Meja 2</option>
        <option value="3">Meja 3</option>
        <option value="4">Meja 4</option>
        <option value="5">Meja 5</option>
        <option value="6">Meja 6</option>
        <option value="7">Meja 7</option>
        <option value="8">Meja 8</option>
        <option value="9">Meja 9</option>
        <option value="10">Meja 10</option>
    </select>

    <div id="cart" class="flex-1 overflow-y-auto"></div>

    <hr class="my-2">

    <div class="flex justify-between font-bold text-lg">
        <span>Total</span>
        <span id="total">Rp 0</span>
    </div>

    <input type="number" id="cash"
        placeholder="Uang bayar"
        class="border p-2 w-full mt-3 rounded">

    <div class="mt-2 font-bold">
        Kembalian: <span id="change">Rp 0</span>
    </div>

    <button onclick="checkout()"
        class="mt-3 bg-green-600 text-white p-3 rounded w-full">
        Checkout
    </button>

</div>

</div>

<script>

let cart = [];
let totalAmount = 0;

// ADD
function addToCart(id, name, price){

    let item = cart.find(i => i.id === id);

    if(item){
        item.qty++;
    } else {
        cart.push({id, name, price, qty:1});
    }

    renderCart();
}

// RENDER
function renderCart(){

    let html = "";
    totalAmount = 0;

    cart.forEach((item, i) => {

        totalAmount += item.price * item.qty;

        html += `
        <div class="border-b py-2">
            <div class="flex justify-between">
                <b>${item.name}</b>
                <button onclick="removeItem(${i})">x</button>
            </div>

            <div class="flex justify-between text-sm">
                <span>${item.qty} x Rp ${item.price}</span>
                <div>
                    <button onclick="minus(${i})">-</button>
                    <button onclick="plus(${i})">+</button>
                </div>
            </div>
        </div>`;
    });

    document.getElementById("cart").innerHTML = html;
    document.getElementById("total").innerText = "Rp " + totalAmount.toLocaleString();

    updateChange();
}

// QTY
function plus(i){ cart[i].qty++; renderCart(); }
function minus(i){ cart[i].qty--; if(cart[i].qty<=0) cart.splice(i,1); renderCart(); }
function removeItem(i){ cart.splice(i,1); renderCart(); }

// KEMBALIAN
document.getElementById('cash').addEventListener('input', updateChange);

function updateChange(){

    let cash = parseInt(document.getElementById('cash').value) || 0;
    let change = cash - totalAmount;

    if(change < 0) change = 0;

    document.getElementById('change').innerText =
        "Rp " + change.toLocaleString();
}

// CHECKOUT
function checkout(){

    let customer_name = document.getElementById('customer_name').value;
    let table_number = document.getElementById('table_number').value;
    let cash = document.getElementById('cash').value;

    if(cart.length === 0){
        alert("Keranjang kosong!");
        return;
    }

    if(!cash){
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

</body>
</html>