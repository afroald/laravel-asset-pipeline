<?php namespace Afroald\AssetPipeline;

use Exception;
use Sprockets\File;

class Precompiler {

	protected $pipeline;
	protected $manifest;
	protected $outputPath;

	public function __construct(AssetPipeline $pipeline, Manifest $manifest, $outputPath)
	{
		$this->pipeline = $pipeline;
		$this->manifest = $manifest;
		$this->outputPath = $outputPath;
	}

	public function compile($filters)
	{
		$assets = $this->pipeline->all();
		$this->manifest->reset();

		foreach ($assets as $asset)
		{
			// Does this asset match a filter?
			$match = false;
			foreach ($filters as $filter)
			{
				if (is_callable($filter))
				{
					$match = $filter($asset);
				}
				else if (is_string($filter))
				{
					$match = $filter === $asset->name;
				}

				if ($match)
					break;
			}

			if (!$match)
				continue;

			// Output the file with and without the digest in the filename
			$output = new File($this->outputPath . DIRECTORY_SEPARATOR . $asset->name(true));
			$output->put($asset->content);

			if ($asset->isStatic())
			{
				$output = new File($this->outputPath . $asset->logicalPath);
				$output->put($asset->content);
			}

			$this->manifest->add($asset);
		}

		$this->manifest->save();
	}

	protected function writeManifest()
	{
		$this->manifestFile->put(json_encode($this->manifest));
	}

}