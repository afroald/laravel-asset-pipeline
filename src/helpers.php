<?php

if ( ! function_exists('stylesheet_link_tag'))
{
	function stylesheet_link_tag($name = 'application', $media = 'screen', $debug = false)
	{
		$asset = AssetPipeline::asset($name, 'stylesheet');
		$urls = array();

		if (AssetPipeline::debug() || $debug) {
			$requiredAssets = $asset->requiredAssets;
			foreach ($requiredAssets as $requiredAsset)
			{
				array_push($urls, AssetPipeline::url($requiredAsset));
			}
		}
		else {
			$manifest = app('asset-pipeline.manifest');
			$filename = $manifest->get($asset->logicalPath);
			$filesystem = new \Symfony\Component\Filesystem\Filesystem;

			$urls[] = URL::to($filesystem->makePathRelative(Config::get('asset-pipeline::public_path'), public_path()) . $filename);
		}

		$html = array();
		foreach ($urls as $url)
		{
			$html[] = "<link href=\"$url\" media=\"$media\" rel=\"stylesheet\" />";
		}

		return implode("\n", $html);
	}
}

if ( ! function_exists('javascript_include_tag'))
{
	function javascript_include_tag($name = 'application', $debug = false)
	{
		$asset = AssetPipeline::asset($name, 'javascript');
		$urls = array();

		if (AssetPipeline::debug() || $debug) {
			$requiredAssets = $asset->requiredAssets;
			foreach ($requiredAssets as $requiredAsset)
			{
				array_push($urls, AssetPipeline::url($requiredAsset));
			}
		}
		else {
			$manifest = app('asset-pipeline.manifest');
			$filename = $manifest->get($asset->logicalPath);
			$filesystem = new \Symfony\Component\Filesystem\Filesystem;

			$urls[] = URL::to($filesystem->makePathRelative(Config::get('asset-pipeline::public_path'), public_path()) . $filename);
		}

		$html = array();
		foreach ($urls as $url)
		{
			$html[] = "<script src=\"$url\"></script>";
		}

		return implode("\n", $html);
	}
}

if ( ! function_exists('image_tag'))
{
	function image_tag($name)
	{
		
	}
}

if ( ! function_exists('asset_path'))
{
	function asset_path($name, $debug = false)
	{
		$manifest = app('asset-pipeline.manifest');

		if (!AssetPipeline::debug() && !$debug && $manifest->has($name))
		{
			$filename = $manifest->get($asset->logicalPath);
			$filesystem = new \Symfony\Component\Filesystem\Filesystem;
			return URL::to($filesystem->makePathRelative(Config::get('asset-pipeline::public_path'), public_path()) . $filename);
		}

		$asset = AssetPipeline::asset($name);

		return AssetPipeline::url($asset);
	}
}