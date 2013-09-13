<?php namespace Kindari\LaravelMarkdown;

use Illuminate\View\Compilers\BladeCompiler;

class BladeMarkdownCompiler extends BladeCompiler {

	/**
	 * Compiler functions to transform through markdown.
	 *
	 * @var array
	 */
	protected $transformCompilers = array(
		'SectionStop',
		'SectionOverwrite',
	);

	/**
	 * Compile Blade section stop statements into valid PHP.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected function compileSectionStop($value)
	{
		$pattern = $this->createPlainMatcher('stop');

		$value = preg_replace($pattern, '$1<?php $__env->stopSection(); ?>$2', $value);

		$pattern = $this->createPlainMatcher('endsection');

		return preg_replace($pattern, '$1<?php $__env->stopSection(); ?>$2', $value);
	}

	/**
	 * Compile Blade section stop statements into valid PHP.
	 *
	 * @param  string  $value
	 * @return string
	 */
	protected function compileSectionOverwrite($value)
	{
		$pattern = $this->createPlainMatcher('overwrite');

		return preg_replace($pattern, '$1<?php $__env->stopSection(true); ?>$2', $value);
	}

}