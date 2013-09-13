<?php namespace Kindari\LaravelMarkdown;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

class BladeMarkdownCompiler extends BladeCompiler {

	/**
	 * Create a new compiler instance.
	 *
	 * @param  \Illuminate\Filesystem\Filesystem  $files
	 * @param  string  $cachePath
	 * @param  \dflydev\markdown\MarkdownParser $parser
	 * @return void
	 */
	public function __construct(Filesystem $files, $cachePath, $parser)
	{
		parent::__construct($files, $cachePath);
		$this->parser = $parser;
	}

	/**
	 * Compile Blade section start statements into valid PHP.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected function compileSectionStart($value)
	{
		$pattern = '/(@section\((.+)\))(.+)(@stop)/sm';

		// Capture the content within the section.
		preg_match($pattern, $value, $matches);

		if (! empty($matches))
		{
			// Transform the content from markdown.
			$parsed = $this->parser->transform($matches[3]);

			// Pass the content back into the value.
			$value = preg_replace($pattern, '$1'.$parsed.'$4', $value);
		}

		$pattern = $this->createMatcher('section');

		return preg_replace($pattern, '$1<?php $__env->startSection$2; ?>', $value);
	}

}