<?php

namespace Modules\Card\Providers;

use Modules\Card\Services\CardService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class CardServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Card';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'card';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind(CardService::class);
    }

    

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
