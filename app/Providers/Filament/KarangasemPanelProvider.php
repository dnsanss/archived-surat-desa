<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationGroup;
use App\Filament\Widgets\SuratMasukChart;
use App\Filament\Widgets\SuratStatWidget;
use App\Filament\Widgets\SuratKeluarChart;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Widgets\JumlahWargaWidget;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class KarangasemPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName('ADMIN DESA KARANGASEM')
            ->id('karangasem')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
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
            ])
            ->globalSearch(false)

            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Surat-Surat')
                    ->collapsible()
                    ->collapsed(),

                NavigationGroup::make()
                    ->label('Data Desa')
                    ->collapsible()
                    ->collapsed(),

                NavigationGroup::make()
                    ->label('informasi Desa')
                    ->collapsible()
                    ->collapsed(),
            ])

            ->renderHook(
                'panels::auth.login.form.after',
                fn() => view('filamen.custom.tombol-kembali')
            );
    }
    protected function getColumns(): int | array
    {
        return 12;
    }
    public function getWidgets(): array
    {
        return [
            JumlahWargaWidget::class,
            SuratStatWidget::class,
            SuratKeluarChart::class,
            SuratMasukChart::class,
        ];
    }
}
