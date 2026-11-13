<?php

namespace App\Providers;

use App\Nova\Actions\ReallocateModeratorAds;
use App\Nova\Dashboards\Main;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request, Menu $menu) {
            return $menu->append([
                MenuSection::make('Objectif Terres', [
                    MenuItem::externalLink('Listes des utilisateurs par territoire', route('administrator.usersByTerritories')),
                    MenuItem::externalLink('Retour sur Objectif Terres', route('home')),
                ])->icon('external-link'),
            ]);
        });

        Nova::footer(function () {
            return Blade::render('<p class="mt-8 text-center text-xs text-80">{{ date(\'Y\') }} - Terre de Liens | All right reserved</p>');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->role >= 4;
        });
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ReallocateModeratorAds::class);
    }
}
