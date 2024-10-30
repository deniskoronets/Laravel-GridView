<?php

namespace Woo\GridView;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Woo\GridView\Middlewares\InjectGridJsMiddleware;

class GridViewServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->app['router']->pushMiddlewareToGroup('web', InjectGridJsMiddleware::class);

		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'woo_gridview');

		require_once __DIR__ . '/functions.php';

        \Blade::directive('grid', function ($expression) {
            return "<?php echo grid($expression) ?>";
        });
	}

	public function register()
	{
		//
	}
}
