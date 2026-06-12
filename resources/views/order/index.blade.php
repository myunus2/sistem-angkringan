<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu Angkringan Cakra Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {  font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .product-grid.blur .product-card {
            filter: blur(6px) brightness(0.75);
            pointer-events: none;
            transition: filter 200ms ease;
        }
        .product-card.focused {
            transform: scale(1.08);
            box-shadow: 0 35px 80px rgba(15, 23, 42, 0.25);
            z-index: 20;
            position: relative;
            filter: none !important;
            pointer-events: auto;
        }
       .hero-banner {
    background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.75)), url('{{ asset('images/image.png') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat; 
    min-height: 30vh; 
    display: flex; /* Mempermudah pengaturan posisi teks di dalam banner */
    align-items: center; /* Membuat teks otomatis berada di tengah secara vertikal */
    justify-content: center; /* Membuat teks otomatis berada di tengah secara horizontal */
}
        @media (max-width: 768px) {
            .snap-x-container {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
            }
            .snap-item { scroll-snap-align: start; flex-shrink: 0; }
            .modal-grid { grid-template-columns: 1fr !important; }
            .modal-buttons { flex-direction: column; }
            .modal-buttons button { width: 100%; }
        }
        @media (max-width: 640px) {
            body { font-size: 14px; }
            .modal-p { padding: 2rem 1rem; }
        }
    </style>
