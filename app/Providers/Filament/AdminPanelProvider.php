<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Support\Facades\Blade; // <-- Pastikan import ini ada di atas
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => \Filament\Support\Colors\Color::Orange, 
                'gray' => \Filament\Support\Colors\Color::Slate,   
            ])
            
            // ====================================================================
            // TAMBAHKAN HOOK CSS DI SINI UNTUK MENGUBAH WARNA SIDEBAR KIRI
            // ====================================================================
            ->renderHook(
                'panels::styles.after',
                fn (): string => Blade::render('
                    <style>
                        /* Mengubah warna background sidebar kiri di tema terang (Light Mode) */
                        .fi-sidebar {
                            background-color: #ffffff !important; /* Ganti dengan HEX warna yang Anda mau */
                            border-right: 1px solid #e5e7eb !important;
                        }

                        /* Jika Anda ingin mengubah warna background item menu di dalam sidebar */
                        .fi-sidebar-item-button {
                            /* Gaya tambahan jika diperlukan */
                        }
                    </style>
                '),
            )
            // ====================================================================

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}