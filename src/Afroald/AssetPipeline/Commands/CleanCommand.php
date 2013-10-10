<?php namespace Afroald\AssetPipeline\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CleanCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'assets:clean';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove all precompiled assets.';

	protected $files;
	protected $publicPath;
	protected $manifestPath;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Filesystem $files, $publicPath, $manifestPath)
	{
		parent::__construct();

		$this->files = $files;
		$this->publicPath = $publicPath;
		$this->manifestPath = $manifestPath;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->files->delete($this->manifestPath);
		$this->files->deleteDirectory($this->publicPath, true);
	}

}