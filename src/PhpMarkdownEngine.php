<?php namespace Kindari\LaravelMarkdown;

use Illuminate\View\Exception;
use Illuminate\View\Environment;

use Illuminate\View\Engines\PhpEngine;

class PhpMarkdownEngine extends PhpEngine
{

	protected $parser;

	public function __construct($parser)
	{
		$this->parser = $parser;
	}

	/**
	 * Get the evaluated contents of the view.
	 *
	 * @param  string  $path
	 * @param  array   $data
	 * @return string
	 */
	public function get($path, array $data = array())
	{
		$contents = $this->evaluatePath($path, $data);
		return $this->parser->transform( $contents );
	}


}