</head>
<body class="bg-orange-50 pb-32">

    <div class="relative w-full h-48 sm:h-64 md:h-80 bg-orange-500 overflow-hidden shadow-md hero-banner">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
        <div class="absolute bottom-4 sm:bottom-6 md:bottom-8 left-4 sm:left-6 md:left-8 z-20 text-white">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight drop-shadow-xl">Angkringan Cakra Digital</h1>
            <p class="text-xs sm:text-sm md:text-base font-medium opacity-90 mt-1"><span>Angkringan Cakra berlokasi di GGJP+XR4, Cubadak, Kec. Pariangan, Kabupaten Tanah Datar, Sumatera Barat 27264 (sekitar kawasan kampus UIN Mahmud Yunus Batusangkar).</span></p>
        </div>
    </div>

    <div class="px-3 sm:px-6 lg:px-8 mt-6 sm:mt-8">
        <div class="max-w-2xl mx-auto">
            <form id="search-form" action="{{ route('index') }}" method="GET" class="relative group">
                @if(request('category'))
                    <input type="hidden" name="category" id="search-category" value="{{ request('category') }}">
                @endif
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                       class="block w-full pl-12 pr-4 py-3 sm:py-4 border-2 border-transparent bg-white shadow-sm rounded-2xl leading-5 focus:outline-none focus:ring-0 focus:border-orange-500 text-sm sm:text-base transition-all placeholder-gray-400"
                       placeholder="Cari menu favorit Anda...">
            </form>
        </div>
    </div>

    <div class="px-2 sm:px-6 lg:px-8 my-6 sm:my-10">
        <div class="snap-x-container flex gap-2 sm:gap-4 pb-4 no-scrollbar overflow-x-auto justify-start sm:justify-center items-center w-full">
            @php $currentCat = request('category', 'semua'); @endphp
            @foreach(['semua', 'makanan', 'minuman', 'snack'] as $cat)
            <div class="snap-item">
                <a href="{{ route('index', ['category' => $cat]) }}"
                   data-category="{{ $cat }}"
                   class="category-btn ajax-filter inline-block whitespace-nowrap px-4 sm:px-10 py-2 sm:py-3.5 rounded-xl sm:rounded-2xl text-[11px] sm:text-base font-black uppercase tracking-wider transition-all
                   {{ $currentCat == $cat ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30 scale-105' : 'bg-white text-gray-500 hover:bg-orange-50 border border-gray-100 sm:border-transparent' }}">
                   {{ ucfirst($cat) }}
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div id="main-product-container" class="w-full max-w-[1600px] mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-8">
        @include('order.partials.product-list')
    </div>

    {{-- Modal Detail Produk --}}
    <div id="product-focus-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/30 focus-overlay p-2 sm:p-4">
        <div class="relative w-full max-w-4xl overflow-hidden rounded-2xl sm:rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-200 max-h-[90vh] overflow-y-auto">
            <button id="product-focus-close" class="absolute right-2 sm:right-4 top-2 sm:top-4 inline-flex h-8 sm:h-10 w-8 sm:w-10 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm transition hover:bg-slate-100 z-10">
                <span class="text-lg sm:text-xl font-bold">x</span>
            </button>
            <div class="modal-grid grid gap-4 sm:gap-6 md:grid-cols-[1.2fr_1fr] p-3 sm:p-6">
                <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-slate-100 min-h-[250px] sm:min-h-[300px]">
                    <img id="focus-image" src="" alt="Produk" class="h-full w-full object-cover">
                </div>
                <div class="flex flex-col justify-between">
                    <div>
                        <p id="focus-type" class="mb-2 text-xs uppercase tracking-[0.3em] text-orange-600"></p>
                        <h3 id="focus-name" class="mb-2 sm:mb-4 text-xl sm:text-2xl font-bold text-slate-900"></h3>
                        <p id="focus-price" class="mb-3 sm:mb-4 text-base sm:text-lg font-semibold text-orange-600"></p>
                        <div class="mb-3 sm:mb-4 max-h-24 sm:max-h-28 overflow-y-auto pr-1" id="focus-description-wrap">
                            <p id="focus-description" class="leading-relaxed text-xs sm:text-sm text-slate-600 min-h-[2rem] whitespace-pre-wrap"></p>
                        </div>
                        <div class="rounded-2xl sm:rounded-3xl bg-orange-50 p-3 sm:p-4 text-xs sm:text-sm text-slate-700">
                            <div class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-orange-700">Komposisi</div>
                            <div class="max-h-20 sm:max-h-24 overflow-y-auto pr-1" id="focus-composition-wrap">
                                <p id="focus-composition" class="leading-relaxed min-h-[1rem] whitespace-pre-wrap"></p>
                            </div>
                        </div>
                        </div>
                    </div>
                        <div class="mt-4 sm:mt-6 modal-buttons flex flex-col sm:flex-row gap-3 justify-between items-center">
                        	<script>
                        	// Pastikan scroll text description/komposisi selalu turun otomatis jika konten panjang
                        	// (menggunakan element wrapper agar tetap tidak mempengaruhi ukuran gambar)
                        	document.addEventListener('DOMContentLoaded', () => {
                        		const descWrap = document.getElementById('focus-description-wrap');
                        		const compWrap = document.getElementById('focus-composition-wrap');
                        		if (descWrap) {
                        			// agar scroll mengikuti teks saat konten panjang
                        			descWrap.scrollTop = descWrap.scrollHeight;
                        			descWrap.style.scrollBehavior = 'smooth';
                        		}
                        		if (compWrap) {
                        			compWrap.scrollTop = compWrap.scrollHeight;
                        			compWrap.style.scrollBehavior = 'smooth';
                        		}
                        		// fallback: pastikan jika user scroll/textarea berubah, tetap mengarah ke bawah
                        		if (descWrap) {
                        			let last = -1;
                        			setInterval(() => {
                        				if (!descWrap) return;
                        				if (descWrap.scrollHeight !== last) {
                        					last = descWrap.scrollHeight;
                        					descWrap.scrollTop = descWrap.scrollHeight;
                        				}
                        			}, 200);
                        		}
                        		if (compWrap) {
                        			let last2 = -1;
                        			setInterval(() => {
                        				if (!compWrap) return;
                        				if (compWrap.scrollHeight !== last2) {
                        					last2 = compWrap.scrollHeight;
                        					compWrap.scrollTop = compWrap.scrollHeight;
                        				}
                        			}, 200);
                        		}
                        	});
                        	</script>
                        	<div class="flex items-center gap-2 w-full sm:w-auto">
                            <button id="btn-tambah" class="w-full sm:w-auto rounded-2xl sm:rounded-3xl bg-orange-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600 shadow-lg">Pesan</button>
                            <div id="qty-controls" class="hidden items-center bg-gray-100 rounded-3xl p-1 w-full sm:w-auto justify-between sm:justify-start">
                                <button id="btn-minus" class="w-10 h-10 flex items-center justify-center bg-white rounded-2xl shadow-sm text-gray-700 font-bold hover:text-orange-600 transition text-lg">-</button>
                                <span id="qty-display" class="px-6 text-base font-black text-gray-800">1</span>
                                <button id="btn-plus" class="w-10 h-10 flex items-center justify-center bg-white rounded-2xl shadow-sm text-gray-700 font-bold hover:text-orange-600 transition text-lg">+</button>
                            </div>
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button id="focus-ar-button" class="flex-1 sm:flex-none rounded-2xl sm:rounded-3xl bg-blue-500 px-4 py-3 text-xs sm:text-sm font-semibold text-white transition hover:bg-blue-600 shadow-md">Lihat 3D</button>
                            <button id="focus-close-button" class="flex-1 sm:flex-none rounded-2xl sm:rounded-3xl bg-gray-100 px-4 py-3 text-xs sm:text-sm font-semibold text-gray-600 transition hover:bg-gray-200">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Floating Cart --}}
    <div id="floating-cart" class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)] p-4 z-40 transition-transform duration-300 transform translate-y-full flex justify-between items-center cursor-pointer rounded-t-3xl sm:px-8">
        <div class="flex items-center gap-4">
            <div class="relative">
                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span id="cart-badge-floating" class="absolute -top-2 -right-2 bg-red-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full border-2 border-white">0</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pesanan</span>
                <span id="cart-total-floating" class="text-lg font-black text-gray-900 leading-none mt-1">Rp 0</span>
            </div>
        </div>
        <button id="btn-show-cart" class="bg-orange-500 text-white px-6 py-2.5 rounded-2xl text-sm font-bold shadow-lg hover:bg-orange-600 transition">Lihat Keranjang</button>
    </div>

    {{-- Cart Modal --}}
    <div id="cart-modal" class="hidden fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/40 backdrop-blur-sm p-0 sm:p-4 transition-opacity">
        <div class="w-full max-w-lg bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-4 sm:p-5 border-b border-gray-100 flex justify-between items-center bg-white">
                <h2 class="text-lg sm:text-xl font-black text-gray-800">Keranjang Pesanan</h2>
                <button id="close-cart-modal" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 font-bold transition">&times;</button>
            </div>
            <div id="cart-items-container" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50"></div>
            <div class="p-4 sm:p-5 bg-white border-t border-gray-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Total Tagihan</span>
                    <span id="cart-modal-total" class="text-xl sm:text-2xl font-black text-orange-600">Rp 0</span>
                </div>
                <button id="btn-checkout-modal" class="w-full bg-orange-500 hover:bg-orange-600 transition text-white py-3.5 rounded-2xl font-bold text-sm sm:text-base shadow-lg shadow-orange-500/30">Checkout Pesanan</button>
            </div>
        </div>
    </div>

    {{-- Checkout Modal --}}
    <div id="checkout-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-white w-full max-w-md rounded-3xl p-5 sm:p-6 shadow-2xl relative">
            <button id="close-checkout-modal" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 font-bold transition">&times;</button>
            <h2 class="text-xl font-black text-gray-800 mb-5">Detail Pemesan</h2>
            
            <form id="checkout-form" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Nama Pemesan <span class="text-red-500">*</span></label>
                    <input type="text" id="checkout-name" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3.5 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:bg-white transition" placeholder="Masukkan nama Anda">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Nomor HP <span class="text-red-500">*</span></label>
                    <input type="tel" id="checkout-phone" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3.5 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:bg-white transition" placeholder="Contoh: 08123456789">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Nomor Meja <span class="text-red-500">*</span></label>
                    <input type="text" id="checkout-table" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3.5 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:bg-white transition" placeholder="Contoh: 12">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Saran / Catatan Tambahan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <textarea id="checkout-notes" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3.5 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:bg-white transition" placeholder="Contoh: Es dipisah, dll..."></textarea>
                </div>
                
                <button type="submit" id="btn-submit-order" class="w-full bg-orange-500 hover:bg-orange-600 transition text-white py-3.5 rounded-2xl font-bold text-sm sm:text-base shadow-lg shadow-orange-500/30 mt-2">Konfirmasi & Kirim Pesanan</button>
            </form>
        </div>
    </div>

    {{-- Success Modal --}}
    <div id="success-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl transform transition-all duration-300 scale-90 opacity-0" id="success-modal-content">
            <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mb-6 success-checkmark">
                    <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" class="checkmark-path"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-800 mb-3">Berhasil!</h2>
                <p class="text-gray-600 font-medium leading-relaxed">Pesanan Anda berhasil dikirim ke dapur! Silakan tunggu.</p>
                <div class="mt-8 w-full">
                    <button id="btn-success-close" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-2xl font-bold text-sm shadow-lg shadow-orange-500/30 transition-all active:scale-95">OKE</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .checkmark-path {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: dash 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards 0.3s;
        }
        @keyframes dash {
            from { stroke-dashoffset: 100; }
            to { stroke-dashoffset: 0; }
        }
        .success-checkmark {
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        #success-modal.show {
            opacity: 1;
        }
        #success-modal.show #success-modal-content {
            transform: scale(1);
            opacity: 1;
        }
    </style>

    <script>
       const CART_KEY = 'angkringan_cart';

