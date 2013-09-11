<?php namespace Afroald\AssetPipeline;


use Config;
use Sprockets\Asset;
use Sprockets\Pipeline;

class AssetPipeline extends Pipeline {

    public function url(Asset $asset)
    {
        // Also check the manifest!

        return url(Config::get('asset-pipeline::public_url') . $asset->logicalPath) . (Config::get('asset-pipeline::debug') ? '?body=1' : '');
    }
}