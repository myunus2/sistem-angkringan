<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<<<<<<< HEAD
    <title>Menu Angkringan Modernn</title>
=======
    <title>Menu Angkringan Cakra</title>
>>>>>>> 160d3f1500f08896dfaf342b25399801095fa66e
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

        .focus-overlay {
            backdrop-filter: blur(6px);
        }
        
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
            <h1 class="text-3xl md:text-4xl font-black tracking-tight drop-shadow-xl">Angkringan Cakra</h1>
            <p class="text-sm md:text-base font-medium opacity-90 mt-1 flex items-center gap-2">
                <span>Jl. Cubadak Tanah Datar Batusangkar. 28 </span>
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

        <div class="grid product-grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @forelse($products as $product)
            <div class="product-card flex flex-col group bg-white rounded-3xl p-3 shadow-sm border border-gray-100" data-product-id="{{ $product->id }}" data-name="{{ e($product->name) }}" data-price="Rp {{ number_format($product->price, 0, ',', '.') }}" data-description="{{ e($product->description) }}" data-composition="{{ e($product->composition) }}" data-image="{{ $product->images ? asset('storage/' . $product->images) : 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&q=80' }}" data-model-3d="{{ $product->model_3d ? asset('storage/' . $product->model_3d) : '' }}">
                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50 mb-2 cursor-pointer product-image-container" >
                    @if($product->images)
                        <img src="{{ asset('storage/' . $product->images) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-transform group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 font-bold uppercase text-[9px]">No Photo</div>
                    @endif
                    <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition"></div>
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
        
                    <div class="composition-panel hidden mt-3 rounded-2xl bg-orange-50 border border-orange-100 p-3 text-xs text-gray-700" id="composition-{{ $product->id }}">
                        <div class="font-semibold text-orange-700 mb-1">Komposisi</div>
                        <p>{{ $product->composition ?? 'Komposisi tidak tersedia.' }}</p>
                    </div>
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

    <div id="product-focus-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/30 focus-overlay p-4">
        <div class="relative w-full max-w-3xl overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-200">
            <button id="product-focus-close" class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm transition hover:bg-slate-100">
                <span class="text-xl font-bold">x</span>
            </button>
            <div class="grid gap-6 md:grid-cols-[1.2fr_1fr] p-6">
                <div class="relative overflow-hidden rounded-3xl bg-slate-100">
                    <img id="focus-image" src="" alt="Produk fokus" class="h-full w-full object-cover">
                </div>
                <div class="flex flex-col justify-between">
                    <div>
                        <p id="focus-type" class="mb-2 text-xs uppercase tracking-[0.3em] text-orange-600"></p>
                        <h3 id="focus-name" class="mb-4 text-2xl font-bold text-slate-900"></h3>
                        <p id="focus-price" class="mb-4 text-lg font-semibold text-orange-600"></p>
                        <p id="focus-description" class="mb-4 text-sm leading-relaxed text-slate-600"></p>
                        <div class="rounded-3xl bg-orange-50 p-4 text-sm text-slate-700">
                            <div class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-orange-700">Komposisi</div>
                            <p id="focus-composition" class="leading-relaxed"></p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between gap-3">
                        <span id="focus-stock" class="text-sm text-slate-500"></span>
                        <div class="flex gap-3">
                            <button id="focus-ar-button" class="rounded-3xl bg-blue-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-600 shadow-lg">
                                Lihat dalam 3D</button>
                            <button id="focus-close-button" class="rounded-3xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-orange-600">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var grid = document.querySelector('.product-grid');
            var overlay = document.getElementById('product-focus-overlay');
            var closeButtons = document.querySelectorAll('#product-focus-close, #focus-close-button');
            var arButton = document.getElementById('focus-ar-button');

            // AR button event
            if (arButton) {
                arButton.addEventListener('click', function() {
                    if (arButton.disabled) {
                        return;
                    }

                    var productId = document.getElementById('focus-name').dataset.productId || '';
                    var productName = document.getElementById('focus-name').textContent || '';
                    var productPrice = document.getElementById('focus-price').textContent || '';
                    var productDescription = document.getElementById('focus-description').textContent || '';
                    var productComposition = document.getElementById('focus-composition').textContent || '';
                    var productModel3d = arButton.getAttribute('data-model-3d') || '';
                    
                    // Redirect to AR page with parameters
                    var arUrl = '/ar.html?name=' + encodeURIComponent(productName) + 
                               '&price=' + encodeURIComponent(productPrice) + 
                               '&description=' + encodeURIComponent(productDescription) + 
                               '&composition=' + encodeURIComponent(productComposition) +
                               '&model=' + encodeURIComponent(productModel3d);
                    window.location.href = arUrl;
                });
            }

            document.querySelectorAll('.product-image-container').forEach(function (container) {
                container.addEventListener('click', function () {
                    var card = container.closest('.product-card');
                    if (!card || !grid) return;

                    var image = card.dataset.image;
                    var name = card.dataset.name;
                    var price = card.dataset.price;
                    var description = card.dataset.description || 'Deskripsi tidak tersedia.';
                    var composition = card.dataset.composition || 'Komposisi tidak tersedia.';
                    var model3d = card.getAttribute('data-model-3d') || '';
                    var type = card.querySelector('span')?.textContent || '';
                    var stockText = card.querySelector('.text-xs.text-gray-500')?.textContent || '';

                    document.getElementById('focus-image').src = image;
                    document.getElementById('focus-name').textContent = name;
                    document.getElementById('focus-name').dataset.productId = card.dataset.productId;
                    document.getElementById('focus-price').textContent = price;
                    document.getElementById('focus-description').textContent = description;
                    document.getElementById('focus-composition').textContent = composition;
                    document.getElementById('focus-type').textContent = type;
                    document.getElementById('focus-stock').textContent = stockText;
                    arButton.setAttribute('data-model-3d', model3d);
                    arButton.disabled = !model3d;
                    arButton.classList.toggle('opacity-50', !model3d);
                    arButton.classList.toggle('cursor-not-allowed', !model3d);
                    arButton.textContent = model3d ? 'Lihat dalam 3D' : 'Model 3D belum ada';

                    grid.classList.add('blur');
                    card.classList.add('focused');
                    overlay.classList.remove('hidden');
                });
            });

            function closeFocus() {
                if (!grid) return;
                grid.classList.remove('blur');
                document.querySelectorAll('.product-card.focused').forEach(function (card) {
                    card.classList.remove('focused');
                });
                overlay.classList.add('hidden');
            }

            closeButtons.forEach(function (button) {
                button.addEventListener('click', closeFocus);
            });

            overlay.addEventListener('click', function (event) {
                if (event.target === overlay) {
                    closeFocus();
                }
            });
            new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
            }).format(5000)
        });
    </script>

</body>
</html>
