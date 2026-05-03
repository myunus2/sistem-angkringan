<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir App - Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .product-card {
            transition: all 0.2s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .cart-item-enter {
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- LEFT: PRODUK -->
    <div class="w-2/3 p-4">

        <input type="text" id="searchMenu" placeholder="Cari menu..."
            class="w-full p-3 rounded-lg border mb-4 focus:outline-none focus:ring-2 focus:ring-orange-500">

        <div id="productGrid" class="grid grid-cols-3 gap-4">
            <!-- Products akan di-load via JavaScript -->
        </div>
    </div>

    <!-- RIGHT: KERANJANG -->
    <div class="w-1/3 bg-white shadow-lg flex flex-col h-screen sticky top-0">

        <div class="p-4 flex-1 flex flex-col overflow-hidden">
            <h2 class="text-xl font-bold mb-3">🛒 Pesanan</h2>

            <div id="cart-list" class="flex-1 overflow-auto text-sm text-gray-700 space-y-2">
                <p class="text-gray-400 text-center py-8">Keranjang kosong</p>
            </div>

            <div class="border-t pt-3 mt-3">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 text-sm">TOTAL BAYAR</h3>
                    <h3 class="text-gray-500 text-sm">Pajak 10%</h3>
                </div>
                <h1 id="subtotal" class="text-2xl font-bold text-gray-700">Rp 0</h1>
                <h1 id="total" class="text-3xl font-bold text-orange-500 mt-1">Rp 0</h1>
            </div>

            <div class="mt-3 space-y-2">
                <input id="tableNumber" placeholder="Nomor Meja *wajib"
                    class="border p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-orange-500">

                <input id="bayar" type="number" placeholder="Uang Bayar"
                    class="border p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-orange-500"
                    oninput="calculateChange()">

                <div id="kembalian" class="text-green-600 font-bold text-sm"></div>
            </div>

            <button onclick="checkout()"
                class="bg-orange-500 text-white p-4 mt-4 rounded-lg text-lg font-bold hover:bg-orange-600 transition duration-200">
                PROSES PEMBAYARAN
            </button>
        </div>
    </div>

</div>

<script>
// Data produk (simulasi database)
const products = [
    { id: 1, name: "Nasi Goreng", price: 12000, image: "https://via.placeholder.com/150?text=Nasi+Goreng" },
    { id: 2, name: "Mie Pedas", price: 10000, image: "https://via.placeholder.com/150?text=Mie+Pedas" },
    { id: 3, name: "Pecel Ayam", price: 15000, image: "https://via.placeholder.com/150?text=Pecel+Ayam" },
    { id: 4, name: "Ayam Geprek", price: 13000, image: "https://via.placeholder.com/150?text=Ayam+Geprek" },
    { id: 5, name: "Chicken Katsu", price: 14000, image: "https://via.placeholder.com/150?text=Chicken+Katsu" },
    { id: 6, name: "Kentang Goreng", price: 8000, image: "https://via.placeholder.com/150?text=Kentang+Goreng" },
    { id: 7, name: "Nugget Goreng", price: 7500, image: "https://via.placeholder.com/150?text=Nugget" },
    { id: 8, name: "Es Teh Manis", price: 3000, image: "https://via.placeholder.com/150?text=Es+Teh" },
    { id: 9, name: "Jus Jeruk", price: 8000, image: "https://via.placeholder.com/150?text=Jus+Jeruk" }
];

let cart = [];
let taxRate = 0.1; // Pajak 10%

/* =========================
   RENDER PRODUCTS
========================= */
function renderProducts(searchTerm = '') {
    const productGrid = document.getElementById('productGrid');
    const filteredProducts = products.filter(p => 
        p.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    if (filteredProducts.length === 0) {
        productGrid.innerHTML = '<div class="col-span-3 text-center py-10 text-gray-500">Menu tidak ditemukan</div>';
        return;
    }
    
    productGrid.innerHTML = filteredProducts.map(product => `
        <div class="product-card bg-white p-4 rounded-xl shadow cursor-pointer hover:shadow-lg transition-all duration-200"
            data-id="${product.id}"
            data-name="${product.name}"
            data-price="${product.price}">
            <img src="${product.image}" 
                class="h-32 w-full object-cover rounded-lg mb-3">
            <h3 class="font-bold text-sm text-gray-800">${product.name}</h3>
            <p class="text-orange-500 font-bold mt-1">
                Rp ${product.price.toLocaleString()}
            </p>
        </div>
    `).join('');
    
    // Re-attach event listeners
    document.querySelectorAll('.product-card').forEach(el => {
        el.addEventListener('click', function() {
            addToCart(
                parseInt(this.dataset.id),
                this.dataset.name,
                parseInt(this.dataset.price)
            );
        });
    });
}

/* =========================
   SEARCH FUNCTIONALITY
========================= */
document.addEventListener('DOMContentLoaded', function() {
    renderProducts();
    
    const searchInput = document.getElementById('searchMenu');
    searchInput.addEventListener('input', function(e) {
        renderProducts(e.target.value);
    });
});

/* =========================
   ADD TO CART
========================= */
function addToCart(id, name, price) {
    let item = cart.find(i => i.id === id);
    
    if (item) {
        item.qty++;
        showNotification(`+1 ${name}`, 'success');
    } else {
        cart.push({
            id: id,
            name: name,
            price: price,
            qty: 1
        });
        showNotification(`${name} ditambahkan`, 'success');
    }
    
    renderCart();
}

/* =========================
   CHANGE QTY
========================= */
function changeQty(index, type) {
    if (type === 'plus') {
        cart[index].qty++;
        showNotification(`+1 ${cart[index].name}`, 'success');
    }
    if (type === 'minus') {
        cart[index].qty--;
        if (cart[index].qty <= 0) {
            showNotification(`${cart[index].name} dihapus`, 'info');
            cart.splice(index, 1);
        } else {
            showNotification(`-1 ${cart[index].name}`, 'info');
        }
    }
    
    renderCart();
}

/* =========================
   CALCULATE CHANGE
========================= */
function calculateChange() {
    let total = calculateTotal();
    let bayar = parseInt(document.getElementById('bayar').value) || 0;
    let kembali = bayar - total;
    
    const kembalianEl = document.getElementById('kembalian');
    
    if (bayar > 0 && kembali >= 0) {
        kembalianEl.innerHTML = `💰 Kembalian: Rp ${kembali.toLocaleString()}`;
        kembalianEl.className = "text-green-600 font-bold text-sm";
    } else if (bayar > 0 && kembali < 0) {
        kembalianEl.innerHTML = `⚠️ Kurang: Rp ${Math.abs(kembali).toLocaleString()}`;
        kembalianEl.className = "text-red-600 font-bold text-sm";
    } else {
        kembalianEl.innerHTML = "";
    }
}

/* =========================
   CALCULATE TOTAL
========================= */
function calculateTotal() {
    let subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    let tax = subtotal * taxRate;
    return subtotal + tax;
}

/* =========================
   RENDER CART
========================= */
function renderCart() {
    const cartList = document.getElementById('cart-list');
    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('total');
    
    if (cart.length === 0) {
        cartList.innerHTML = '<p class="text-gray-400 text-center py-8">✨ Keranjang masih kosong</p>';
        subtotalEl.innerText = "Rp 0";
        totalEl.innerText = "Rp 0";
        document.getElementById('kembalian').innerHTML = "";
        return;
    }
    
    let subtotal = 0;
    let cartHtml = '';
    
    cart.forEach((item, index) => {
        subtotal += item.price * item.qty;
        cartHtml += `
        <div class="cart-item-enter flex justify-between items-center border-b pb-2 mb-2">
            <div class="flex-1">
                <p class="font-bold text-gray-800">${item.name}</p>
                <p class="text-xs text-gray-500">
                    ${item.qty} x Rp ${item.price.toLocaleString()}
                </p>
            </div>
            <div class="flex gap-2">
                <button onclick="changeQty(${index}, 'minus')" 
                    class="w-7 h-7 bg-gray-200 rounded-full hover:bg-gray-300 transition">-</button>
                <span class="w-6 text-center font-bold">${item.qty}</span>
                <button onclick="changeQty(${index}, 'plus')" 
                    class="w-7 h-7 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition">+</button>
            </div>
        </div>
        `;
    });
    
    let tax = subtotal * taxRate;
    let total = subtotal + tax;
    
    cartList.innerHTML = cartHtml;
    subtotalEl.innerText = `Rp ${subtotal.toLocaleString()}`;
    totalEl.innerText = `Rp ${total.toLocaleString()}`;
    
    calculateChange();
}

/* =========================
   NOTIFICATION
========================= */
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-3 rounded-lg shadow-lg z-50 animate-bounce ${
        type === 'success' ? 'bg-green-500' : 'bg-blue-500'
    } text-white`;
    notification.innerText = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 1500);
}

/* =========================
   CHECKOUT
========================= */
function checkout() {
    if (cart.length === 0) {
        showNotification('Keranjang masih kosong!', 'error');
        return;
    }
    
    let tableNumber = document.getElementById('tableNumber').value;
    
    if (!tableNumber) {
        showNotification('Nomor meja harus diisi!', 'error');
        document.getElementById('tableNumber').focus();
        return;
    }
    
    let bayar = parseInt(document.getElementById('bayar').value) || 0;
    let total = calculateTotal();
    
    if (bayar < total) {
        showNotification(`Uang kurang Rp ${(total - bayar).toLocaleString()}`, 'error');
        return;
    }
    
    // Simulasi proses checkout
    let orderData = {
        id: 'INV-' + Date.now(),
        table: tableNumber,
        date: new Date().toLocaleString(),
        items: cart,
        subtotal: cart.reduce((sum, item) => sum + (item.price * item.qty), 0),
        tax: cart.reduce((sum, item) => sum + (item.price * item.qty), 0) * taxRate,
        total: total,
        payment: bayar,
        change: bayar - total
    };
    
    // Tampilkan struk
    showReceipt(orderData);
    
    // Reset cart
    cart = [];
    renderCart();
    document.getElementById('tableNumber').value = '';
    document.getElementById('bayar').value = '';
}

/* =========================
   SHOW RECEIPT
========================= */
function showReceipt(order) {
    let receiptHtml = `
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6 max-h-screen overflow-auto">
                <div class="text-center border-b pb-3 mb-3">
                    <h2 class="text-2xl font-bold">🧾 STRUK PEMBAYARAN</h2>
                    <p class="text-sm text-gray-500">${order.date}</p>
                    <p class="text-sm font-bold mt-2">Meja No. ${order.table}</p>
                </div>
                
                <div class="space-y-2 mb-3">
                    ${order.items.map(item => `
                        <div class="flex justify-between text-sm">
                            <span>${item.name} x${item.qty}</span>
                            <span>Rp ${(item.price * item.qty).toLocaleString()}</span>
                        </div>
                    `).join('')}
                </div>
                
                <div class="border-t pt-2 space-y-1">
                    <div class="flex justify-between text-sm">
                        <span>Subtotal</span>
                        <span>Rp ${order.subtotal.toLocaleString()}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Pajak (10%)</span>
                        <span>Rp ${order.tax.toLocaleString()}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg mt-2">
                        <span>TOTAL</span>
                        <span class="text-orange-500">Rp ${order.total.toLocaleString()}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Bayar</span>
                        <span>Rp ${order.payment.toLocaleString()}</span>
                    </div>
                    <div class="flex justify-between text-sm text-green-600 font-bold">
                        <span>Kembalian</span>
                        <span>Rp ${order.change.toLocaleString()}</span>
                    </div>
                </div>
                
                <button onclick="this.closest('.fixed').remove()" 
                    class="w-full bg-orange-500 text-white p-3 rounded-lg mt-4 font-bold hover:bg-orange-600">
                    ✅ Selesai
                </button>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', receiptHtml);
}

// Initial render
renderProducts();
</script>

</body>
</html>