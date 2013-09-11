<?php namespace Afroald\AssetPipeline;

class ManifestStore {
    protected $manifest = array();

    protected function load()
    {
        if (empty($this->manifest))
        {
            $manifestPath = Config::get('asset-pipeline::manifest_path') . '/assets.json';
            $this->manifest = json_decode();
        }
    }

    public function get($name)
    {

    }
}