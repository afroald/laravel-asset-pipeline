<?php namespace Afroald\AssetPipeline\Controllers;

use \AssetPipeline;
use \BaseController;
use \Illuminate\Routing\Controllers\Controller;
use \Sprockets\Exception\AssetNotFoundException;

class AssetController extends BaseController {
    public function fetchAsset($name)
    {
        try {
            $asset = AssetPipeline::asset($name);
        }
        catch (AssetNotFoundException $exception) {
            App::abort(404);
        }

        return \Response::make($asset, 200, array('Content-Type' => $asset->mimeType()))
                    ->setPublic()
                    ->setLastModified($asset->lastModified());
    }
}