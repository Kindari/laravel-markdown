<?php namespace Kindari\LaravelMarkdown;

use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\CompilerInterface;

class BladeMarkdownEngine extends CompilerEngine
{
	protected $parser;

	public function __construct(CompilerInterface $compiler, $parser)
	{
		parent::__construct($compiler);
		$this->parser = $parser;
	}


	public function get($path, array $data = array())
	{
		$contents = parent::get($path, $data);
		return $this->parser->transform( $contents );
	}

}