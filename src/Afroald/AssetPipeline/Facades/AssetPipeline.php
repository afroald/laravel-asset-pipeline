<?php namespace Afroald\AssetPipeline\Facades;

use Illuminate\Support\Facades\Facade;

class AssetPipeline extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'asset-pipeline'; }

}