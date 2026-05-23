<x-filament-panels::page>
    <style>
        /* ====================================================================
           PERBAIKAN FITUR DARK MODE UNTUK HALAMAN TRANSAKSI (ANTREAN)
           ==================================================================== */
        
        /* 1. ROOT UTAMA PANEL */
        .dark .queue-panel,
        .dark .detail-panel {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        /* 2. AREA DAFTAR ANTREAN */
        .dark .queue-panel h2 {
            color: #f1f5f9 !important;
        }
        .dark .queue-panel select {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        .dark .order-card {
            background: #0f172a !important;
            border-color: #334155 !important;
        }
        .dark .order-card .text-gray-950 {
            color: #f1f5f9 !important;
        }
        .dark .order-card:hover,
        .dark .order-card.is-active {
            border-color: #f97316 !important;
            background: rgba(249, 115, 22, 0.1) !important;
        }

        /* 3. WRAPPER STRUK / RECEIPT STYLE */
        .dark .pos-receipt-container {
            background: #0f172a !important;
            border-color: #334155 !important;
        }
        .dark .menu-name {
            color: #f1f5f9 !important;
        }
        .dark .qty-pill {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        .dark .receipt-dashed {
            border-top-color: #334155 !important;
        }
        .dark .money-value {
            color: #f1f5f9 !important;
        }

        /* 4. ASIDE / KOTAK INPUT PEMBAYARAN */
        .dark .payment-box {
            background: #0f172a !important;
            border-color: #334155 !important;
        }
        .dark .payment-box select,
        .dark .payment-box input {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        .dark .payment-box label span {
            color: #94a3b8 !important;
        }
        .dark .money-input span {
            color: #94a3b8 !important;
        }
        .dark .payment-field + .payment-field {
            border-top-color: #334155 !important;
        }

        /* 5. STATE KOSONG (KONDISI JIKA TIDAK ADA PESANAN) */
        .dark .bg-gray-100 {
            background-color: #0f172a !important;
        }
        .dark .text-gray-900 {
            color: #f1f5f9 !important;
        }
        .dark .border-dashed {
            border-color: #334155 !important;
        }

        /* 6. PILL STATUS */
        .dark .status-paid { background: rgba(21, 128, 61, 0.2); color: #4ade80; border-color: rgba(34, 197, 94, 0.3); }
        .dark .status-unpaid { background: rgba(180, 83, 9, 0.2); color: #fbbf24; border-color: rgba(245, 158, 11, 0.3); }
        .dark .status-order { background: rgba(29, 78, 216, 0.2); color: #60a5fa; border-color: rgba(59, 130, 246, 0.3); }

        /* ====================================================================
           UKURAN GRID DESKTOP BARU (ANTREAN PESANAN LEBIH BESAR)
           ==================================================================== */
        .pos-shell {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 1.25rem;
            align-items: start;
        }

        @media (min-width: 1400px) {
            .pos-shell {
                grid-template-columns: 1.4fr 1fr;
            }
        }

        @media (max-width: 1024px) {
            .pos-shell {
                grid-template-columns: 1fr;
            }
        }

        /* ===== Detail transaksi (struk POS style) ===== */
        .pos-receipt-container {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            border-radius: 0.875rem;
            padding: 1.1rem;
        }

        .menu-line {
            display: grid;
            grid-template-columns: 38px 1fr auto;
            gap: 0.75rem;
            align-items: center;
            padding: 0.4rem 0;
        }

        .menu-thumb {
            width: 34px;
            height: 34px;
            border-radius: 0.6rem;
            background: #f3f4f6;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }
        .menu-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .menu-name {
            font-size: 0.78rem;
            font-weight: 900;
            color: #111827;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-sub {
            margin-top: 0.15rem;
            font-size: 0.68rem;
            font-weight: 900;
            color: #9ca3af;
        }

        .qty-pill {
            min-width: 2.25rem;
            height: 1.35rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 0.45rem;
            border-radius: 0.5rem;
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
            font-size: 0.68rem;
            font-weight: 900;
            letter-spacing: 0.02em;
        }

        .receipt-dashed {
            border-top: 1px dashed #d1d5db;
            margin: 0.85rem 0;
        }

        .money-rows {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }
        .money-row {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            column-gap: 1rem;
        }
        .money-label {
            font-size: 0.75rem;
            font-weight: 900;
            color: #6b7280;
        }
        .dark .money-label {
            color: #94a3b8 !important;
        }
        .money-value {
            font-size: 0.95rem;
            font-weight: 900;
            color: #111827;
        }
        .money-value.bold {
            font-weight: 1000;
        }
        .money-value.change {
            color: #15803d;
        }

        .queue-panel {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 18px 45px -35px rgba(15, 23, 42, 0.35);
        }

        /* FIX KUNCI ABSOLUTE KONTANER DETAIL */
        .detail-panel {
            position: relative; 
            border: 1px solid #e5e7eb;
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 18px 45px -35px rgba(15, 23, 42, 0.35);
        }

        .queue-list {
            max-height: calc(100vh - 15rem);
            overflow-y: auto;
        }

        .order-card {
            width: 100%;
            text-align: left;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            border-radius: 0.625rem;
            padding: 0.875rem;
            transition: border-color 160ms ease, background 160ms ease, box-shadow 160ms ease;
        }

        .order-card:hover,
        .order-card.is-active {
            border-color: #f97316;
            background: #fff7ed;
            box-shadow: 0 12px 28px -22px rgba(249, 115, 22, 0.9);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.3rem 0.65rem;
            font-size: 0.7rem;
            font-weight: 900;
            line-height: 1;
            border: 1px solid transparent;
        }

        .status-paid { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .status-unpaid { background: #fffbeb; color: #b45309; border-color: #fde68a; }
        .status-order { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .money-input input {
            background: #ffffff;
            border: 1px solid #d1d5db;
        }

        .summary-box {
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 0.625rem;
            padding: 0.875rem;
        }

        .summary-label {
            color: #9ca3af;
            font-size: 0.68rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .summary-value {
            margin-top: 0.25rem;
            color: #111827;
            font-size: 1.05rem;
            font-weight: 900;
            line-height: 1.2;
        }

        .summary-value.total {
            font-size: 1.35rem;
        }

        .summary-value.change {
            color: #15803d;
        }

        .summary-value.change.negative {
            color: #dc2626;
        }

        .primary-pay {
            background: #16a34a !important;
            color: #ffffff !important;
            font-weight: 900 !important;
        }

        .primary-print {
            background: #f97316 !important;
            color: #ffffff !important;
            font-weight: 900 !important;
        }

        .payment-box {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 0.25rem;
        }

        .payment-fields {
            display: grid;
            gap: 1.125rem;
            padding-top: 0.25rem;
        }

        .payment-field {
            display: block;
        }

        .payment-field + .payment-field {
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
        }

        .money-input {
            position: relative;
        }

        .money-input span {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 800;
            pointer-events: none;
        }

        .money-input input {
            padding-left: 2.75rem;
        }

        .action-stack {
            display: grid;
            gap: 0.5rem;
            padding-top: 0.5rem;
        }

        /* PENETAPAN DENGAN PRIORITAS TINGGI UNTUK TOMBOL HAPUS */
        .danger-action {
            position: absolute !important;
            top: 1.15rem !important;
            right: 1.25rem !important;
            z-index: 40 !important;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.625rem;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #dc2626;
            padding: 0.4rem 0.85rem;
            font-size: 0.75rem;
            font-weight: 800;
            transition: background 160ms ease, color 160ms ease, border-color 160ms ease;
        }

        .danger-action:hover {
            background: #fee2e2 !important;
            border-color: #fca5a5 !important;
            color: #b91c1c !important;
        }

        .mobile-detail-backdrop,
        .mobile-back-button {
            display: none;
        }

        @media (max-width: 1024px) {
            .queue-list {
                max-height: none;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .detail-panel {
                display: none;
            }

            .detail-panel.is-mobile-open {
                display: block;
                position: fixed;
                inset: 1rem;
                z-index: 60;
                max-height: calc(100vh - 2rem);
                overflow-y: auto;
                border-radius: 0.875rem;
                box-shadow: 0 25px 80px -30px rgba(15, 23, 42, 0.7);
            }

            .mobile-detail-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 50;
                background: rgba(15, 23, 42, 0.55);
                backdrop-filter: blur(2px);
            }

            .mobile-back-button {
                display: block;
                margin-top: 0.75rem; 
                padding: 0 1.25rem 1.25rem 1.25rem; 
            }

            .mobile-back-button a, 
            .mobile-back-button button,
            .mobile-back-button .fi-btn {
                width: 100% !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                padding-top: 0.6rem !important;
                padding-bottom: 0.6rem !important;
            }
        }
    </style>

    <div class="pos-shell">
        <!-- SEKSYEN KIRI: ANTREAN PESANAN -->
        <section class="queue-panel">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 dark:border-slate-700 px-4 py-3">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-wide text-gray-900">Antrean Pesanan</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $orders->count() }} pesanan</p>
                </div>

                <select
                    wire:model.live="statusFilter"
                    class="rounded-lg border-gray-200 bg-white px-3 py-2 text-xs font-bold text-gray-700 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                >
                    <option value="all">Semua</option>
                    <option value="unpaid">Belum Bayar</option>
                    <option value="paid">Lunas</option>
                </select>
            </div>

            <div class="queue-list space-y-2 p-3">
                @forelse($orders as $order)
                    <button
                        type="button"
                        wire:click="selectOrder({{ $order->id }})"
                        class="order-card {{ $selectedOrder?->id === $order->id ? 'is-active' : '' }}"
                    >
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="truncate text-sm font-black text-gray-950">
                                    {{ $order->customer_name ? ucwords($order->customer_name) : 'Tanpa Nama' }}
                                </div>
                                <div class="mt-1 text-xs font-semibold text-gray-500 dark:text-gray-400">
                                    Meja {{ $order->table_number ?: '-' }} &middot; {{ $order->created_at?->format('H:i') }}
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-sm font-black text-orange-600">
                                    Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-1.5">
                            <span class="status-pill {{ $order->payment_status === 'paid' ? 'status-paid' : 'status-unpaid' }}">
                                {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                            </span>
                            <span class="status-pill status-order">
                                {{ $order->status === 'done' ? 'Selesai' : 'Pending' }}
                            </span>
                        </div>
                    </button>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 p-8 text-center text-sm font-semibold text-gray-400">
                        Belum ada pesanan.
                    </div>
                @endforelse
            </div>
        </section>

        @if($mobileDetailOpen)
            <button type="button" wire:click="closeMobileDetail" class="mobile-detail-backdrop" aria-label="Tutup detail pesanan"></button>
        @endif

        <!-- SEKSYEN KANAN: DETAIL PESANAN -->
        <section class="detail-panel {{ $mobileDetailOpen ? 'is-mobile-open' : '' }}">
            @if($selectedOrder)
                <!-- AREA HEADER BARU: NAMA, NO MEJA & TOMBOL HAPUS -->
                <!-- AREA HEADER BARU: WRAPPER BOX UNTUK NAMA & NO MEJA -->
                <div class="border-b border-gray-100 dark:border-slate-700 p-5 pr-32 block w-full">
                    
                    <!-- Kotak Pembungkus Utama (Card Box) -->
                    <div class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-xl p-4 shadow-sm transition-colors">
                        <div class="flex items-start gap-3">
                            <!-- Slot Ikon Profil Mini -->
                            <div class="p-2 bg-orange-100 dark:bg-orange-950 text-orange-600 dark:text-orange-400 rounded-lg flex-shrink-0 mt-0.5">
                            </div>
                            
                            <!-- Isi Informasi Utama -->
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-0.5">Pelanggan</span>
                                <h2 class="text-lg font-black text-gray-900 dark:text-white truncate tracking-tight leading-tight">
                                    {{ $selectedOrder->customer_name ? ucwords($selectedOrder->customer_name) : 'Tanpa Nama' }}
                               </h2>
                                
                                <!-- Garis Pembatas Halus Internal -->
                                <div class="my-2.5 border-t border-gray-200/60 dark:border-slate-800"></div>
                                
                                <!-- Baris badge meja & waktu -->
                                <div class="flex flex-wrap items-center gap-2 text-xs font-bold text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white dark:bg-slate-800 rounded-md border border-gray-200 dark:border-slate-700 text-orange-600 dark:text-orange-500 shadow-xs">
                                        Meja: <span class="font-black text-sm">{{ $selectedOrder->table_number ?: '-' }}</span>
                                    </span>
                                    <span class="text-gray-300 dark:text-slate-700 font-normal">&middot;</span>
                                    <span class="text-[11px] font-medium opacity-85 mt-0.5">{{ $selectedOrder->created_at?->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Hapus Tetap Mengapung Secara Absolut di Sisi Luar Kanan Atas -->
                    <button
                        type="button"
                        wire:click="deleteSelected"
                        wire:confirm="Hapus pesanan ini?"
                        class="danger-action"
                        title="Hapus pesanan"
                    >
                        Hapus
                    </button>
                </div>

                <div class="grid gap-5 p-5 xl:grid-cols-[1.1fr_1fr]">
                    <div class="pos-receipt-container">
                        <h3 class="mb-3 text-xs font-black uppercase tracking-widest text-gray-400">Detail Pesanan</h3>

                        <div class="space-y-1">
                            @foreach($selectedOrder->items as $item)
                                <div class="menu-line">
                                    <div class="menu-thumb">
                                        @if($item->product?->image_url)
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product?->name ?? 'Produk' }}" />
                                        @else
                                            <img src="{{ asset('images/air.jpg') }}" alt="Produk" />
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <div class="menu-name">
                                            {{ $item->product?->name ?? 'Produk dihapus' }}
                                        </div>
                                        <div class="menu-sub">
                                            Rp {{ number_format((float) $item->price, 0, ',', '.') }} / item
                                        </div>
                                    </div>

                                    <div class="qty-pill">
                                        {{ $item->quantity }}x
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="receipt-dashed"></div>

                        <div class="money-rows">
                            <div class="money-row">
                                <div class="money-label">TOTAL</div>
                                <div class="money-value bold">
                                    Rp {{ number_format((float) $selectedOrder->total_price, 0, ',', '.') }}
                                </div>
                            </div>

                            @if($showPaymentResult)
                                <div class="money-row">
                                    <div class="money-label">DIBAYAR</div>
                                    <div class="money-value bold">
                                        Rp {{ number_format((float) preg_replace('/[^0-9]/', '', (string) $cash), 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="money-row">
                                    <div class="money-label">KEMBALIAN</div>
                                    <div class="money-value bold change">
                                        Rp {{ number_format((float) $change, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="receipt-dashed"></div>
                    </div>

                    <aside class="space-y-4">
                        <div class="payment-box">
                            <div class="mb-3 text-xs font-black uppercase tracking-widest text-gray-400">Pembayaran</div>

                            <div class="payment-fields">
                                <label class="payment-field">
                                    <span class="mb-1 block text-xs font-bold text-gray-600">Metode Pembayaran</span>
                                    <select
                                        wire:model.live="paymentMethod"
                                        class="w-full rounded-lg border-gray-300 text-sm font-semibold shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option value="cash">Tunai</option>
                                        <option value="transfer_bank">Transfer Bank</option>
                                        <option value="e_wallet">E-Wallet</option>
                                    </select>
                                </label>

                                <label class="payment-field">
                                    <span class="mb-1 block text-xs font-bold text-gray-600">Dibayar</span>
                                    <div
                                        class="money-input"
                                        x-data="{
                                            raw: @entangle('cash'),
                                            display: '',
                                            digits(value) {
                                                return String(value ?? '').replace(/[^0-9]/g, '');
                                            },
                                            format(value) {
                                                const digits = this.digits(value);
                                                return digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '0';
                                            },
                                            update(value) {
                                                const digits = this.digits(value);
                                                this.raw = digits || '0';
                                                this.display = digits;
                                            },
                                            finish() {
                                                this.raw = this.digits(this.display) || '0';
                                                this.display = this.format(this.raw);
                                                this.$wire.finishCashInput(this.raw);
                                            },
                                            init() {
                                                this.display = this.format(this.raw);
                                            },
                                        }"
                                    >
                                        <span>Rp</span>
                                        <input
                                            type="text"
                                            inputmode="numeric"
                                            x-ref="input"
                                            x-model="display"
                                            x-on:focus="display = digits(raw)"
                                            x-on:input="update($event.target.value)"
                                            x-on:blur="finish()"
                                            x-on:keydown.enter.prevent="finish(); $refs.input.blur()"
                                            class="w-full rounded-lg border-gray-300 text-lg font-black shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        />
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="action-stack">
                            @if($selectedOrder->payment_status !== 'paid')
                                <x-filament::button
                                    type="button"
                                    wire:click="paySelected"
                                    icon="heroicon-o-banknotes"
                                    size="lg"
                                    class="primary-pay w-full justify-center"
                                >
                                    Bayar
                                </x-filament::button>
                            @elseif($selectedOrder->status === 'pending')
                                <x-filament::button
                                    type="button"
                                    wire:click="confirmSelected"
                                    icon="heroicon-o-check-circle"
                                    color="info"
                                    size="lg"
                                    class="w-full justify-center"
                                >
                                    Konfirmasi
                                </x-filament::button>
                            @else
                                <x-filament::button
                                    tag="a"
                                    href="{{ route('admin.orders.receipt', $selectedOrder) }}"
                                    target="_blank"
                                    icon="heroicon-o-printer"
                                    size="lg"
                                    class="primary-print w-full justify-center"
                                >
                                    Cetak Struk
                                </x-filament::button>
                            @endif
                        </div>

                        <div class="mobile-back-button">
                            <x-filament::button
                                type="button"
                                wire:click="closeMobileDetail"
                                color="gray"
                                size="lg"
                                class="w-full justify-center"
                            >
                                Kembali
                            </x-filament::button>
                        </div>
                    </aside>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-slate-800 dark:text-gray-500">
                        <x-heroicon-o-clipboard-document-list class="h-7 w-7" />
                    </div>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white">Tidak ada pesanan</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pesanan dari kasir akan muncul di sini.</p>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>