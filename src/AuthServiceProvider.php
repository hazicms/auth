<?php namespace HaziCms;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// dd("a");
		
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		echo("b");
		$this->publishes([
			__DIR__.'/Config/Http/Middleware' => base_path('app/Http/Middleware')
		]);
		echo("c");
	}

}
