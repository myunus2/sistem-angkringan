<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Transaksi extends Page
{
    protected string $view = 'filament.pages.transaksi';

    public static function getNavigationLabel(): string
    {
        return '💰 Transaksi';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationSort(): ?int
    {
        return 3; 
    }
}