<x-filament-panels::page>
    <style>
        .pos-shell {
            display: grid;
            grid-template-columns: minmax(280px, 380px) minmax(0, 1fr);
            gap: 1rem;
            align-items: start;
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

        @media (max-width: 1024px) {
            .pos-shell {
                grid-template-columns: 1fr;
            }

            .queue-list {
                max-height: 22rem;
            }

            .summary-grid {
                grid-template-columns: 1fr;
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

        <section class="detail-panel">
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
                    <div>
                        <h3 class="mb-3 text-xs font-black uppercase tracking-widest text-gray-400">Detail Item</h3>

                        <div class="space-y-2">
                            @foreach($selectedOrder->items as $item)
                                <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-black text-gray-900">
                                            {{ $item->product?->name ?? 'Produk dihapus' }}
                                        </div>
                                        <div class="text-xs font-semibold text-gray-500">
                                            {{ $item->quantity }} x Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="text-sm font-black text-gray-950">
                                        Rp {{ number_format((float) $item->price * $item->quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <aside class="space-y-4">
                        <div class="summary-grid xl:grid-cols-1">
                            <div class="summary-box">
                                <div class="summary-label">Total</div>
                                <div class="summary-value total">
                                    Rp {{ number_format((float) $selectedOrder->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                            @if($showPaymentResult)
                                <div class="summary-box">
                                    <div class="summary-label">Dibayar</div>
                                    <div class="summary-value">
                                        Rp {{ number_format((float) preg_replace('/[^0-9]/', '', (string) $cash), 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="summary-box">
                                    <div class="summary-label">Kembalian</div>
                                    <div class="summary-value change {{ $change < 0 ? 'negative' : '' }}">
                                        Rp {{ number_format((float) $change, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endif
                        </div>

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
