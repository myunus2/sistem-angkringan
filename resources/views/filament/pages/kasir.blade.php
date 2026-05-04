<x-filament-panels::page>
    <style>
        /* Desain Kustom - Putih & Oranye */
        .category-btn { transition: all 0.3s; border: 1px solid #e5e7eb; background: white; }
        .category-active { background-color: #f97316 !important; color: white !important; border-color: #f97316 !important; box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.2); }
        
        .product-card { border-radius: 1.25rem; border: 1px solid #f3f4f6; background: white; transition: all 0.2s; text-align: left; overflow: hidden; }
        .product-card:hover { border-color: #f97316; transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); }
        
        .price-tag { color: #f97316; font-weight: 800; }
        .cart-container { border-radius: 1.5rem; background: white; border: 1px solid #f3f4f6; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); }
        
        .btn-pay { background-color: #f97316 !important; color: white !important; font-weight: 800 !important; border-radius: 0.75rem !important; }
        .btn-pay:hover { background-color: #ea580c !important; }

        svg { width: 1.25rem !important; height: 1.25rem !important; }
        .big-icon svg { width: 4rem !important; height: 4rem !important; margin-bottom: 1rem; opacity: 0.2; }

        .pos-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.25rem; }
        @media (min-width: 768px) { .pos-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        @media (min-width: 1280px) { .pos-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
    </style>

    <div class="flex flex-col lg:flex-row gap-8 -mt-6">
        
        <div class="flex-1">
            <div class="mb-6">
                <x-filament::input.wrapper prefix-icon="heroicon-m-magnifying-glass">
                    <x-filament::input 
                        type="text" 
                        wire:model.live="search" 
                        placeholder="Cari menu favorit..." 
                    />
                </x-filament::input.wrapper>
            </div>

            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($categories as $cat)
                    <button 
                        wire:click="setCategory('{{ $cat }}')"
                        class="category-btn px-5 py-2 rounded-full font-bold text-xs uppercase tracking-wider {{ $activeCategory == $cat ? 'category-active' : 'text-gray-500 hover:bg-gray-50' }}"
                    >
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <div class="pos-grid">
                @foreach($products as $product)
                <button wire:click="addToCart({{ $product->id }})" class="product-card group p-3">
                    <div class="relative overflow-hidden rounded-xl h-36 mb-3 bg-gray-50">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-300 font-bold text-[10px] uppercase tracking-tighter">No Photo</div>
                        @endif
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded-md shadow-sm">
                            <span class="text-[9px] font-black text-orange-600 uppercase">{{ $product->category }}</span>
                        </div>
                    </div>
                    <div class="px-1">
                        <h4 class="font-bold text-gray-800 text-sm truncate leading-tight">{{ $product->name }}</h4>
                        <p class="price-tag text-sm mt-1 leading-none">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </button>
                @endforeach
            </div>
        </div>

        <div class="w-full lg:w-[450px]">
            <div class="cart-container p-6 sticky top-4">
                <div class="flex justify-between items-center mb-8 border-b border-gray-50 pb-4">
                    <div></div>
                    <div class="text-[10px] font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-lg uppercase tracking-widest">
                        {{ count($cart) }} Items
                    </div>
                </div>

                <div class="grid gap-3 mb-6">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-2 block">Nama Pelanggan</label>
                        <x-filament::input class="w-full" wire:model.defer="customerName" placeholder="Masukkan nama" />
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-2 block">Nomor Meja</label>
                        <x-filament::input class="w-full" wire:model.defer="tableNumber" placeholder="Masukkan nomor meja" />
                    </div>
                </div>

                <div class="space-y-5 max-h-[420px] overflow-y-auto mb-8 pr-2">
                    @forelse($cart as $id => $item)
                    <div class="flex justify-between items-center group pb-4 border-b border-gray-50">
                        <div class="flex-1">
                            <div class="font-bold text-sm text-gray-800 group-hover:text-orange-600 transition-colors">{{ $item['name'] }}</div>
                            <div class="price-tag text-[10px]">Rp {{ number_format($item['price']) }}</div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex items-center bg-gray-50 rounded-lg p-1 border border-gray-100">
                                <button wire:click="decrementQty({{ $id }})" class="w-7 h-7 flex items-center justify-center bg-white rounded-md shadow-sm hover:text-orange-600 transition">
                                    <x-heroicon-m-minus class="w-3 h-3"/>
                                </button>
                                
                                <span class="px-3 text-xs font-black text-gray-700">{{ $item['qty'] }}</span>
                                
                                <button wire:click="incrementQty({{ $id }})" class="w-7 h-7 flex items-center justify-center bg-white rounded-md shadow-sm hover:text-orange-600 transition">
                                    <x-heroicon-m-plus class="w-3 h-3"/>
                                </button>
                            </div>

                            <div class="text-right min-w-[90px]">
                                <div class="font-black text-sm text-gray-900 leading-none">Rp {{ number_format($item['qty'] * $item['price']) }}</div>
                            </div>
                            
                            <button wire:click="removeItem({{ $id }})" class="text-gray-200 hover:text-red-500 transition-colors">
                                <x-heroicon-m-trash class="w-4 h-4"/>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16 big-icon flex flex-col items-center">
                        <x-heroicon-o-shopping-bag />
                        <p class="text-gray-400 text-xs italic font-medium">keranjang masih kosong </p>
                    </div>
                    @endforelse
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <div class="flex flex-col gap-1 mb-6 text-right">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Bayar</span>
                        <span class="text-3xl font-black text-orange-600 tracking-tighter">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                    </div>

                    <x-filament::button 
                        wire:click="checkout" 
                        size="xl" 
                        class="w-full btn-pay py-4 shadow-xl shadow-orange-100 uppercase tracking-widest text-xs"
                        
                    >
                        Konfirmasi
                    </x-filament::button>
                </div>
            </div>
        </div>

    </div>
@push('scripts')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush
</x-filament-panels::page>