<?php

if ( ! function_exists('stylesheet_link_tag'))
{
	function stylesheet_link_tag($logicalPath = 'application', $media = 'screen')
	{
		$asset = AssetPipeline::asset($logicalPath, 'stylesheet');
		$url = AssetPipeline::url($asset);

		if (is_array($url))
		{
			$html = array_map(function($url) use($media)
			{
				return sprintf(AssetPipeline::STYLESHEET_TAG, $url, $media);
			}, $url);

			return implode("\n", $html);
		}

		return sprintf(AssetPipeline::STYLESHEET_TAG, $url, $media);
	}
}

if ( ! function_exists('javascript_include_tag'))
{
	function javascript_include_tag($logicalPath = 'application')
	{
		$asset = AssetPipeline::asset($logicalPath, 'javascript');
		$url = AssetPipeline::url($asset);

		if (is_array($url))
		{
			$html = array_map(function($url)
			{
				return sprintf(AssetPipeline::JAVASCRIPT_TAG, $url);
			}, $url);

			return implode("\n", $html);
		}

		return sprintf(AssetPipeline::JAVASCRIPT_TAG, $url);
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
	function asset_path($logicalPath, $debug = false)
	{
		$asset = AssetPipeline::asset($logicalPath);
		return AssetPipeline::url($asset);
	}
}