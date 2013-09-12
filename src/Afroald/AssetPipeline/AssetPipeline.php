<?php namespace Afroald\AssetPipeline;


use Config;
use Sprockets\Asset;
use Sprockets\Pipeline;

class AssetPipeline extends Pipeline {

    public function url(Asset $asset)
    {
        // Also check the manifest!

        return url(Config::get('asset-pipeline::public_url') . $asset->logicalPath) . ($this->debug() ? '?body=1' : '');
    }

    public function debug()
    {
    	if (Config::has('asset-pipeline::debug')) {
    		return Config::get('asset-pipeline::debug');
    	}

    	return Config::get('app.debug');
    }
}