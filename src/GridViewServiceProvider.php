<?php

namespace Woo\GridView;

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
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'woo_gridview');

		require_once __DIR__ . '/functions.php';

        \Blade::directive('grid', function ($expression) {
            return "<?php echo grid($expression)->render() ?>";
        });

        $this->publishes([
            __DIR__ . '/../public' => 'public/vendor/grid-view',
        ], 'public');
	}

	public function register()
	{
		//
	}
}