<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('pages.homepage', \App\Http\Composers\ResearchComposer::class);
        View::composer('default', \App\Http\Composers\MessagesNotificationHeaderComposer::class);
        View::composer('layouts.header', \App\Http\Composers\InfoBanner::class);
    }
}
