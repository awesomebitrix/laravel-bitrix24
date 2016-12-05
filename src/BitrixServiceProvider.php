<?php
namespace Antsupovsa\Bitrix;

use Illuminate\Support\ServiceProvider;

class BitrixServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBitrixService();

        if ($this->app->runningInConsole()) {
            $this->registerResources();
        }
    }

    /**
     * Register currency provider.
     *
     * @return void
     */
    public function registerBitrixService()
    {
        $this->app->singleton('bitrix', function ($app) {
            return new Bitrix($app->config->get('bitrix', []));
        });
    }

    /**
     * Register currency resources.
     *
     * @return void
     */
    public function registerResources()
    {
        if ($this->isLumen() === false) {
            $this->publishes([
                __DIR__ . '/../config/bitrix.php' => config_path('bitrix.php'),
            ], 'config');
        }
    }


    /**
     * Check if package is running under Lumen app
     *
     * @return bool
     */
    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen') === true;
    }
}