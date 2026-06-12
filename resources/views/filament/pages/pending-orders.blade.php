<x-filament-panels::page>
    <div>
        <style>
            .my-pos-container { color: #334155; font-size: 14.5px; font-family: sans-serif; }
            .bg-panel-main { background: #ffffff; border: 1px solid #e2e8f0; }
            .text-title-main { color: #0f172a; }
            .card-base { background: #ffffff; border: 1.5px solid #e2e8f0; }
            .card-active { background: #fffdfa !important; border-color: #f97316 !important; }
            .icon-circle { background: #f1f5f9; border: 1px solid #e2e8f0; color: #94a3b8; }
            .line-divider { border-bottom: 1px solid #f1f5f9; }
            .inner-box { background: #f8fafc; border: 1px solid #e2e8f0; }
            
            .dark .bg-panel-main { background: #1e293b !important; border-color: #334155 !important; }
            .dark .text-title-main { color: #f8fafc !important; }
            .dark .card-base { background: #1e293b !important; border-color: #334155 !important; }
            .dark .card-active { background: rgba(249, 115, 22, 0.12) !important; border-color: #f97316 !important; }
            .dark .icon-circle { background: #0f172a !important; border-color: #334155 !important; color: #94a3b8 !important; }
            .dark .line-divider { border-bottom-color: #334155 !important; }
            .dark .inner-box { background: #0f172a !important; border-color: #334155 !important; }
            .dark p, .dark label, .dark h4 { color: #cbd5e1 !important; }
        </style>

        <div class="my-pos-container">
            <div class="bg-panel-main" style="border-radius: 12px; padding: 16px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 class="text-title-main" style="margin: 0; font-size: 18px; font-weight: 700;">Daftar Antrean Pesanan</h2>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #94a3b8;">{{ $orders->count() }} pesanan perlu dikonfirmasi</p>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                @forelse($orders as $order)
                    @php $isActive = $selectedOrderId === $order->id; @endphp
                    
                    <div class="card-base {{ $isActive ? 'card-active' : '' }}" style="border-radius: 12px; padding: 18px; transition: all 0.2s;">
                        <div class="{{ $isActive ? 'line-divider' : '' }}" style="display: flex; justify-content: space-between; align-items: center; gap: 16px; padding-bottom: {{ $isActive ? '16px' : '0' }};">
                            
                            <div wire:click="selectOrder({{ $order->id }})" style="display: flex; align-items: center; gap: 12px; cursor: pointer; flex: 1;">
                                <div class="icon-circle" style="width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-title-main" style="margin: 0; font-size: 15.5px; font-weight: 700;">{{ $order->customer_name ?: 'Tanpa Nama' }}</h3>
                                    <p style="margin: 3px 0 0 0; font-size: 12.5px; color: #94a3b8;">Meja {{ $order->table_number ?: '-' }} &middot; {{ $order->created_at?->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div style="text-align: right;">
                                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94a3b8;">Total</span>
                                <div class="text-title-main" style="font-size: 18px; font-weight: 700;">Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        @if(!$isActive)
                            <div wire:click="selectOrder({{ $order->id }})" style="cursor: pointer; margin-top: 10px;">
                                <p style="margin: 0; font-size: 12px; font-weight: 500; color: #94a3b8;">klik untuk melihat detail pesanan</p>
                            </div>
                        @endif

                        @if($isActive)
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 16px;">
                                <div>
                                    <h4 style="margin: 0 0 10px 0; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #94a3b8;">Rincian Menu</h4>
                                    <div class="inner-box" style="border-radius: 10px; padding: 14px; display: flex; flex-direction: column; gap: 10px;">
                                        @foreach($order->items as $item)
                                            <div class="line-divider" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px;">
                                                <div style="min-width:0;">
                                                    <p class="text-title-main" style="margin: 0; font-size: 14px; font-weight: 600;">{{ $item->product?->name ?? 'Produk dihapus' }}</p>
                                                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #94a3b8;">{{ $item->quantity }} x Rp {{ number_format((float) $item->price, 0, ',', '.') }}</p>
                                                </div>
                                                <span style="font-size: 14px; font-weight: 700;">Rp {{ number_format((float) ($item->price * $item->quantity), 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="inner-box" style="border-radius: 10px; padding: 16px; display: flex; flex-direction: column; gap: 14px; justify-content: center;">
                                    @if($order->notes)
                                        <div style="margin-bottom: 10px;">
                                            <label style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94a3b8;">Catatan:</label>
                                            <p style="margin: 4px 0 0 0; font-size: 13px;">{{ $order->notes }}</p>
                                        </div>
                                    @endif
                                    
                                    <div style="display: flex; gap: 10px;">
                                        <button wire:click="confirmOrder({{ $order->id }})" style="flex: 1; border: none; background: #16a34a; color: #ffffff; padding: 12px; font-size: 14px; font-weight: 700; border-radius: 8px; cursor: pointer;">
                                            Konfirmasi & Selesai
                                        </button>
                                        <button wire:click="deleteOrder({{ $order->id }})" wire:confirm="Hapus pesanan ini?" style="border: 1px solid #fca5a5; background: #fff5f5; color: #dc2626; padding: 12px; font-size: 14px; font-weight: 700; border-radius: 8px; cursor: pointer;">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-panel-main" style="border-radius: 12px; padding: 48px; text-align: center; border-style: dashed !important;">
                        <h3 class="text-title-main" style="margin: 0; font-size: 14px; font-weight: 700;">Antrean Kosong</h3>
                        <p style="margin: 4px 0 0 0; font-size: 13px; color: #94a3b8;">Semua pesanan telah diproses.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-panels::page>
