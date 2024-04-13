<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainorSubdomain;
use Filament\Enums\ThemeMode;
use App\Http\Middleware\RedirectToTenantDomain;




class ManagerTelegramPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('manager-telegram')
            ->path('manager')
            ->brandName('Telegram')
            ->registration()
            ->registrationRouteSlug('signup')
            ->login()
            ->loginRouteSlug('login')
            ->passwordReset()
            ->font('Cairo')
            ->defaultThemeMode(ThemeMode::System)
            ->brandLogo(url('https://www.svgrepo.com/show/76968/telegram.svg'))
            ->brandLogoHeight('2.6rem')
            ->favicon(asset('https://www.svgrepo.com/show/76968/telegram.svg'))
            ->databaseNotifications()
            ->databaseNotificationsPolling('60s')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Manager/Telegram/Resources'), for: 'App\\Filament\\Manager\\Telegram\\Resources')
            ->discoverPages(in: app_path('Filament/Manager/Telegram/Pages'), for: 'App\\Filament\\Manager\\Telegram\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Manager/Telegram/Widgets'), for: 'App\\Filament\\Manager\\Telegram\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
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
            ])->middleware([
                'universal',
                InitializeTenancyByDomainorSubdomain::class,
            ], isPersistent: true)
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authPasswordBroker('manager')
            ->authGuard('manager');
    }
}
