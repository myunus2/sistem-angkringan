<x-filament-widgets::widget>
    <x-filament::section>
        <div class="favorite-menus-widget" style="display: flex; flex-direction: column; gap: 18px;">
            <div>
                <h2 class="favorite-menus-title" style="margin: 0; font-size: 18px; font-weight: 700;">Menu Terfavorit</h2>
                <p class="favorite-menus-subtitle" style="margin: 4px 0 0; font-size: 13px;">Menu yang paling banyak dipesan pelanggan.</p>
            </div>

            @if($favoriteMenus->isNotEmpty())
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($favoriteMenus as $index => $menu)
                        @php
                            $rank = $index + 1;
                            $rankColor = match ($rank) {
                                1 => 'background: #c2410c; color: #fff7ed;',
                                2 => 'background: #f59e0b; color: #451a03;',
                                3 => 'background: #e5e7eb; color: #374151;',
                                default => 'background: #f3f4f6; color: #6b7280;',
                            };
                            $product = $menu->product;
                            $imageUrl = $product?->image_url ?: asset('images/air.jpg');
                        @endphp

                        <div class="favorite-menu-item" style="display: grid; grid-template-columns: 34px 58px minmax(0, 1fr); align-items: center; gap: 12px; padding: 10px; border-radius: 12px;">
                            <div style="{{ $rankColor }} width: 32px; height: 32px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 800;">
                                {{ $rank }}
                            </div>

                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $product?->name ?? 'Menu terhapus' }}"
                                class="favorite-menu-image"
                                style="width: 58px; height: 58px; border-radius: 12px; object-fit: cover;"
                                loading="lazy"
                                decoding="async"
                            >

                            <div style="min-width: 0;">
                                <div class="favorite-menu-name" style="font-size: 14px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $product?->name ?? 'Menu terhapus' }}
                                </div>
                                <div class="favorite-menu-count" style="margin-top: 4px; font-size: 12px;">
                                    {{ number_format((int) $menu->total_ordered) }} kali dipesan
                                </div>
                                <div class="favorite-menu-revenue" style="margin-top: 2px; font-size: 12px; font-weight: 600;">
                                    Rp {{ number_format((float) $menu->total_revenue, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="favorite-menu-empty" style="padding: 28px 16px; text-align: center; border-radius: 12px;">
                    Belum ada menu favorit.
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
