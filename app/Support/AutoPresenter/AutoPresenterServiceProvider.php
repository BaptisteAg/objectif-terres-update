<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use App\Support\AutoPresenter\Decorators\ArrayDecorator;
use App\Support\AutoPresenter\Decorators\AtomDecorator;
use App\Support\AutoPresenter\Decorators\PaginatorDecorator;

class AutoPresenterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->setupEventFiring($this->app);
        $this->setupEventListening($this->app);
    }

    protected function setupEventFiring(Container $app)
    {
        $app['view']->composer('*', function ($view) use ($app) {
            if ($view instanceof View) {
                $app['events']->dispatch('content.rendering', [$view]);
            }
        });
    }

    protected function setupEventListening(Container $app)
    {
        $app['events']->listen('content.rendering', function (View $view) use ($app) {
            if ($viewData = array_merge($view->getFactory()->getShared(), $view->getData())) {
                $decorator = $app['autopresenter'];
                foreach ($viewData as $key => $value) {
                    $view[$key] = $decorator->decorate($value);
                }
            }
        });
    }

    public function register()
    {
        $this->registerAutoPresenter($this->app);
    }

    public function registerAutoPresenter(Container $app)
    {
        $app->singleton('autopresenter', function (Container $app) {
            $autoPresenter = new AutoPresenter();

            $autoPresenter->register(new AtomDecorator($autoPresenter, $app));
            $autoPresenter->register(new ArrayDecorator($autoPresenter));
            $autoPresenter->register(new PaginatorDecorator($autoPresenter));

            return $autoPresenter;
        });

        $app->alias('autopresenter', AutoPresenter::class);
    }

    public function provides()
    {
        return [
            'autopresenter',
        ];
    }
}
