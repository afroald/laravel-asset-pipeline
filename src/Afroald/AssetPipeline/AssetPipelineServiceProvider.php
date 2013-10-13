<?php namespace Afroald\AssetPipeline;

use Afroald\AssetPipeline\Commands;
use Afroald\AssetPipeline\Engines;
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
		// because it won't be able to access this package's configuration.
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
		$this->registerCleanCommand();
		$this->registerPrecompileCommand();

		$this->commands(array(
			'asset-pipeline.clean',
			'asset-pipeline.precompile'
		));
	}

	public function registerAssetPipeline()
	{
		$this->app['asset-pipeline.manifest'] = $this->app->share(function($app) {
			return new Manifest($app['config']['asset-pipeline::manifest_path']);
		});

		$this->app['asset-pipeline'] = $this->app->share(function($app)
		{
			return new AssetPipeline($app['config']['asset-pipeline::config'], $app['asset-pipeline.manifest']);
		});
	}

	public function registerBladeEngine()
	{
		$app = $this->app;
		$pipeline = $app['asset-pipeline'];

		$cache = $app['path.storage'].'/views';
		$compilerEngine = $app['view.engine.resolver']->resolve('blade');

		$engine = new Engines\BladeEngine($pipeline, $app['files'], $compilerEngine, $cache);
		$pipeline->registerEngine('blade', $engine);
	}

	public function registerCleanCommand()
	{
		$this->app['asset-pipeline.clean'] = $this->app->share(function($app)
		{
			return new Commands\CleanCommand($app['files'], $app['config']['asset-pipeline::public_path'], $app['config']['asset-pipeline::manifest_path']);
		});
	}

	public function registerPrecompileCommand()
	{
		$this->app['asset-pipeline.precompile'] = $this->app->share(function($app) {
			$manifest = $app['asset-pipeline.manifest'];
			$precompiler = new Precompiler($app['asset-pipeline'], $manifest, $app['config']['asset-pipeline::public_path']);

			return new Commands\PrecompileCommand($precompiler, $app['config']['asset-pipeline::precompile']);
		});
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