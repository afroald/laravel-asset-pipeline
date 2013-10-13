<?php namespace Afroald\AssetPipeline\Facades;

use Illuminate\Support\Facades\Facade;

class AssetPipeline extends Facade {

	const STYLESHEET_TAG = '<link href="%s" media="%s" rel="stylesheet" />';
	const JAVASCRIPT_TAG = '<script src="%s"></script>';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'asset-pipeline'; }

}