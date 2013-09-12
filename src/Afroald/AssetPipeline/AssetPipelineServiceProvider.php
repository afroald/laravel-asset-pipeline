<?php namespace Afroald\AssetPipeline;

use Afroald\AssetPipeline\Engine\BladeEngine;
use Illuminate\Support\ServiceProvider;

class AssetPipelineServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('afroald/asset-pipeline');

		// If the asset pipeline is resolved in the IoC container before the service is booted it will fail
		// because it won't be able to acces this package's configuration.
		$this->registerBladeEngine();

		include __DIR__ . '/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerAssetPipeline();
	}

	public function registerAssetPipeline()
	{
		$this->app['asset-pipeline'] = $this->app->share(function($app)
		{
			return new AssetPipeline($app['config']['asset-pipeline::load_paths']);
		});
	}

	public function registerBladeEngine()
	{
		$app = $this->app;
		$pipeline = $app['asset-pipeline'];

		$cache = $app['path.storage'].'/views';
		$compilerEngine = $app['view.engine.resolver']->resolve('blade');

		$engine = new BladeEngine($pipeline, $app['files'], $compilerEngine, $cache);
		$pipeline->registerEngine('.blade', $engine);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}