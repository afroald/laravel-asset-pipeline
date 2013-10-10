<?php namespace Afroald\AssetPipeline\Commands;

use Afroald\AssetPipeline\Precompiler;
use Illuminate\Console\Command;

class PrecompileCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'assets:precompile';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Precompile assets.';

	protected $precompiler;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Precompiler $precompiler, $assets)
	{
		parent::__construct();

		$this->precompiler = $precompiler;
		$this->assets = $assets;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->call('assets:clean');
		$this->precompiler->compile($this->assets);
	}

}