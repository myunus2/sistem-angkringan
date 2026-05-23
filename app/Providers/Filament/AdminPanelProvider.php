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
                        /* Light Mode */
                        .fi-sidebar {
                            background-color: #ffffff !important;
                            border-right: 1px solid #e5e7eb !important;
                        }

                        /* Dark Mode */
                        /* Filament umumnya menambahkan class dark pada root (html/body). */
                        html.fi-dark .fi-sidebar,
                        body.fi-dark .fi-sidebar,
                        .fi-dark .fi-sidebar {
                            background-color: #0b1220 !important;
                            border-right: 1px solid #1f2937 !important;
                        }

                        html.fi-dark .fi-sidebar-item-button,
                        body.fi-dark .fi-sidebar-item-button,
                        .fi-dark .fi-sidebar-item-button {
                            color: #e5e7eb !important;
                        }

                        html.fi-dark .fi-sidebar-item-button:hover,
                        body.fi-dark .fi-sidebar-item-button:hover,
                        .fi-dark .fi-sidebar-item-button:hover {
                            background-color: rgba(249, 115, 22, 0.12) !important;
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