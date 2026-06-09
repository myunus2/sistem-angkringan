<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Menu Angkringan Modern</title>
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
    background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.75)), url('<?php echo e(asset('images/image.png')); ?>');
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
<body class="bg-gray-200 pb-32">

    <div class="relative w-full h-48 sm:h-64 md:h-80 bg-orange-500 overflow-hidden shadow-md hero-banner">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
        <div class="absolute bottom-4 sm:bottom-6 md:bottom-8 left-4 sm:left-6 md:left-8 z-20 text-white">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight drop-shadow-xl">Angkringan Modern</h1>
            <p class="text-xs sm:text-sm md:text-base font-medium opacity-90 mt-1"><span>Cubadak</span></p>
        </div>
    </div>

    <div class="px-3 sm:px-4 mt-4 sm:mt-6">
        <form action="<?php echo e(route('index')); ?>" method="GET" class="relative">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('category')): ?>
                <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                   class="block w-full pl-10 pr-3 py-2 sm:py-3 border-none bg-gray-100 rounded-2xl leading-5 focus:outline-none focus:ring-2 focus:ring-orange-500 text-xs sm:text-sm transition-all"
                   placeholder="Cari menu...">
        </form>
    </div>

    <div class="px-3 sm:px-4 my-4 sm:my-6">
        <div class="snap-x-container flex gap-2 sm:gap-3 pb-2 no-scrollbar overflow-x-auto justify-start md:justify-center">
            <?php $currentCat = request('category', 'semua'); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['semua', 'makanan', 'minuman', 'snack']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="snap-item">
                <a href="<?php echo e(route('index', ['category' => $cat])); ?>"
                   class="category-btn inline-block whitespace-nowrap px-4 sm:px-6 md:px-8 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all
                   <?php echo e($currentCat == $cat ? 'bg-orange-500 text-white shadow-lg' : 'bg-gray-100 text-gray-500'); ?>">
                   <?php echo e(ucfirst($cat)); ?>

                </a>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    <div class="w-full px-3 sm:px-4 py-3 sm:py-4">
        <h2 class="text-lg sm:text-xl font-extrabold text-gray-800 mb-4 sm:mb-6 px-1 flex items-center gap-2">
            <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
            <span class="truncate">Daftar Menu <?php echo e($currentCat !== 'semua' ? ucfirst($currentCat) : ''); ?></span>
        </h2>

        <div class="grid product-grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-3 md:gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="product-card flex flex-col group bg-white rounded-2xl sm:rounded-3xl p-2 sm:p-3 shadow-lg shadow-gray-300/70 border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-gray-400/60"
                 data-product-id="<?php echo e($product->id); ?>"
                 data-name="<?php echo e(htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8')); ?>"
                 data-price="Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>"
                 data-description="<?php echo e(htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8')); ?>"
                 data-composition="<?php echo e(htmlspecialchars($product->composition ?? '', ENT_QUOTES, 'UTF-8')); ?>"
                 data-type="<?php echo e(htmlspecialchars($product->type ?? '', ENT_QUOTES, 'UTF-8')); ?>"
                 data-image="<?php echo e($product->images ? asset('storage/' . $product->images) : asset('images/air.jpg')); ?>"
                 data-model-3d="<?php echo e(trim($product->model_3d) ? asset('storage/' . trim($product->model_3d)) : ''); ?>">
                    <div class="relative aspect-square rounded-xl sm:rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50 mb-1 sm:mb-2 cursor-pointer product-image-container">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->images): ?>
                        <img src="<?php echo e(asset('storage/' . $product->images)); ?>"
                             alt="<?php echo e($product->name); ?>"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover transition-transform group-hover:scale-110">
                    <?php else: ?>
                        <img src="<?php echo e(asset('images/air.jpg')); ?>" alt="<?php echo e($product->name); ?>" loading="lazy" decoding="async" class="w-full h-full object-cover">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition"></div>
                </div>
                <div class="px-0.5">
                    <div class="mb-0.5 sm:mb-1">
                        <?php
                            $badgeColor = match($product->type) {
                                'makanan' => 'bg-orange-100 text-orange-600',
                                'minuman' => 'bg-blue-100 text-blue-600',
                                'snack'   => 'bg-green-100 text-green-600',
                                default   => 'bg-gray-100 text-gray-600'
                            };
                        ?>
                        <span class="text-[7px] sm:text-[9px] font-extrabold uppercase tracking-widest px-1.5 sm:px-2 py-0.5 rounded-md <?php echo e($badgeColor); ?>">
                            <?php echo e($product->type ?? 'Menu'); ?>

                        </span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-xs sm:text-sm leading-tight mb-0.5 truncate"><?php echo e($product->name); ?></h3>
                    <p class="text-xs sm:text-sm font-bold text-orange-600">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="col-span-full text-center py-20">
                <p class="text-gray-400 font-medium">Menu tidak ditemukan...</p>
                <a href="<?php echo e(route('index')); ?>" class="text-orange-500 font-bold text-sm mt-2 block">Lihat Semua Menu</a>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->hasPages()): ?>
            <div class="mt-8 flex justify-center">
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
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
                        <p id="focus-description" class="mb-3 sm:mb-4 text-xs sm:text-sm leading-relaxed text-slate-600 min-h-[2rem] whitespace-pre-wrap"></p>
                        <div class="rounded-2xl sm:rounded-3xl bg-orange-50 p-3 sm:p-4 text-xs sm:text-sm text-slate-700">
                            <div class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-orange-700">Komposisi</div>
                            <p id="focus-composition" class="leading-relaxed min-h-[1rem] whitespace-pre-wrap"></p>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-6 modal-buttons flex flex-col sm:flex-row gap-3 justify-between items-center">
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
    // Tambahkan baris ini di paling atas untuk mengosongkan memori setiap refresh:
    localStorage.removeItem(CART_KEY); 
    const grid = document.querySelector('.product-grid');
    const overlay = document.getElementById('product-focus-overlay');
    const closeButtons = document.querySelectorAll('#product-focus-close, #focus-close-button');
    const arButton = document.getElementById('focus-ar-button');

    // Inisialisasi Tampilan Awal Keranjang saat halaman dimuat
    updateFab();

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

    // Daftarkan event klik pada setiap produk card
    document.querySelectorAll('.product-card').forEach(function (card) {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openProductDetail(this);
        });
    });

    function closeFocus() {
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
                updateFab();

                renderCartModal();
                updateFab();

                
                // 3. Kembalikan tombol ke mode normal (biar tidak stuck "Memproses...")

                btnSubmit.textContent = 'Konfirmasi & Kirim Pesanan';
                btnSubmit.disabled = false;

                // 5. Berikan notifikasi sukses kepada pelanggan
                alert('Pesanan Anda berhasil dikirim ke dapur! Silakan tunggu.');

                // 6. Muat ulang halaman agar seluruh state aplikasi kembali bersih dan segar
                window.location.reload();
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
<?php /**PATH C:\xampp1\htdocs\sistem-angkringan\resources\views/order/index.blade.php ENDPATH**/ ?>