<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu Angkringan Modernn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
            -webkit-appearance: none; margin: 0;
        }
        /* Menghilangkan scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        @media (max-width: 768px) {
            .snap-x-container {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
            }
            .snap-item {
                scroll-snap-align: start;
                flex-shrink: 0;
            }
        }
    </style>
</head>
<body class="bg-[#FDFDFD] pb-32">

    <div class="relative w-full h-64 md:h-80 bg-orange-500 overflow-hidden shadow-md">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&q=80" 
             class="w-full h-full object-cover transform scale-105" alt="Banner Angkringan">
        <div class="absolute bottom-8 left-8 z-20 text-white">
            <h1 class="text-3xl md:text-4xl font-black tracking-tight drop-shadow-xl">Angkringan Modern</h1>
            <p class="text-sm md:text-base font-medium opacity-90 mt-1 flex items-center gap-2">
                <span>Jl. Utama No. 12</span>
            </p>
        </div>
    </div>

    <div class="px-4 mt-6">
        <form action="{{ route('index') }}" method="GET" class="relative">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="block w-full pl-10 pr-3 py-3 border-none bg-gray-100 rounded-2xl leading-5 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm transition-all" 
                   placeholder="Cari menu favoritmu...">
        </form>
    </div>

    <div class="px-4 my-6">
        <div id="nav-kategori" class="snap-x-container flex gap-3 pb-2 no-scrollbar overflow-x-auto justify-start md:justify-center">
            @php $currentCat = request('category', 'semua'); @endphp
            
            @foreach(['semua', 'makanan', 'minuman', 'snack'] as $cat)
            <div class="snap-item">
                <a href="{{ route('index', ['category' => $cat]) }}" 
                   class="category-btn inline-block whitespace-nowrap px-8 py-2.5 rounded-full text-sm font-bold transition-all 
                   {{ $currentCat == $cat ? 'bg-orange-500 text-white shadow-lg active-category' : 'bg-gray-100 text-gray-500' }}">
                   {{ ucfirst($cat) }}
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="w-full px-4 py-4">
        <h2 class="text-xl font-extrabold text-gray-800 mb-6 px-1 flex items-center gap-2">
            <span class="w-2 h-6 bg-orange-500 rounded-full"></span>
            Daftar Menu {{ $currentCat !== 'semua' ? ucfirst($currentCat) : '' }}
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @forelse($products as $product)
            <div class="flex flex-col group">
                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50 mb-2">
                    @if($product->images)
                        <img src="{{ asset('storage/' . $product->images) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 font-bold uppercase text-[9px]">No Photo</div>
                    @endif
                </div>

                <div class="px-0.5">
                    <div class="mb-1">
                        @php
                            $badgeColor = match($product->type) {
                                'makanan' => 'bg-orange-100 text-orange-600',
                                'minuman' => 'bg-blue-100 text-blue-600',
                                'snack'   => 'bg-green-100 text-green-600',
                                default   => 'bg-gray-100 text-gray-600'
                            };
                        @endphp
                        <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded-md {{ $badgeColor }}">
                            {{ $product->type ?? 'Menu' }}
                        </span>
                    </div>

                    <h3 class="font-bold text-gray-800 text-sm leading-tight mb-0.5 truncate">{{ $product->name }}</h3>
                    <p class="text-sm font-bold text-orange-600 mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-gray-400 font-medium">Menu tidak ditemukan... </p>
                <a href="{{ route('index') }}" class="text-orange-500 font-bold text-sm mt-2 block">Lihat Semua Menu</a>
            </div>
            @endforelse
        </div>
    </div>


        
</body>
</html>
