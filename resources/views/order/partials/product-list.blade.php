@php $currentCat = request('category', 'semua'); @endphp
<div id="product-list-container">
    <h2 class="text-lg sm:text-xl font-extrabold text-gray-800 mb-4 sm:mb-6 px-1 flex items-center gap-2">
        <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
        <span class="truncate">Daftar Menu {{ $currentCat !== 'semua' ? ucfirst($currentCat) : '' }}</span>
    </h2>

    <div class="grid product-grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-3 md:gap-4">
        @forelse($products as $product)
        <div class="product-card flex flex-col group bg-white rounded-2xl sm:rounded-3xl p-2 sm:p-3 shadow-lg shadow-gray-300/70 border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-gray-400/60 cursor-pointer"
             data-product-id="{{ $product->id }}"
             data-name="{{ htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8') }}"
             data-price="Rp {{ number_format($product->price, 0, ',', '.') }}"
             data-description="{{ htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8') }}"
             data-composition="{{ htmlspecialchars($product->composition ?? '', ENT_QUOTES, 'UTF-8') }}"
             data-type="{{ htmlspecialchars($product->type ?? '', ENT_QUOTES, 'UTF-8') }}"
             data-image="{{ $product->images ? asset('storage/' . $product->images) : asset('images/air.jpg') }}"
             data-model-3d="{{ trim($product->model_3d) ? asset('storage/' . trim($product->model_3d)) : '' }}">
                <div class="relative h-56 overflow-hidden">
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
                <p class="text-lg font-black text-orange-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
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