function getCart() {
    try { 
        return JSON.parse(localStorage.getItem(CART_KEY)) || []; 
    } catch { 
        return []; 
    }
}

function saveCart(cart) { 
    localStorage.setItem(CART_KEY, JSON.stringify(cart)); 
}

function updateFab() {
    updateFloatingCart();
}

function updateFloatingCart() {
    const cart = getCart();
    const totalQty = cart.reduce((s, i) => s + i.qty, 0);
    const totalPrice = cart.reduce((s, i) => s + (i.price * i.qty), 0);
    
    const floatingCart = document.getElementById('floating-cart');
    if (floatingCart) {
        if (totalQty > 0) {
            floatingCart.classList.remove('translate-y-full');
            document.getElementById('cart-badge-floating').textContent = totalQty;
            document.getElementById('cart-total-floating').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice);
        } else {
            floatingCart.classList.add('translate-y-full');
        }
    }
}

function updateModalCartControls() {
    if (!focusedProduct) return;
    const cart = getCart();
    const item = cart.find(i => i.id === focusedProduct.id);
    const btnTambah = document.getElementById('btn-tambah');
    const qtyControls = document.getElementById('qty-controls');
    
    if (item && item.qty > 0) {
        btnTambah.classList.add('hidden');
        qtyControls.classList.remove('hidden');
        qtyControls.classList.add('flex');
        document.getElementById('qty-display').textContent = item.qty;
    } else {
        btnTambah.classList.remove('hidden');
        qtyControls.classList.add('hidden');
        qtyControls.classList.remove('flex');
    }
}

