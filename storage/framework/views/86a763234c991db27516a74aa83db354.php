<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

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
            left: 0.5rem; /* DIUBAH KE KIRI: Agar tidak menabrak label kategori di kanan */
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
        .cart-container label {
            color: #313131 !important;
            font-weight: 900 !important;
        }

        .cart-container input[type="text"] {
            color: #0f0f0f !important; 
            font-weight: 700 !important;
        }

        .cart-container input[type="text"]::placeholder {
            color: #9ca3af !important; 
            font-style: italic !important; 
            font-weight: 500 !important;
        }

        /* ====================================================================
           PERBAIKAN FITUR DARK MODE UNTUK ELEMEN KUSTOM (KASIR)
           ==================================================================== */
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
        
        .dark .cart-container .fi-input-wrp {
            border-color: #475569 !important;
        }
        .dark .cart-container label {
            color: #f1f5f9 !important;
        }
        .dark .cart-container input[type="text"] {
            color: #ffffff !important;
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

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 pt-2 lg:pt-0 lg:-mt-6 px-1 md:px-4 lg:px-0 w-full items-start">
        
        <div class="order-first lg:order-last w-full lg:w-[400px] flex-shrink-0">
            <div class="cart-container p-4 md:p-6 lg:sticky lg:top-4">
                
                <div class="flex justify-between items-center mb-4 border-b border-gray-50 pb-3">
                    <h2 class="font-black text-base md:text-lg text-gray-900 uppercase tracking-tight">Detail Pesanan</h2>
                    <div class="text-[9px] md:text-[10px] font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-lg uppercase tracking-widest">
                        <?php echo e(count($cart)); ?> Items
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="text-xs font-black uppercase tracking-wider text-black dark:text-white mb-1 block">Nama Pelanggan</label>
                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['class' => 'rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-orange-500 transition-all duration-200','style' => 'border: 2px solid #cbd5e1 !important;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-orange-500 transition-all duration-200','style' => 'border: 2px solid #cbd5e1 !important;']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <?php if (isset($component)) { $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.index','data' => ['type' => 'text','class' => 'w-full text-base font-bold py-3.5 text-black dark:text-white placeholder:text-gray-400 placeholder:italic bg-transparent border-none focus:ring-0','wire:model.defer' => 'customerName']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','class' => 'w-full text-base font-bold py-3.5 text-black dark:text-white placeholder:text-gray-400 placeholder:italic bg-transparent border-none focus:ring-0','wire:model.defer' => 'customerName']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e)): ?>
<?php $attributes = $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e; ?>
<?php unset($__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e)): ?>
<?php $component = $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e; ?>
<?php unset($__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $attributes = $__attributesOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__attributesOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $component = $__componentOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__componentOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
                    </div>
                    <div>
                        <label class="text-xs font-black uppercase tracking-wider text-black dark:text-white mb-1 block">Nomor Meja</label>
                        <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['class' => 'rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-orange-500 transition-all duration-200','style' => 'border: 2px solid #cbd5e1 !important;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-orange-500 transition-all duration-200','style' => 'border: 2px solid #cbd5e1 !important;']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <?php if (isset($component)) { $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.index','data' => ['type' => 'text','class' => 'w-full text-base font-bold py-3.5 text-black dark:text-white placeholder:text-gray-400 placeholder:italic bg-transparent border-none focus:ring-0','wire:model.defer' => 'tableNumber']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','class' => 'w-full text-base font-bold py-3.5 text-black dark:text-white placeholder:text-gray-400 placeholder:italic bg-transparent border-none focus:ring-0','wire:model.defer' => 'tableNumber']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e)): ?>
