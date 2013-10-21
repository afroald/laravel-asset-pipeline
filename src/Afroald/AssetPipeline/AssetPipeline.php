<?php namespace Afroald\AssetPipeline;


use Config;
use URL;

use Sprockets\Asset;
use Sprockets\Pipeline;
use Sprockets\Asset\LogicalPath;

use Afroald\AssetPipeline\Manifest;

class AssetPipeline extends Pipeline {

	protected $manifest;

	public function __construct(array $config, Manifest $manifest)
	{
		$loadPaths = $config['load_paths'];
		unset($config['load_paths']);
		$this->config = $this->mergeOptions($this->config, $config);

		$this->manifest = $manifest;

		parent::__construct($loadPaths);
	}

	public function url(Asset $asset)
	{
		if ($this->manifest->has($asset->logicalPathname) && !$this->debug())
		{
			$logicalPathname = $this->manifest->get($asset->logicalPathname);

			return $this->urlForLogicalPathname($logicalPathname);
		}

		if ($this->debug() && count($asset->requiredAssets) > 1)
		{
			$pipeline = $this;

			return array_map(function($asset) use($pipeline)
			{
				return $pipeline->urlForLogicalPathname($asset->logicalPathname);
			}, $asset->requiredAssets);
		}

		return $this->urlForLogicalPathname($asset->logicalPathname);
	}

	public function urlForLogicalPathname($logicalPathname)
	{
		return URL::to($this->config['public_url'] . '/' . $logicalPathname . ($this->debug() ? '?body=1' : ''));
	}

	public function debug()
	{
		if (Config::has('asset-pipeline::debug')) {
			return Config::get('asset-pipeline::debug');
		}

		return Config::get('app.debug');
	}
}