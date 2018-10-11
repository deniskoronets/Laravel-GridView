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
		$this->loadViewsFrom(__DIR__.'/../views', 'woo_gridview');

		require_once __DIR__ . '/functions.php';
	}

	public function register()
	{
		//
	}
}