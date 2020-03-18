<?php

namespace App\Providers;

use App\Services\Documents\DocumentService;
use App\Services\Documents\DocumentServiceInterface;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Omniphx\Forrest\Providers\Laravel\LaravelCache;
use Omniphx\Forrest\Providers\Laravel\LaravelEncryptor;
use Omniphx\Forrest\Providers\Laravel\LaravelSession;
use Omniphx\Forrest\Repositories\TokenRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(DocumentServiceInterface::class, DocumentService::class);

        $this->app->singleton('forrest_token', function ($app) {
            $encryptor = new LaravelEncryptor(app('encrypter'));

            $storageType = config('forrest.storage.type');
            switch ($storageType) {
                case 'session':
                    $storage = new LaravelSession(app('config'), app('request')->session());
                    break;
                case 'cache':
                    $storage = new LaravelCache(app('config'), app('cache')->store());
                    break;
                default:
                    $storage = new LaravelSession(app('config'), app('request')->session());
            }

            return new TokenRepository($encryptor, $storage);
        });
    }
}
