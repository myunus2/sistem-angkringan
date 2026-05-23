<x-filament-panels::page>
    <style>
        /* ===== Dark Mode overrides ===== */
        body.fi-dark .queue-panel,
        html.fi-dark .queue-panel,
        .fi-dark .queue-panel,
        body.fi-dark .detail-panel,
        html.fi-dark .detail-panel,
        .fi-dark .detail-panel {
            border-color: #1f2937 !important;
            background: #0b1220 !important;
            box-shadow: 0 18px 45px -35px rgba(0, 0, 0, 0.55) !important;
        }

        body.fi-dark .pos-receipt-container,
        html.fi-dark .pos-receipt-container,
        .fi-dark .pos-receipt-container {
            border-color: #1f2937 !important;
            background: #0b1220 !important;
        }

        body.fi-dark .order-card,
        html.fi-dark .order-card,
        .fi-dark .order-card {
            border-color: #1f2937 !important;
            background: #0b1220 !important;
        }

        body.fi-dark .order-card:hover,
        html.fi-dark .order-card:hover,
        .fi-dark .order-card:hover,
        body.fi-dark .order-card.is-active,
        html.fi-dark .order-card.is-active,
        .fi-dark .order-card.is-active {
            border-color: #f97316 !important;
            background: rgba(249, 115, 22, 0.08) !important;
            box-shadow: 0 12px 28px -22px rgba(0, 0, 0, 0.6) !important;
        }

        body.fi-dark .menu-thumb,
        html.fi-dark .menu-thumb,
        .fi-dark .menu-thumb {
            background: #111827 !important;
            border-color: #1f2937 !important;
        }

        body.fi-dark .menu-name,
        html.fi-dark .menu-name,
        .fi-dark .menu-name {
            color: #e5e7eb !important;
        }

        body.fi-dark .menu-sub,
        html.fi-dark .menu-sub,
        .fi-dark .menu-sub {
            color: #9ca3af !important;
        }

        body.fi-dark .qty-pill,
        html.fi-dark .qty-pill,
        .fi-dark .qty-pill {
            background: #111827 !important;
            color: #d1d5db !important;
            border-color: #1f2937 !important;
        }

        body.fi-dark .receipt-dashed,
        html.fi-dark .receipt-dashed,
        .fi-dark .receipt-dashed {
            border-top-color: rgba(31, 41, 55, 0.75) !important;
        }

        body.fi-dark .money-label,
        html.fi-dark .money-label,
        .fi-dark .money-label {
            color: #9ca3af !important;
        }

        body.fi-dark .money-value,
        html.fi-dark .money-value,
        .fi-dark .money-value {
            color: #e5e7eb !important;
        }

        body.fi-dark .money-input input,
        html.fi-dark .money-input input,
        .fi-dark .money-input input {
            background: #0b1220 !important;
            border-color: #1f2937 !important;
            color: #e5e7eb !important;
        }

        body.fi-dark .payment-box,
        html.fi-dark .payment-box,
        .fi-dark .payment-box {
            border-color: #1f2937 !important;
            background: #0b1220 !important;
        }

        body.fi-dark select,
        html.fi-dark select,
        .fi-dark select {
            background: #0b1220 !important;
            color: #e5e7eb !important;
            border-color: #1f2937 !important;
        }

        body.fi-dark input,
        html.fi-dark input,
        .fi-dark input {
            background: #0b1220 !important;
            color: #e5e7eb !important;
            border-color: #1f2937 !important;
        }

        body.fi-dark .text-gray-900,
        html.fi-dark .text-gray-900,
        .fi-dark .text-gray-900,
        body.fi-dark .text-gray-950,
        html.fi-dark .text-gray-950,
        .fi-dark .text-gray-950 {
            color: #e5e7eb !important;
        }

        body.fi-dark .text-gray-500,
        html.fi-dark .text-gray-500,
        .fi-dark .text-gray-500 {
            color: #9ca3af !important;
        }

        body.fi-dark .text-gray-400,
        html.fi-dark .text-gray-400,
        .fi-dark .text-gray-400 {
            color: #9ca3af !important;
        }

        body.fi-dark .border-gray-100,
        html.fi-dark .border-gray-100,
        .fi-dark .border-gray-100 {
            border-color: rgba(31, 41, 55, 0.65) !important;
        }

        .pos-shell {


            display: grid;
            grid-template-columns: minmax(280px, 380px) minmax(0, 1fr);
            gap: 1rem;
            align-items: start;
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

        .queue-panel,
        .detail-panel {
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

        /* Input - buat tampilan kotak jelas */
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

        .danger-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.625rem;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #dc2626;
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 800;
            transition: background 160ms ease, color 160ms ease, border-color 160ms ease;
        }

        .danger-action:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #b91c1c;
        }

        .mobile-detail-backdrop,
        .mobile-back-button {
            display: none;
        }

        @media (max-width: 1024px) {
            .pos-shell {
                grid-template-columns: 1fr;
            }

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

            /* 1. Atur pembungkusnya agar berada di luar/bawah bingkai putih dengan pas */
            .mobile-back-button {
                display: block;
                /* Berikan margin atas agar ada jarak dengan tombol Cetak Struk */
                margin-top: 0.75rem; 
                /* Samakan padding kanan kiri dengan tombol Cetak Struk (sesuai layar) */
                padding: 0 1.25rem 1.25rem 1.25rem; 
            }

            /* 2. Targetkan class tombol bawaan Filament agar ukurannya flex dan full */
            .mobile-back-button a, 
            .mobile-back-button button,
            .mobile-back-button .fi-btn {
                width: 100% !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                /* Beri sedikit padding vertikal jika tombol terasa terlalu tipis */
                padding-top: 0.6rem !important;
                padding-bottom: 0.6rem !important;
            }
        }
    </style>

    <div class="pos-shell">
        <section class="queue-panel">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-4 py-3">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-wide text-gray-900">Antrean Pesanan</h2>
                    <p class="text-xs text-gray-500">{{ $orders->count() }} pesanan</p>
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
                                <div class="mt-1 text-xs font-semibold text-gray-500">
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

        <section class="detail-panel {{ $mobileDetailOpen ? 'is-mobile-open' : '' }}">
            @if($selectedOrder)
                <div class="relative border-b border-gray-100 px-5 py-4 pr-28">
                    <div>
                        <h2 class="mt-1 text-xl font-black text-gray-950">
                            {{ $selectedOrder->customer_name ? ucwords($selectedOrder->customer_name) : 'Tanpa Nama' }}
                        </h2>
                        <p class="text-sm font-medium text-gray-500">
                            Meja {{ $selectedOrder->table_number ?: '-' }} &middot; {{ $selectedOrder->created_at?->format('d M Y H:i') }}
                        </p>
                    </div>

                    <div class="absolute right-5 top-4">
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
                </div>

                    <div class="grid gap-5 p-5 xl:grid-cols-[1fr_360px]">
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
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                        <x-heroicon-o-clipboard-document-list class="h-7 w-7" />
                    </div>
                    <h2 class="text-lg font-black text-gray-900">Tidak ada pesanan</h2>
                    <p class="mt-1 text-sm text-gray-500">Pesanan dari kasir akan muncul di sini.</p>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