<?php $attributes = $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e; ?>
<?php unset($__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e)): ?>
<?php $component = $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e; ?>
<?php unset($__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $attributes = $__attributesOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__attributesOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $component = $__componentOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__componentOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
                    </div>
                </div>

                <div class="space-y-3 max-h-[220px] lg:max-h-[350px] overflow-y-auto mb-4 pr-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="flex justify-between items-center group pb-3 border-b border-gray-50 gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-xs md:text-sm text-gray-800 leading-tight mb-0.5"><?php echo e($item['name']); ?></div>
                            <div class="price-tag text-[10px]">Rp <?php echo e(number_format($item['price'])); ?></div>
                        </div>
                        
                        <div class="flex items-center gap-3 flex-shrink-0 pr-1">
                            <div class="flex items-center bg-gray-50 rounded-lg p-0.5 border border-gray-100">
                                <button type="button" wire:click="decrementQty(<?php echo e($id); ?>)" class="w-6 h-6 flex items-center justify-center bg-white rounded-md shadow-sm hover:text-orange-600 transition active:scale-90">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-minus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                </button>
                                <span class="px-2 text-xs font-black text-gray-700"><?php echo e($item['qty']); ?></span>
                                <button type="button" wire:click="incrementQty(<?php echo e($id); ?>)" class="w-6 h-6 flex items-center justify-center bg-white rounded-md shadow-sm hover:text-orange-600 transition active:scale-90">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                </button>
                            </div>

                            <div class="text-right min-w-[70px] flex-shrink-0">
                                <div class="font-black text-xs text-gray-900">Rp <?php echo e(number_format($item['qty'] * $item['price'])); ?></div>
                            </div>
                            
                            <button type="button" wire:click="removeItem(<?php echo e($id); ?>)" class="text-red-400 hover:text-red-500 transition-colors flex-shrink-0 ml-1">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-trash'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            </button>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="text-center py-8 big-icon flex flex-col items-center">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-shopping-bag'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <p class="text-gray-400 text-xs italic font-medium">Keranjang masih kosong</p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex flex-col gap-0.5 mb-4 text-right">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Total Bayar</span>
                        <span class="text-2xl font-black text-orange-600 tracking-tighter">Rp <?php echo e(number_format($this->total, 0, ',', '.')); ?></span>
                    </div>

                    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'button','wire:click' => 'checkout','size' => 'xl','class' => 'w-full btn-pay py-4 uppercase tracking-wider text-sm font-black shadow-lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','wire:click' => 'checkout','size' => 'xl','class' => 'w-full btn-pay py-4 uppercase tracking-wider text-sm font-black shadow-lg']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        Konfirmasi Transaksi
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                </div>
            </div>
        </div>

        <div class="w-full flex-1 lg:order-first mt-4 lg:mt-0">
            <div class="mb-4">
                <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['prefixIcon' => 'heroicon-m-magnifying-glass','class' => 'rounded-xl focus-within:ring-2 focus-within:ring-orange-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['prefix-icon' => 'heroicon-m-magnifying-glass','class' => 'rounded-xl focus-within:ring-2 focus-within:ring-orange-500']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <?php if (isset($component)) { $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.index','data' => ['type' => 'text','wire:model.live' => 'search','placeholder' => 'Cari menu...','class' => 'text-base font-medium py-3.5 md:py-4 lg:py-2 lg:text-sm border-none focus:ring-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','wire:model.live' => 'search','placeholder' => 'Cari menu...','class' => 'text-base font-medium py-3.5 md:py-4 lg:py-2 lg:text-sm border-none focus:ring-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e)): ?>
<?php $attributes = $__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e; ?>
<?php unset($__attributesOriginal9ad6b66c56a2379ee0ba04e1e358c61e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e)): ?>
<?php $component = $__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e; ?>
<?php unset($__componentOriginal9ad6b66c56a2379ee0ba04e1e358c61e); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $attributes = $__attributesOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__attributesOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $component = $__componentOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__componentOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
            </div>

            <div class="flex flex-wrap gap-1.5 mb-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <button 
                        wire:click="setCategory('<?php echo e($cat); ?>')"
                        class="category-btn rounded-full transition-all <?php echo e($activeCategory == $cat ? 'category-active' : 'text-gray-500 hover:bg-gray-50'); ?>"
                    >
                        <?php echo e(ucfirst($cat)); ?>

                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <div class="pos-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $productQty = $cart[$product->id]['qty'] ?? 0;
                ?>
                <button type="button" wire:click="addToCart(<?php echo e($product->id); ?>)" class="product-card group relative p-1.5 md:p-3 transition active:scale-95">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($productQty > 0): ?>
                        <span class="product-qty-badge"><?php echo e($productQty); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="relative overflow-hidden rounded-xl aspect-square mb-1.5 bg-gray-50">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image_url): ?>
                            <img src="<?php echo e($product->image_url); ?>" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/air.jpg')); ?>" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="absolute top-1 right-1 bg-white/90 backdrop-blur-sm px-1 py-0.5 rounded-md shadow-sm">
                            <span class="text-[7px] font-black text-orange-600 uppercase"><?php echo e(ucfirst($product->type ?? 'Menu')); ?></span>
                        </div>
                    </div>
                    <div class="px-0.5">
                        <h4 class="font-bold text-gray-800 text-[10px] sm:text-xs md:text-sm line-clamp-2 leading-tight min-h-[2.25rem]"><?php echo e($product->name); ?></h4>
                        <p class="price-tag text-[10px] sm:text-xs md:text-sm mt-0.5 leading-none">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                    </div>
                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-full flex flex-col items-center justify-center py-12 px-4 text-center">
                    <div class="p-4 bg-gray-50 rounded-full text-gray-400 mb-3">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-magnifying-glass'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 opacity-40 mx-auto','style' => 'width: 2.5rem !important; height: 2.5rem !important;']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    </div>
                    <h3 class="text-sm font-bold text-gray-700">Menu Tidak Ditemukan</h3>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->hasPages()): ?>
                <div class="mt-6 flex justify-center text-sm md:text-base 
                [&_.flex-1]:flex [&_.flex-1]:justify-between md:[&_.flex-1]:hidden 
                [&_nav_div:nth-child(2)]:hidden md:[&_nav_div:nth-child(2)]:flex">
                 <?php echo e($products->links()); ?>

                 </div>
             <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

    </div>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH C:\xampp1\htdocs\sistem-angkringan\resources\views/filament/pages/kasir.blade.php ENDPATH**/ ?>