window.changeQty = function(productId, delta) {
    let cart = getCart();
    // Pastikan ID dicocokkan dengan tipe data angka yang sama
    const idx = cart.findIndex(i => Number(i.id) === Number(productId));
    
    if (idx > -1) {
        cart[idx].qty += delta;
        if (cart[idx].qty <= 0) {
            cart.splice(idx, 1);
        }
    } else if (delta > 0 && focusedProduct && Number(focusedProduct.id) === Number(productId)) {
        cart.push({ ...focusedProduct, qty: 1 });
    }
    
    saveCart(cart);
    updateFab();
    if (focusedProduct && Number(focusedProduct.id) === Number(productId)) {
        updateModalCartControls();
    }
    renderCartModal();
};

function renderCartModal() {
    const cart = getCart();
    const container = document.getElementById('cart-items-container');
    const totalEl = document.getElementById('cart-modal-total');
    const btnCheckout = document.getElementById('btn-checkout-modal');
    
    container.innerHTML = '';
    let total = 0;
    
    if (cart.length === 0) {
        container.innerHTML = '<div class="text-center py-10 text-gray-400 font-medium">Keranjang masih kosong</div>';
        btnCheckout.disabled = true;
        btnCheckout.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        btnCheckout.disabled = false;
        btnCheckout.classList.remove('opacity-50', 'cursor-not-allowed');
        
        cart.forEach(item => {
            total += item.price * item.qty;
            container.innerHTML += `
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100 flex gap-3 items-center">
                    <img src="${item.image}" class="w-16 h-16 object-cover rounded-xl bg-gray-50">
                    <div class="flex-1">
                        <h4 class="font-bold text-sm text-gray-800 line-clamp-1">${item.name}</h4>
                        <div class="text-orange-600 font-black text-sm">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</div>
                    </div>
                    <div class="flex items-center bg-gray-50 rounded-xl p-1 border border-gray-100">
                        <button onclick="window.changeQty(${item.id}, -1)" class="w-7 h-7 flex items-center justify-center bg-white rounded-lg shadow-sm text-gray-700 font-bold hover:text-orange-600">-</button>
                        <span class="px-3 text-sm font-black text-gray-800">${item.qty}</span>
                        <button onclick="window.changeQty(${item.id}, 1)" class="w-7 h-7 flex items-center justify-center bg-white rounded-lg shadow-sm text-gray-700 font-bold hover:text-orange-600">+</button>
                    </div>
                </div>
            `;
        });
    }
    totalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
}

