<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<body class="bg-gray-200 pb-32">

    <div class="relative w-full h-48 sm:h-64 md:h-80 bg-orange-500 overflow-hidden shadow-md hero-banner">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
        <div class="absolute bottom-4 sm:bottom-6 md:bottom-8 left-4 sm:left-6 md:left-8 z-20 text-white">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight drop-shadow-xl">Angkringan Modern</h1>
            <p class="text-xs sm:text-sm md:text-base font-medium opacity-90 mt-1"><span>Jl. Utama No. 12</span></p>
        </div>
    </div>

    <div class="px-3 sm:px-4 mt-4 sm:mt-6">
        <form action="{{ route('index') }}" method="GET" class="relative">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="block w-full pl-10 pr-3 py-2 sm:py-3 border-none bg-gray-100 rounded-2xl leading-5 focus:outline-none focus:ring-2 focus:ring-orange-500 text-xs sm:text-sm transition-all"
                   placeholder="Cari menu...">
        </form>
    </div>

    <div class="px-3 sm:px-4 my-4 sm:my-6">
        <div class="snap-x-container flex gap-2 sm:gap-3 pb-2 no-scrollbar overflow-x-auto justify-start md:justify-center">
            @php $currentCat = request('category', 'semua'); @endphp
            @foreach(['semua', 'makanan', 'minuman', 'snack'] as $cat)
            <div class="snap-item">
                <a href="{{ route('index', ['category' => $cat]) }}"
                   class="category-btn inline-block whitespace-nowrap px-4 sm:px-6 md:px-8 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all
                   {{ $currentCat == $cat ? 'bg-orange-500 text-white shadow-lg' : 'bg-gray-100 text-gray-500' }}">
                   {{ ucfirst($cat) }}
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="w-full px-3 sm:px-4 py-3 sm:py-4">
        <h2 class="text-lg sm:text-xl font-extrabold text-gray-800 mb-4 sm:mb-6 px-1 flex items-center gap-2">
            <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
            <span class="truncate">Daftar Menu {{ $currentCat !== 'semua' ? ucfirst($currentCat) : '' }}</span>
        </h2>

        <div class="grid product-grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-3 md:gap-4">
            @forelse($products as $product)
            <div class="product-card flex flex-col group bg-white rounded-2xl sm:rounded-3xl p-2 sm:p-3 shadow-lg shadow-gray-300/70 border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-gray-400/60"
                 data-product-id="{{ $product->id }}"
                 data-name="{{ htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8') }}"
                 data-price="Rp {{ number_format($product->price, 0, ',', '.') }}"
                 data-description="{{ htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8') }}"
                 data-composition="{{ htmlspecialchars($product->composition ?? '', ENT_QUOTES, 'UTF-8') }}"
                 data-type="{{ htmlspecialchars($product->type ?? '', ENT_QUOTES, 'UTF-8') }}"
                 data-image="{{ $product->images ? asset('storage/' . $product->images) : asset('images/air.jpg') }}"
                 data-model-3d="{{ $product->model_3d ? asset('storage/' . $product->model_3d) : '' }}">
                <div class="relative aspect-square rounded-xl sm:rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50 mb-1 sm:mb-2 cursor-pointer product-image-container">
                    @if($product->images)
                        <img src="{{ asset('storage/' . $product->images) }}"
                             alt="{{ $product->name }}"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover transition-transform group-hover:scale-110">
                    @else
                        <img src="{{ asset('images/air.jpg') }}" alt="{{ $product->name }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition"></div>
                </div>
                <div class="px-0.5">
                    <div class="mb-0.5 sm:mb-1">
                        @php
                            $badgeColor = match($product->type) {
                                'makanan' => 'bg-orange-100 text-orange-600',
                                'minuman' => 'bg-blue-100 text-blue-600',
                                'snack'   => 'bg-green-100 text-green-600',
                                default   => 'bg-gray-100 text-gray-600'
                            };
                        @endphp
                        <span class="text-[7px] sm:text-[9px] font-extrabold uppercase tracking-widest px-1.5 sm:px-2 py-0.5 rounded-md {{ $badgeColor }}">
                            {{ $product->type ?? 'Menu' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-xs sm:text-sm leading-tight mb-0.5 truncate">{{ $product->name }}</h3>
                    <p class="text-xs sm:text-sm font-bold text-orange-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-gray-400 font-medium">Menu tidak ditemukan...</p>
                <a href="{{ route('index') }}" class="text-orange-500 font-bold text-sm mt-2 block">Lihat Semua Menu</a>
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
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
                        <p id="focus-description" class="mb-3 sm:mb-4 text-xs sm:text-sm leading-relaxed text-slate-600 min-h-[2rem] whitespace-pre-wrap"></p>
                        <div class="rounded-2xl sm:rounded-3xl bg-orange-50 p-3 sm:p-4 text-xs sm:text-sm text-slate-700">
                            <div class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-orange-700">Komposisi</div>
                            <p id="focus-composition" class="leading-relaxed min-h-[1rem] whitespace-pre-wrap"></p>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-6 modal-buttons flex flex-wrap gap-2 sm:gap-3 justify-end">
                        <button id="focus-ar-button" class="rounded-2xl sm:rounded-3xl bg-blue-500 px-4 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-semibold text-white transition hover:bg-blue-600 shadow-lg">Lihat 3D</button>
                        <button id="focus-close-button" class="rounded-2xl sm:rounded-3xl bg-gray-100 px-4 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-semibold text-gray-600 transition hover:bg-gray-200">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const CART_KEY = 'angkringan_cart';
        function getCart() {
            try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; }
            catch { return []; }
        }
        function saveCart(cart) { localStorage.setItem(CART_KEY, JSON.stringify(cart)); }
        function updateFab() {
            const cart = getCart();
            const total = cart.reduce((s, i) => s + i.qty, 0);
            const badge = document.getElementById('cart-badge');
            const fab = document.getElementById('cart-fab');
            if (badge) badge.textContent = total;
            if (fab) fab.classList.toggle('hidden', total === 0);
        }
        function addToCart(product) {
            let cart = getCart();
            const idx = cart.findIndex(i => i.id === product.id);
            if (idx > -1) { cart[idx].qty++; } else { cart.push({ ...product, qty: 1 }); }
            saveCart(cart);
            updateFab();
        }

        updateFab();
        let focusedProduct = null;

        // Helper untuk decode HTML entities
        function decodeHTML(html) {
            const txt = document.createElement('textarea');
            txt.innerHTML = html;
            return txt.value;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const grid = document.querySelector('.product-grid');
            const overlay = document.getElementById('product-focus-overlay');
            const closeButtons = document.querySelectorAll('#product-focus-close, #focus-close-button');
            const arButton = document.getElementById('focus-ar-button');

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

                const price = card.dataset.price;
                const model3d = card.dataset.model3d || '';
                const description = decodeHTML(card.dataset.description || 'Deskripsi tidak tersedia');
                const composition = decodeHTML(card.dataset.composition || 'Komposisi tidak tersedia');
                const productType = card.dataset.type || '';

                console.log('Product Detail:', {
                    name: card.dataset.name,
                    description: description,
                    composition: composition,
                    type: productType
                });

                focusedProduct = {
                    id: parseInt(card.dataset.productId, 10),
                    name: card.dataset.name,
                    price: parseInt(price.replace(/[^0-9]/g, ''), 10),
                    image: card.dataset.image,
                };

                document.getElementById('focus-image').src = card.dataset.image;
                document.getElementById('focus-name').textContent = decodeHTML(card.dataset.name);
                document.getElementById('focus-price').textContent = price;
                document.getElementById('focus-description').textContent = description;
                document.getElementById('focus-composition').textContent = composition;
                document.getElementById('focus-type').textContent = productType;
                
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

            // Klik pada card produk untuk buka detail
            document.querySelectorAll('.product-card').forEach(function (card) {
                card.style.cursor = 'pointer';
                card.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Card clicked:', this.dataset.name);
                    openProductDetail(this);
                });
            });
            
            // Debug: Check if DOMContentLoaded fired
            console.log('DOMContentLoaded fired. Cards attached:', document.querySelectorAll('.product-card').length);

            function closeFocus() {
                if (!grid) return;
                grid.classList.remove('blur');
                document.querySelectorAll('.product-card.focused').forEach(c => c.classList.remove('focused'));
                overlay.classList.add('hidden');
                focusedProduct = null;
            }

            closeButtons.forEach(btn => btn.addEventListener('click', closeFocus));
            overlay.addEventListener('click', e => { if (e.target === overlay) closeFocus(); });
        });
    </script>

</body>
</html>
