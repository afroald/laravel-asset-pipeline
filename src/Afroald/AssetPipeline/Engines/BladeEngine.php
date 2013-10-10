<?php namespace Afroald\AssetPipeline\Engines;

use Sprockets\Asset;
use Sprockets\Pipeline;
use Sprockets\Processor;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\CompilerEngine;

class BladeEngine extends Processor {

	protected $compilerEngine;
	protected $cachePath;

	public function __construct(Pipeline $pipeline, Filesystem $files, CompilerEngine $compilerEngine, $cachePath)
	{
		parent::__construct($pipeline);

		$this->files = $files;
		$this->compilerEngine = $compilerEngine;
		$this->cachePath = $cachePath;
	}

	public function process(Asset $asset, $content)
	{
		// Save the content to a temporary file
		$filename = 'asset-'.md5($content);
		$path = $this->cachePath . "/$filename";

		$this->files->put($path, $content);

		// Pass the file to the compiler engine
		$content = $this->compilerEngine->get($path);

		// Remove the temp files
		$this->files->delete($path);
		$this->files->delete($this->compilerEngine->getCompiler()->getCompiledPath($path));

		// Return the results
		return $content;
	}

}