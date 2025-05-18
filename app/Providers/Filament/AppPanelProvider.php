<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Tenancy\EditTeam;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Http\Middleware\SetCurrentTeam;
use App\Models\Team;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->spa()
            ->brandLogo(fn() => view('filament.logo'))
            ->viteTheme('resources/css/filament/app/theme.css')
            ->tenant(Team::class, slugAttribute: 'slug')
            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeam::class)
            ->tenantMiddleware([
                SetCurrentTeam::class,
            ])
            ->navigationGroups([
                NavigationGroup::make(fn() => Filament::getTenant()->name)
                    ->label(__('Team'))
            ])
            ->navigationItems([
                NavigationItem::make('team-settings')
                    ->label(__('Team Settings'))
                    ->group(fn() => Filament::getTenant()->name)
                    ->visible(fn() => auth()->user()->can('update', Filament::getTenant()))
                    ->url(fn() => route('filament.app.tenant.profile', ['tenant' => Filament::getTenant()]))
                    ->icon(Heroicon::Cog)
            ])
            ->login()
            ->registration()
            ->emailVerification()
            ->passwordReset()
            ->path('')
            ->colors([
                'primary' => Color::Violet,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
            ])
            ->renderHook('panels::auth.login.form.after', fn() => view('auth.google'))
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
