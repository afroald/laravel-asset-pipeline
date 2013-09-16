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
    function javascript_include_tag($name = 'application')
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
    function asset_path($name)
    {
        $asset = AssetPipeline::asset($name);

        return AssetPipeline::url($asset);
    }
}