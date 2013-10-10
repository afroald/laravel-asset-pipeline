<?php namespace Afroald\AssetPipeline;

use Sprockets\Asset;
use Sprockets\File;

class Manifest {

	protected $file;
	protected $manifest = array();

	public function __construct($manifestPath)
	{
		$this->file = new File($manifestPath);

		$this->load();
	}

	public function add(Asset $asset)
	{
		$this->manifest[$asset->logicalPath] = $asset->name(true);
	}

	public function has($logicalPath)
	{
		return array_key_exists($logicalPath, $this->manifest);
	}

	public function get($logicalPath)
	{
		return $this->manifest[$logicalPath];
	}

	public function reset()
	{
		$this->manifest = array();
	}

	protected function load()
	{
		if (!$this->file->isFile())
			return;

		$this->manifest = json_decode($this->file->get(), true);
		return $this->manifest;
	}

	public function save()
	{
		$this->file->put(json_encode($this->manifest));
	}

}