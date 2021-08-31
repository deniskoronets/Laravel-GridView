<?php

namespace Woo\GridView;

use Blade;
use Illuminate\Support\ServiceProvider;

class GridViewServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();

        $this->publishViews();
        $this->publishResources();

        $this->bootDirectives();
    }

    public function register()
    {
        //
    }

    private function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'woo_gridview');
    }

    private function publishViews()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/woo_gridview'),
        ], 'views');
    }

    private function publishResources()
    {
        $this->publishes([
            __DIR__ . '/../public' => 'public/vendor/woo_gridview',
        ], 'public');
    }

    private function bootDirectives()
    {
        Blade::directive('grid', function ($expression) {
            return "<?php echo grid($expression) ?>";
        });
    }
}