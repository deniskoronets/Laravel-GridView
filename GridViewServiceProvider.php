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
		$this->loadViewsFrom(__DIR__.'/views', 'gridview');
	}

	public function register()
	{
		//
	}
}