<?php namespace Kindari\LaravelMarkdown;

use Illuminate\View\Engines\EngineInterface;

class MarkdownEngine implements EngineInterface
{

	protected $parser;

	public function __construct($parser)
	{
		$this->parser = $parser;
	}

	public function get($path, array $data = array())
	{
		return $this->parser->transform( file_get_contents($path) );
	}
}