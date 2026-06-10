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

    <div>
        <style>
            /* --- SIFAT DASAR UTAMA --- */
            .my-pos-container { color: #334155; font-size: 14.5px; font-family: sans-serif; }
            .bg-panel-main { background: #ffffff; border: 1px solid #e2e8f0; }
            .text-title-main { color: #0f172a; }
            .bg-filter-base { background: #f1f5f9; border: 1px solid #e2e8f0; }
            .card-base { background: #ffffff; border: 1.5px solid #e2e8f0; }
            .card-active { background: #fffdfa !important; border-color: #f97316 !important; }
            .icon-circle { background: #f1f5f9; border: 1px solid #e2e8f0; color: #94a3b8; }
            .line-divider { border-bottom: 1px solid #f1f5f9; }
            .inner-box { background: #f8fafc; border: 1px solid #e2e8f0; }
            .input-field { background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; }
            .dash-divider { border-top: 1px dashed #cbd5e1; }
            
            /* --- WARNA STATUS BADGE (MODE TERANG) --- */
            .badge-paid { background: #f0fdf4 !important; color: #15803d !important; border: 1px solid #bbf7d0 !important; }
            .badge-unpaid { background: #fffbeb !important; color: #b45309 !important; border: 1px solid #fde68a !important; }
            .badge-done { background: #f8fafc !important; color: #475569 !important; border: 1px solid #e2e8f0 !important; }

            /* ====================================================================
               OTOMATIS BERUBAH TOTAL SAAT FILAMENT MASUK DARK MODE (.dark)
               ==================================================================== */
            .dark .bg-panel-main { background: #1e293b !important; border-color: #334155 !important; }
            .dark .text-title-main { color: #f8fafc !important; }
            .dark .bg-filter-base { background: #0f172a !important; border-color: #334155 !important; }
            
            /* Card Utama */
            .dark .card-base { background: #1e293b !important; border-color: #334155 !important; }
            .dark .card-active { background: rgba(249, 115, 22, 0.12) !important; border-color: #f97316 !important; }
            .dark .icon-circle { background: #0f172a !important; border-color: #334155 !important; color: #94a3b8 !important; }
            .dark .line-divider { border-bottom-color: #334155 !important; }
            .dark .inner-box { background: #0f172a !important; border-color: #334155 !important; }
            
            /* Input & Teks Muted */
            .dark .input-field { background: #1e293b !important; border-color: #475569 !important; color: #f1f5f9 !important; }
            .dark .dash-divider { border-top-color: #475569 !important; }
            .dark p, .dark label, .dark h4 { color: #cbd5e1 !important; }
            
            /* KONTRAST TINGGI UNTUK STATUS BADGES DI DARK MODE */
            .dark .badge-paid { background: #052e16 !important; color: #4ade80 !important; border-color: #15803d !important; }
            .dark .badge-unpaid { background: #451a03 !important; color: #fbbf24 !important; border-color: #78350f !important; }
            .dark .badge-done { background: #334155 !important; color: #f1f5f9 !important; border-color: #475569 !important; }
        </style>

        <div class="my-pos-container">
            
            <div class="bg-panel-main" style="border-radius: 12px; padding: 16px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h2 class="text-title-main" style="margin: 0; font-size: 18px; font-weight: 700; letter-spacing: -0.01em;"><?php echo e($showAllTransaksi ? 'Semua Transaksi' : 'Antrean Pesanan'); ?></h2>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #94a3b8;">
                        <?php echo e($showAllTransaksi ? $orders->count() . ' transaksi' : $orders->count() . ' pesanan aktif'); ?>

                    </p>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; justify-content: flex-end;">
                    <div class="bg-filter-base" style="display: flex; gap: 4px; padding: 4px; border-radius: 8px;">
                        <button type="button" wire:click="$set('statusFilter', 'all')" style="border: none; padding: 8px 16px; font-size: 13.5px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: all 0.15s; background: <?php echo e($statusFilter === 'all' ? '#ffffff' : 'transparent'); ?>; color: <?php echo e($statusFilter === 'all' ? '#0f172a' : '#64748b'); ?>; box-shadow: <?php echo e($statusFilter === 'all' ? '0 1px 3px rgba(0,0,0,0.05)' : 'none'); ?>;">Semua</button>
                        <button type="button" wire:click="$set('statusFilter', 'unpaid')" style="border: none; padding: 8px 16px; font-size: 13.5px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: all 0.15s; background: <?php echo e($statusFilter === 'unpaid' ? '#ffffff' : 'transparent'); ?>; color: <?php echo e($statusFilter === 'unpaid' ? '#0f172a' : '#64748b'); ?>; box-shadow: <?php echo e($statusFilter === 'unpaid' ? '0 1px 3px rgba(0,0,0,0.05)' : 'none'); ?>;">Belum Bayar</button>
                        <button type="button" wire:click="$set('statusFilter', 'paid')" style="border: none; padding: 8px 16px; font-size: 13.5px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: all 0.15s; background: <?php echo e($statusFilter === 'paid' ? '#ffffff' : 'transparent'); ?>; color: <?php echo e($statusFilter === 'paid' ? '#0f172a' : '#64748b'); ?>; box-shadow: <?php echo e($statusFilter === 'paid' ? '0 1px 3px rgba(0,0,0,0.05)' : 'none'); ?>;">Lunas</button>
                    </div>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

                    <?php $isActive = $selectedOrder?->id === $order->id; ?>
                    
                    <div class="card-base <?php echo e($isActive ? 'card-active' : ''); ?>" style="border-radius: 12px; padding: 18px; box-shadow: <?php echo e($isActive ? '0 4px 12px rgba(249, 115, 22, 0.06)' : '0 1px 2px rgba(0,0,0,0.01)'); ?>; transition: all 0.2s;">
                        
                        <div class="<?php echo e($isActive ? 'line-divider' : ''); ?>" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding-bottom: <?php echo e($isActive ? '16px' : '0'); ?>;">
                            
                            <div wire:click="selectOrder(<?php echo e($order->id); ?>)" style="display: flex; align-items: center; gap: 12px; cursor: pointer; flex: 1; min-width: 220px;">
                                <div class="icon-circle" style="width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-title-main" style="margin: 0; font-size: 15.5px; font-weight: 700;"><?php echo e($order->customer_name ? ucwords($order->customer_name) : 'Tanpa Nama'); ?></h3>
                                    <p style="margin: 3px 0 0 0; font-size: 12.5px; color: #94a3b8;">Meja <?php echo e($order->table_number ?: '-'); ?> &middot; <?php echo e($order->created_at?->format('H:i')); ?></p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
                                <div style="text-align: right;">
                                    <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Total Tagihan</span>
                                    <div class="text-title-main" style="font-size: 18px; font-weight: 700; margin-top: 1px;">Rp <?php echo e(number_format((float) $order->total_price, 0, ',', '.')); ?></div>
                                </div>
                                
                                <div style="display: flex; gap: 6px;">
                                    <span class="<?php echo e($order->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid'); ?>" style="font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; text-align: center;">
                                        <?php echo e($order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar'); ?>

                                    </span>
                                    <span class="badge-done" style="font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; text-align: center;">
                                        <?php echo e($order->status === 'done' ? 'Selesai' : 'Pending'); ?>

                                    </span>
                                </div>
                            </div>

                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isActive): ?>
                            <div wire:click="selectOrder(<?php echo e($order->id); ?>)" style="cursor: pointer; margin-top: 10px; text-align: left;">
                                <p style="margin: 0; font-size: 12px; font-weight: 500; color: #94a3b8; display: flex; align-items: center; gap: 4px;">
                                    klik untuk melihat transaksi
                                </p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isActive): ?>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 16px;">

                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <h4 style="margin: 0; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Rincian Menu</h4>
                                        <button type="button" wire:confirm="Hapus pesanan ini?" wire:click="deleteSelected" style="background: #fff5f5; border: 1px solid #fca5a5; color: #dc2626; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background 0.15s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fff5f5'">
                                            Hapus Pesanan
                                        </button>
                                    </div>
                                    <div class="inner-box" style="border-radius: 10px; padding: 14px; display: flex; flex-direction: column; gap: 10px;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <div class="line-divider" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; margin-bottom: 2px; last:border-bottom: none;">
                                                <div style="min-width:0;">
                                                    <p class="text-title-main" style="margin: 0; font-size: 14px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($item->product?->name ?? 'Produk dihapus'); ?></p>
                                                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #94a3b8;">Rp <?php echo e(number_format((float) $item->price, 0, ',', '.')); ?> / item</p>
                                                </div>
                                                <span class="input-field" style="flex-shrink:0; font-size: 13px; font-weight: 700; padding: 3px 10px; border-radius: 6px;"><?php echo e($item->quantity); ?>x</span>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                </div>

                                <div class="inner-box" style="border-radius: 10px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; gap: 14px;">
                                    <div style="display: flex; flex-direction: column; gap: 14px;">
                                        
                                        <div style="display: flex; flex-direction: column; gap: 4px;">
                                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Metode Pembayaran</label>
                                            <select wire:model.live="paymentMethod" class="input-field" style="width: 100%; border-radius: 6px; padding: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
                                                <option value="cash">Tunai</option>
                                                <option value="midtrans_qris">QRIS </option>
                                                <option value="midtrans_ewallet">E-Wallet </option>
                                                <option value="midtrans_bank">Transfer Bank </option>
                                            </select>
                                        </div>

                                        <div style="display: flex; flex-direction: column; gap: 4px;">
                                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8;">Jumlah Uang</label>
                                            <div style="position: relative; display: flex; align-items: center;">
                                                <span style="position: absolute; left: 10px; font-size: 14px; font-weight: 600; color: #94a3b8;">Rp</span>
                                                <input type="text" inputmode="numeric" class="input-field"
                                                    x-data="{
                                                        raw: <?php if ((object) ('cash') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('cash'->value()); ?>')<?php echo e('cash'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('cash'); ?>')<?php endif; ?>,
                                                        display: '',
                                                        digits(value) { return String(value ?? '').replace(/[^0-9]/g, ''); },
                                                        format(value) { const digits = this.digits(value); return digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '0'; },
                                                        update(value) { const digits = this.digits(value); this.raw = digits || '0'; this.display = digits; },
                                                        finish() { this.raw = this.digits(this.display) || '0'; this.display = this.format(this.raw); $wire.finishCashInput(this.raw); },
                                                        init() { this.display = this.format(this.raw); }
                                                    }"
                                                    x-model="display" x-on:focus="display = digits(raw)" x-on:input="update($event.target.value)" x-on:blur="finish()"
                                                    style="width: 100%; padding: 8px 8px 8px 34px; border-radius: 6px; font-size: 15px; font-weight: 700;" 
                                                />
                                            </div>
                                        </div>

                                        <div class="dash-divider" style="margin-top: 8px; padding-top: 8px; display: flex; flex-direction: column; gap: 4px;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPaymentResult): ?>
                                                <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600;">
                                                    <span style="color: #94a3b8;">DIBAYAR</span>
                                                    <span class="text-title-main" style="font-weight: 700;">Rp <?php echo e(number_format((float) preg_replace('/[^0-9]/', '', (string) $cash), 0, ',', '.')); ?></span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; font-size: 14px; font-weight: 700; color: #ea580c;">
                                                    <span>KEMBALIAN</span>
                                                    <span>Rp <?php echo e(number_format((float) $change, 0, ',', '.')); ?></span>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div style="display: flex; justify-content: space-between; font-size: 13.5px; font-weight: 700; margin-top: 4px;">
                                                <span style="color: #94a3b8;">TOTAL AKHIR</span>
                                                <span style="font-size: 16.5px; font-weight: 800; color: #ea580c;">Rp <?php echo e(number_format((float) $order->total_price, 0, ',', '.')); ?></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div style="margin-top: 4px;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment_status !== 'paid'): ?>
                                            <button type="button" wire:click="paySelected" style="width: 100%; border: none; background: #f97316; color: #ffffff; padding: 10px; font-size: 14px; font-weight: 700; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.15s;" onmouseover="this.style.background='#ea580c'" onmouseout="this.style.background='#f97316'">
                                                Proses Pembayaran
                                            </button>
                                        <?php elseif($order->status === 'pending'): ?>
                                            <button type="button" wire:click="confirmSelected" style="width: 100%; border: none; background: #0284c7; color: #ffffff; padding: 10px; font-size: 14px; font-weight: 700; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.15s;" onmouseover="this.style.background='#0369a1'" onmouseout="this.style.background='#0284c7'">
                                                Konfirmasi Pesanan
                                            </button>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('admin.orders.receipt', $order)); ?>" target="_blank" style="text-decoration: none; width: 100%; background: #f97316; color: #ffffff; padding: 10px; font-size: 14px; font-weight: 700; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: background 0.15s;" onmouseover="this.style.background='#ea580c'" onmouseout="this.style.background='#f97316'">
                                                Cetak Struk Transaksi
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="bg-panel-main" style="border-radius: 12px; padding: 48px; text-align: center; border-style: dashed !important;">
                        <h3 class="text-title-main" style="margin: 0; font-size: 14px; font-weight: 700;">Tidak ada pesanan</h3>
                        <p style="margin: 6px 0 0 0; font-size: 12.5px; color: #94a3b8;">Tidak ada transaksi untuk ditampilkan.</p>
                        <p style="margin: 4px 0 0 0; font-size: 13px; color: #94a3b8;">Pesanan aktif dari kasir akan muncul di sini.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->count() > 0): ?>
                <div style="text-align: center; margin-top: 24px;">
                    <p style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #94a3b8;">
                        klik untuk melihat semua transaksi
                    </p>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAllTransaksi): ?>
                        <button type="button"
                            wire:click="toggleShowAllTransaksi"
                            style="border: 1px solid #e2e8f0; background: #ffffff; width: 44px; height: 44px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.15s;"
                            onmouseover="this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.transform='translateY(0px)'"
                            aria-label="toggle all transaksi">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 15l6-6 6 6" />
                            </svg>
                        </button>
                    <?php else: ?>
                        <button type="button"
                            wire:click="toggleShowAllTransaksi"
                            style="border: 1px solid #e2e8f0; background: #ffffff; width: 44px; height: 44px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.15s;"
                            onmouseover="this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.transform='translateY(0px)'"
                            aria-label="toggle all transaksi">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH C:\xampp1\htdocs\sistem-angkringan\resources\views/filament/pages/transaksi.blade.php ENDPATH**/ ?>