let focusedProduct = null;

function decodeHTML(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

document.addEventListener('DOMContentLoaded', function () {
    const mainContainer = document.getElementById('main-product-container');
    const overlay = document.getElementById('product-focus-overlay');
    const closeButtons = document.querySelectorAll('#product-focus-close, #focus-close-button');
    const arButton = document.getElementById('focus-ar-button');

    // Inisialisasi Tampilan Awal Keranjang saat halaman dimuat
    updateFab();

    // Event Delegation untuk Product Card & Pagination
    if (mainContainer) {
        mainContainer.addEventListener('click', function(e) {
            const card = e.target.closest('.product-card');
            if (card) {
                e.preventDefault();
                e.stopPropagation();
                openProductDetail(card);
            }

            const paginationLink = e.target.closest('.ajax-pagination a');
            if (paginationLink) {
                e.preventDefault();
                fetchProducts(paginationLink.href);
            }
        });
    }

    // Handle Category Filter AJAX
    document.querySelectorAll('.ajax-filter').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            const category = this.dataset.category;
            
            // Sync hidden search input
            const searchCat = document.getElementById('search-category');
            if (searchCat) searchCat.value = category;

            // Update UI Active State
            document.querySelectorAll('.ajax-filter').forEach(b => {
                b.className = 'category-btn ajax-filter inline-block whitespace-nowrap px-4 sm:px-10 py-2 sm:py-3.5 rounded-xl sm:rounded-2xl text-[11px] sm:text-base font-black uppercase tracking-wider transition-all bg-white text-gray-500 hover:bg-orange-50 border border-gray-100 sm:border-transparent';
            });
            
            this.className = 'category-btn ajax-filter inline-block whitespace-nowrap px-4 sm:px-10 py-2 sm:py-3.5 rounded-xl sm:rounded-2xl text-[11px] sm:text-base font-black uppercase tracking-wider transition-all bg-orange-500 text-white shadow-lg shadow-orange-500/30 scale-105';

            // Smooth scroll on mobile to keep selected category visible
            this.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

            fetchProducts(url);
        });
    });

    // Handle Search Form AJAX
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    if (searchForm && searchInput) {
        let timeout = null;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const formData = new FormData(searchForm);
                const params = new URLSearchParams(formData);
                const url = searchForm.action + '?' + params.toString();
                fetchProducts(url);
            }, 500);
        });

        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(searchForm);
            const params = new URLSearchParams(formData);
            const url = searchForm.action + '?' + params.toString();
            fetchProducts(url);
        });
    }

    function fetchProducts(url) {
        if (!mainContainer) return;
        mainContainer.classList.add('opacity-50', 'pointer-events-none');
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.text())
        .then(html => {
            mainContainer.innerHTML = html;
            mainContainer.classList.remove('opacity-50', 'pointer-events-none');
            window.history.pushState({}, '', url);
            
            // Scroll to top of product list for better UX on mobile
            const rect = mainContainer.getBoundingClientRect();
            if (rect.top < 0) {
                window.scrollTo({
                    top: window.pageYOffset + rect.top - 100,
                    behavior: 'smooth'
                });
            }
        })
        .catch(err => {
            console.error(err);
            mainContainer.classList.remove('opacity-50', 'pointer-events-none');
        });
    }

    document.getElementById('btn-tambah').addEventListener('click', () => { 
        if(focusedProduct) window.changeQty(focusedProduct.id, 1); 
    });
    document.getElementById('btn-plus').addEventListener('click', () => { 
        if(focusedProduct) window.changeQty(focusedProduct.id, 1); 
    });
    document.getElementById('btn-minus').addEventListener('click', () => { 
        if(focusedProduct) window.changeQty(focusedProduct.id, -1); 
    });

    if (arButton) {
        arButton.addEventListener('click', function () {
            if (arButton.disabled) return;
            const arUrl = '/ar.html'
                + '?name=' + encodeURIComponent(document.getElementById('focus-name').textContent)
                + '&price=' + encodeURIComponent(document.getElementById('focus-price').textContent)
                + '&description=' + encodeURIComponent(document.getElementById('focus-description').textContent)
                + '&composition=' + encodeURIComponent(document.getElementById('focus-composition').textContent)
                + '&model=' + encodeURIComponent(arButton.getAttribute('data-model-3d') || '');
            window.location.href = arUrl;
        });
    }

    function openProductDetail(card) {
        const grid = document.querySelector('.product-grid');
        if (!card || !grid) return;

        const priceRaw = card.dataset.price || '0';
        const model3d = card.getAttribute('data-model-3d') || '';
        const description = decodeHTML(card.dataset.description || 'Deskripsi tidak tersedia');
        const composition = decodeHTML(card.dataset.composition || 'Komposisi tidak tersedia');
        const productType = card.dataset.type || '';

        // Membersihkan string Rp 10.000 menjadi integer murni 10000
        const parsedPrice = parseInt(priceRaw.replace(/[^0-9]/g, ''), 10) || 0;

        focusedProduct = {
            id: parseInt(card.dataset.productId, 10),
            name: decodeHTML(card.dataset.name),
            price: parsedPrice,
            image: card.dataset.image,
        };

        document.getElementById('focus-image').src = card.dataset.image;
        document.getElementById('focus-name').textContent = focusedProduct.name;
        document.getElementById('focus-price').textContent = priceRaw;
        document.getElementById('focus-description').textContent = description;
        document.getElementById('focus-composition').textContent = composition;
        document.getElementById('focus-type').textContent = productType;
        
        updateModalCartControls();
        
        if (arButton) {
            arButton.setAttribute('data-model-3d', model3d);
            arButton.disabled = !model3d;
            arButton.classList.toggle('opacity-50', !model3d);
            arButton.classList.toggle('cursor-not-allowed', !model3d);
            arButton.textContent = model3d ? 'Lihat dalam 3D' : 'Model 3D belum ada';
        }

        grid.classList.add('blur');
        card.classList.add('focused');
        overlay.classList.remove('hidden');
    }

    function closeFocus() {
        const grid = document.querySelector('.product-grid');
        if (!grid) return;
        grid.classList.remove('blur');
        document.querySelectorAll('.product-card.focused').forEach(c => c.classList.remove('focused'));
        overlay.classList.add('hidden');
        focusedProduct = null;
    }

    closeButtons.forEach(btn => btn.addEventListener('click', closeFocus));
    overlay.addEventListener('click', e => { if (e.target === overlay) closeFocus(); });
    
    // Penanganan Modal Keranjang Belanja
    const floatingCart = document.getElementById('floating-cart');
    const cartModal = document.getElementById('cart-modal');
    const checkoutModal = document.getElementById('checkout-modal');
    
    if(floatingCart) {
        floatingCart.addEventListener('click', (e) => {
            renderCartModal();
            cartModal.classList.remove('hidden');
        });
    }
    
    document.getElementById('close-cart-modal').addEventListener('click', () => cartModal.classList.add('hidden'));
    
    document.getElementById('btn-checkout-modal').addEventListener('click', () => {
        cartModal.classList.add('hidden');
        checkoutModal.classList.remove('hidden');
    });
    
    document.getElementById('close-checkout-modal').addEventListener('click', () => checkoutModal.classList.add('hidden'));
    
    // Submit Checkout ke Server
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const btnSubmit = document.getElementById('btn-submit-order');
            btnSubmit.textContent = 'Memproses...';
            btnSubmit.disabled = true;
            
            fetch('/api/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    customer_name: document.getElementById('checkout-name').value,
                    phone: document.getElementById('checkout-phone').value,
                    table_number: document.getElementById('checkout-table').value,
                    notes: document.getElementById('checkout-notes').value,
                    items: getCart()
                })
            })
            .then(res => {
                // Parse JSON dulu agar kita bisa lihat pesan error dari backend
                return res.json().then(body => {
                    if (!res.ok) {
                        // Tangani error validasi (422) secara spesifik
                        if (res.status === 422 && body.errors) {
                            const errorMessages = Object.values(body.errors).flat();
                            throw new Error(errorMessages[0] || 'Data yang dikirim tidak valid');
                        }
                        const msg = body?.message || 'Gagal melakukan checkout ke server';
                        throw new Error(msg);
                    }
                    return body;
                });
            })
            .then(data => {
                // 1. Sembunyikan modal checkout terlebih dahulu
                document.getElementById('checkout-modal').classList.add('hidden'); 

                // 2. SEGERA HAPUS data keranjang dari penyimpanan browser
                localStorage.removeItem(CART_KEY);

                // 2b. Paksa state cart UI agar langsung kosong (tanpa menunggu reload)
                const emptyCart = [];
                // rendering modal cart berdasarkan localStorage
                saveCart(emptyCart);
                renderCartModal();
                updateFab();

                
                // 3. Kembalikan tombol ke mode normal (biar tidak stuck "Memproses...")
                btnSubmit.textContent = 'Konfirmasi & Kirim Pesanan';
                btnSubmit.disabled = false;

                // 5. Tampilkan Animasi Sukses
                const successModal = document.getElementById('success-modal');
                if (successModal) {
                    successModal.classList.remove('hidden');
                    // Force reflow
                    successModal.offsetHeight;
                    successModal.classList.add('show');

                    document.getElementById('btn-success-close').addEventListener('click', () => {
                        window.location.reload();
                    });
                } else {
                    alert('Pesanan Anda berhasil dikirim ke dapur! Silakan tunggu.');
                    window.location.reload();
                }
            })
            .catch(err => {
                console.error(err);
                alert(err?.message || 'Terjadi kesalahan.');
                // Pastikan tombol tidak tetap "Memproses..."
                btnSubmit.textContent = 'Konfirmasi & Kirim Pesanan';
                btnSubmit.disabled = false;
            });

        });
});

    </script>

</body>
</html>
