<?php

namespace Woo\GridView;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
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
            return "<?php echo grid($expression) ?>";
        });

        $this->publishes([
            __DIR__ . '/../public' => 'public/vendor/grid-view',
        ], 'public');

        if (!File::isDirectory(public_path('vendor/grid-view'))) {
            Artisan::call('vendor:publish', ['--tag' => 'public', '--force' => '']);
        }
	}

	public function register()
	{
		//
	}
}