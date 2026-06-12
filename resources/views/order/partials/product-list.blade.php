@php $currentCat = request('category', 'semua'); @endphp
<div id="product-list-container">
    <h2 class="text-lg sm:text-xl font-extrabold text-gray-800 mb-4 sm:mb-6 px-1 flex items-center gap-2">
        <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
        <span class="truncate">Daftar Menu {{ $currentCat !== 'semua' ? ucfirst($currentCat) : '' }}</span>
    </h2>

    <div class="grid product-grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 sm:gap-6 lg:gap-8">
        @forelse($products as $product)
        <div class="product-card flex flex-col group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-orange-200/50 border border-gray-100 transition-all duration-500 hover:-translate-y-2 cursor-pointer"
             data-product-id="{{ $product->id }}"
             data-name="{{ htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8') }}"
             data-price="Rp {{ number_format($product->price, 0, ',', '.') }}"
             data-description="{{ htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8') }}"
             data-composition="{{ htmlspecialchars($product->composition ?? '', ENT_QUOTES, 'UTF-8') }}"
             data-type="{{ htmlspecialchars($product->type ?? '', ENT_QUOTES, 'UTF-8') }}"
             data-image="{{ $product->images ? asset('storage/' . $product->images) : asset('images/air.jpg') }}"
             data-model-3d="{{ trim($product->model_3d) ? asset('storage/' . trim($product->model_3d)) : '' }}">
            
            <div class="relative aspect-square overflow-hidden bg-gray-50">
                @if($product->images)
                    <img src="{{ asset('storage/' . $product->images) }}"
                         alt="{{ $product->name }}"
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
                
                <div class="absolute top-3 left-3 sm:top-4 sm:left-4">
                    @php
                        $badgeColor = match($product->type) {
                            'makanan' => 'bg-orange-500',
                            'minuman' => 'bg-blue-500',
                            'snack'   => 'bg-green-500',
                            default   => 'bg-gray-500'
                        };
                    @endphp
                    <span class="{{ $badgeColor }} text-white text-[9px] sm:text-[11px] font-black uppercase tracking-widest px-3 py-1 rounded-xl shadow-lg shadow-black/10">
                        {{ $product->type ?? 'Menu' }}
                    </span>
                </div>

                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>

            <div class="p-4 sm:p-6 flex flex-col flex-grow">
                <h3 class="font-extrabold text-gray-800 text-sm sm:text-lg leading-tight mb-2 line-clamp-2 group-hover:text-orange-500 transition-colors duration-300">{{ $product->name }}</h3>
                <div class="mt-auto flex items-end justify-between">
                    <div>
                        <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5">Harga</p>
                        <p class="text-lg sm:text-xl font-black text-orange-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white group-hover:rotate-90 transition-all duration-500 shadow-sm">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </div>
                </div>
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
        <div class="mt-8 flex justify-center ajax-pagination">
            {{ $products->links() }}
        </div>
    @endif
</div>
