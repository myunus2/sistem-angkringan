<x-filament-panels::page>
    <style>
        /* ====================================================================
           DESAIN UTAMA KASIR (LIGHT MODE DEFAULT)
           ==================================================================== */
        .category-btn { 
            transition: all 0.3s; 
            border: 1px solid #e5e7eb; 
            background: white; 
            color: #4b5563;
            font-size: clamp(0.65rem, 2vw, 0.75rem); 
            padding: clamp(0.4rem, 2vw, 0.5rem) clamp(0.75rem, 3vw, 1.25rem); 
        }
        
        .category-active { 
            background-color: #f97316 !important; 
            color: white !important; 
            border-color: #f97316 !important; 
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.2); 
        }
        
        .product-card { 
            border-radius: 1.25rem; 
            border: 1px solid #f3f4f6; 
            background: white; 
            transition: all 0.2s; 
            text-align: left; 
            overflow: hidden; 
            min-height: 220px; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
        }
        
        .product-card:hover { 
            border-color: #f97316; 
            transform: translateY(-3px); 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); 
        }
        
        .product-qty-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            z-index: 20;
            min-width: 1.75rem;
            height: 1.75rem;
            padding: 0 0.45rem;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f97316;
            color: white;
            font-size: 0.75rem;
            font-weight: 900;
            line-height: 1;
            box-shadow: 0 8px 18px -8px rgba(249, 115, 22, 0.75);
            border: 2px solid white;
        }
        
        .price-tag { color: #f97316; font-weight: 800; }
        
        .cart-container { 
            border-radius: 1.5rem; 
            background: white; 
            border: 1px solid #f3f4f6; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); 
        }
        
        .btn-pay { 
            background-color: #f97316 !important; 
            color: white !important; 
            font-weight: 800 !important; 
            border-radius: 0.75rem !important; 
            min-height: 3rem; 
        }
        
        .btn-pay:hover { background-color: #ea580c !important; }

        /* Pembatas khusus agar icon SVG internal tidak merusak sidebar Filament */
        .cart-container svg { width: 1.25rem !important; height: 1.25rem !important; }
        .cart-container .big-icon svg { width: 4rem !important; height: 4rem !important; margin-bottom: 1rem; opacity: 0.2; }

        /* ====================================================================
           FORCE STYLE INPUT KASIR (TEKS HITAM PEKAT & PLACEHOLDER MIRING ABU)
           ==================================================================== */
        /* Memaksa tulisan Label di atas kotak input (Nama Pelanggan & No Meja) menjadi HITAM */
        .cart-container label {
            color: #313131 !important;
            font-weight: 900 !important;
        }

        /* Memaksa teks yang DIKETIK oleh kasir menjadi HITAM PEKAT */
        .cart-container input[type="text"] {
            color: #0f0f0f !important; 
            font-weight: 700 !important;
        }

        /* Memaksa teks petunjuk (placeholder) tetap abu-abu dan miring */
        .cart-container input[type="text"]::placeholder {
            color: #9ca3af !important; 
            font-style: italic !important; 
            font-weight: 500 !important;
        }

        /* ====================================================================
           PERBAIKAN FITUR DARK MODE UNTUK ELEMEN KUSTOM (KASIR)
           ==================================================================== */
        /* 1. KATEGORI MENU */
        .dark .category-btn {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }
        .dark .category-active {
            background-color: #f97316 !important;
            color: white !important;
            border-color: #f97316 !important;
        }

        /* 2. KARTU PRODUK / MENU */
        .dark .product-card {
            background: #1e293b !important;
            border-color: #334155 !important;
        }
        .dark .product-card h4 {
            color: #f1f5f9 !important;
        }
        .dark .product-card .bg-gray-50 {
            background-color: #0f172a !important;
        }
        .dark .product-card .bg-white\/90 {
            background-color: rgba(15, 23, 42, 0.85) !important;
        }
        .dark .product-qty-badge {
            border-color: #1e293b !important;
        }

        /* 3. DETAIL PESANAN / KERANJANG */
        .dark .cart-container {
            background: #1e293b !important;
            border-color: #334155 !important;
        }
        .dark .cart-container h2, 
        .dark .cart-container .font-bold {
            color: #f1f5f9 !important;
        }
        .dark .cart-container .bg-gray-50 {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        .dark .cart-container .text-gray-900 {
            color: #f8fafc !important;
        }
        .dark .cart-container .border-gray-50,
        .dark .cart-container .border-gray-100 {
            border-color: #334155 !important;
        }
        .dark .cart-container button.bg-white {
            background-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        
        /* 4. SINKRONISASI INPUT KASIR SAAT DARK MODE AKTIF */
        .dark .cart-container .fi-input-wrp {
            border-color: #475569 !important; /* Warna border kotak saat malam */
        }
        .dark .cart-container label {
            color: #f1f5f9 !important; /* Mengubah label menjadi putih saat malam */
        }
        .dark .cart-container input[type="text"] {
            color: #ffffff !important; /* Mengubah tulisan ketikan menjadi putih saat malam */
        }
        .dark .cart-container input[type="text"]::placeholder {
            color: #6b7280 !important;
        }

        /* ====================================================================
           RANCANGAN GRID RESPONSIVE (2-3-4 KOLOM)
           ==================================================================== */
        .pos-grid { 
            display: grid; 
            grid-template-columns: repeat(2, minmax(0, 1fr)); 
            gap: 0.75rem; 
        }
        
        @media (min-width: 640px) { 
            .pos-grid { 
                grid-template-columns: repeat(3, minmax(0, 1fr)); 
                gap: 1rem; 
            } 
        }
        
        @media (min-width: 1280px) { 
            .pos-grid { 
                grid-template-columns: repeat(4, minmax(0, 1fr)); 
                gap: 1.25rem; 
            } 
        }
        
        .checkout-banner {
            background: rgba(255,255,255,0.92);
            border: 1px solid #e5e5e5;
            border-radius: 1.25rem;
            padding: 1rem 1.25rem;
            box-shadow: 0 15px 35px -20px rgba(15, 23, 42, 0.18);
        }
        .checkout-banner .title {
            font-weight: 800;
            color: #111827;
            letter-spacing: 0.02em;
        }
        .checkout-banner .summary {
            color: #6b7280;
            font-size: 0.9rem;
        }
        .checkout-banner .btn-checkout {
            background-color: #f97316 !important;
            color: white !important;
            padding: 0.85rem 1.25rem !important;
            border-radius: 999px !important;
            font-weight: 700 !important;
        }

        /* RESPONSIVE LAYOUT UNTUK SIDEBAR MOBILE */
        @media (max-width: 1024px) {
            body.kasir-page .fi-main-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            body.kasir-page .fi-main-sidebar.fi-sidebar-open {
                transform: translateX(0) !important;
                display: flex !important;
                position: fixed;
                z-index: 50;
            }
            body.kasir-page .fi-sidebar-open-overlay {
                position: fixed;
                inset: 0;
                z-index: 40;
                background-color: rgba(0, 0, 0, 0.4);
            }
            body.kasir-page .fi-main-ctn {
                margin-left: 0 !important;
                padding-left: 0 !important;
                display: block !important;
            }
            body.kasir-page .fi-main {
                margin-left: 0 !important;
                width: auto !important;
            }
        }
    </style>
    </style>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 pt-2 lg:pt-0 lg:-mt-6 px-1 md:px-4 lg:px-0 w-full items-start">
        
        <div class="order-first lg:order-last w-full lg:w-[400px] flex-shrink-0">
            <div class="cart-container p-4 md:p-6 lg:sticky lg:top-4">
                <div class="flex justify-between items-center mb-4 border-b border-gray-50 pb-3">
                    <h2 class="font-black text-base md:text-lg text-gray-900 uppercase tracking-tight">Detail Pesanan</h2>
                    <div class="text-[9px] md:text-[10px] font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-lg uppercase tracking-widest">
                        {{ count($cart) }} Items
                    </div>
                </div>

                <!-- INPUT DENGAN BORDER TEGAS, TEKS HITAM & PLACEHOLDER MIRING -->
               <!-- POTONGAN KODE LABEL YANG DIUBAH MENJADI HITAM -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <!-- text-black memaksa tulisan label menjadi hitam pekat -->
                        <label class="text-xs font-black uppercase tracking-wider text-black dark:text-white mb-1 block">Nama Pelanggan</label>
                        <x-filament::input.wrapper 
                            class="rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-orange-500 transition-all duration-200"
                            style="border: 2px solid #cbd5e1 !important;"
                        >
                            <x-filament::input 
                                type="text"
                                class="w-full text-base font-bold py-3.5 text-black dark:text-white placeholder:text-gray-400 placeholder:italic bg-transparent border-none focus:ring-0" 
                                wire:model.defer="customerName" 
                            
                            />
                        </x-filament::input.wrapper>
                    </div>
                    <div>
                        <!-- text-black memaksa tulisan label menjadi hitam pekat -->
                        <label class="text-xs font-black uppercase tracking-wider text-black dark:text-white mb-1 block">Nomor Meja</label>
                        <x-filament::input.wrapper 
                            class="rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-orange-500 transition-all duration-200"
                            style="border: 2px solid #cbd5e1 !important;"
                        >
                            <x-filament::input 
                                type="text"
                                class="w-full text-base font-bold py-3.5 text-black dark:text-white placeholder:text-gray-400 placeholder:italic bg-transparent border-none focus:ring-0" 
                                wire:model.defer="tableNumber" 
                            
                            />
                        </x-filament::input.wrapper>
                    </div>
                </div>

                <div class="space-y-3 max-h-[220px] lg:max-h-[350px] overflow-y-auto mb-4 pr-2">
                    @forelse($cart as $id => $item)
                    <div class="flex justify-between items-center group pb-3 border-b border-gray-50 gap-2">
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-xs md:text-sm text-gray-800 truncate">{{ $item['name'] }}</div>
                            <div class="price-tag text-[10px]">Rp {{ number_format($item['price']) }}</div>
                        </div>
                        
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <div class="flex items-center bg-gray-50 rounded-lg p-0.5 border border-gray-100">
                                <button type="button" wire:click="decrementQty({{ $id }})" class="w-6 h-6 flex items-center justify-center bg-white rounded-md shadow-sm hover:text-orange-600 transition active:scale-90">
                                    <x-heroicon-m-minus class="w-3 h-3"/>
                                </button>
                                <span class="px-2 text-xs font-black text-gray-700">{{ $item['qty'] }}</span>
                                <button type="button" wire:click="incrementQty({{ $id }})" class="w-6 h-6 flex items-center justify-center bg-white rounded-md shadow-sm hover:text-orange-600 transition active:scale-90">
                                    <x-heroicon-m-plus class="w-3 h-3"/>
                                </button>
                            </div>

                            <div class="text-right min-w-[65px] flex-shrink-0">
                                <div class="font-black text-xs text-gray-900">Rp {{ number_format($item['qty'] * $item['price']) }}</div>
                            </div>
                            
                            <button type="button" wire:click="removeItem({{ $id }})" class="text-red-400 hover:text-red-500 transition-colors flex-shrink-0">
                                <x-heroicon-m-trash class="w-4 h-4"/>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 big-icon flex flex-col items-center">
                        <x-heroicon-o-shopping-bag />
                        <p class="text-gray-400 text-xs italic font-medium">Keranjang masih kosong</p>
                    </div>
                    @endforelse
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex flex-col gap-0.5 mb-4 text-right">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Total Bayar</span>
                        <span class="text-2xl font-black text-orange-600 tracking-tighter">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>

                    <x-filament::button 
                        type="button"
                        wire:click="checkout" 
                        size="xl" 
                        class="w-full btn-pay py-3  uppercase tracking-widest text-xs"
                    >
                        Konfirmasi
                    </x-filament::button>
                </div>
            </div>
        </div>

        <div class="w-full flex-1 lg:order-first mt-4 lg:mt-0">
            <div class="mb-4">
                <x-filament::input.wrapper 
                    prefix-icon="heroicon-m-magnifying-glass"
                    class="rounded-xl focus-within:ring-2 focus-within:ring-orange-500"
                >
                    <!-- py-3.5 (besar di mobile) -> lg:py-2 (kembali standar di desktop) -->
                    <!-- text-base (besar di mobile) -> lg:text-sm (kembali standar di desktop) -->
                    <x-filament::input 
                        type="text" 
                        wire:model.live="search" 
                        placeholder="Cari menu..." 
                        class="text-base font-medium py-3.5 md:py-4 lg:py-2 lg:text-sm border-none focus:ring-0"
                    />
                </x-filament::input.wrapper>
            </div>

            <div class="flex flex-wrap gap-1.5 mb-6">
                @foreach($categories as $cat)
                    <button 
                        wire:click="setCategory('{{ $cat }}')"
                        class="category-btn rounded-full transition-all {{ $activeCategory == $cat ? 'category-active' : 'text-gray-500 hover:bg-gray-50' }}"
                    >
                        {{ ucfirst($cat) }}
                    </button>
                @endforeach
            </div>

            <div class="pos-grid">
                @forelse($products as $product)
                @php
                    $productQty = $cart[$product->id]['qty'] ?? 0;
                @endphp
                <button type="button" wire:click="addToCart({{ $product->id }})" class="product-card group relative p-1.5 md:p-3 transition active:scale-95">
                    @if($productQty > 0)
                        <span class="product-qty-badge">{{ $productQty }}</span>
                    @endif
                    <div class="relative overflow-hidden rounded-xl aspect-square mb-1.5 bg-gray-50">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <img src="{{ asset('images/air.jpg') }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute top-1 right-1 bg-white/90 backdrop-blur-sm px-1 py-0.5 rounded-md shadow-sm">
                            <span class="text-[7px] font-black text-orange-600 uppercase">{{ ucfirst($product->type ?? 'Menu') }}</span>
                        </div>
                    </div>
                    <div class="px-0.5">
                        <h4 class="font-bold text-gray-800 text-[10px] sm:text-xs md:text-sm truncate leading-tight">{{ $product->name }}</h4>
                        <p class="price-tag text-[10px] sm:text-xs md:text-sm mt-0.5 leading-none">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </button>
                @empty
                <!-- Tampilan ini akan muncul jika $products kosong -->
                <div class="col-span-full flex flex-col items-center justify-center py-12 px-4 text-center">
                    <div class="p-4 bg-gray-50 rounded-full text-gray-400 mb-3">
                        <x-heroicon-o-magnifying-glass class="w-8 h-8 opacity-40 mx-auto" style="width: 2.5rem !important; height: 2.5rem !important;"/>
                    </div>
                    <h3 class="text-sm font-bold text-gray-700">Menu Tidak Ditemukan</h3>
                @endforelse
            </div>
            
            @if($products->hasPages())
                <div class="mt-6 flex justify-center text-sm md:text-base 
                [&_.flex-1]:flex [&_.flex-1]:justify-between md:[&_.flex-1]:hidden 
                [&_nav_div:nth-child(2)]:hidden md:[&_nav_div:nth-child(2)]:flex">
                 {{ $products->links() }}
                 </div>
             @endif
        </div>

    </div>

@push('scripts')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const cartSidebar = document.getElementById('cart-sidebar-mobile');

        function closeFilamentSidebarOnMobile() {
            if (!window.matchMedia('(max-width: 1024px)').matches) {
                return;
            }

            const sidebar = document.querySelector('.fi-main-sidebar');
            if (sidebar) {
                sidebar.classList.remove('fi-sidebar-open');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.pathname.includes('/admin/kasir')) {
                document.body.classList.add('kasir-page');
            }
            closeFilamentSidebarOnMobile();
        });

        if (cartSidebar) {
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    cartSidebar.classList.add('translate-x-full');
                }
            });

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        const isOpen = !cartSidebar.classList.contains('translate-x-full');
                        document.body.style.overflow = isOpen ? 'hidden' : 'auto';
                    }
                });
            });
            
            observer.observe(cartSidebar, { attributes: true });

            document.addEventListener('click', function(event) {
                const isClickInsideCart = cartSidebar.contains(event.target);
                const isClickOnHamburger = event.target.closest('button[onclick*="cart-sidebar-mobile"]');
                const isClickOnBadge = event.target.closest('.cart-toggle-badge');
                const isOrderAction = event.target.closest('.product-card, .btn-pay, .btn-checkout, .checkout-banner');
                
                if (isOrderAction) {
                    closeFilamentSidebarOnMobile();
                }

                if (!isClickInsideCart && !isClickOnHamburger && !isClickOnBadge) {
                    if (!cartSidebar.classList.contains('translate-x-full')) {
                        cartSidebar.classList.add('translate-x-full');
                    }
                }
            });
        }
    </script>
@endpush
</x-filament-panels::page>
