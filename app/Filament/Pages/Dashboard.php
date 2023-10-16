<?php

namespace App\Filament\Pages;

use Closure;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BasePage;
use Illuminate\Support\Facades\Route;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament::pages.dashboard';

    protected static function getNavigationLabel(): string
    {
        return 'Strona główna';
    }

    public static function getRoutes(): Closure
    {
        return function () {
            Route::get('/', static::class)->name(static::getSlug());
        };
    }

    protected function getColumns(): int | string | array
    {
        return 2;
    }

    protected function getTitle(): string
    {
        return 'Strona główna';
    }

    protected function getWidgets(): array
    {
        return Filament::getWidgets();
    }
}
