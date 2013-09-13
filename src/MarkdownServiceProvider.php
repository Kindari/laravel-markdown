<?php namespace Kindari\LaravelMarkdown;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;

class MarkdownServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		list($app, $view) = array($this->app, $this->app['view']);

		$app->singleton('markdown', 'dflydev\markdown\MarkdownParser');

		$view->addExtension('md', 'markdown', function() use ($app) {
			return new MarkdownEngine($app['markdown']);
		});

		$view->addExtension('md.php', 'php-markdown', function() use ($app) {
			return new PhpMarkdownEngine($app['markdown']);
		});

		$view->addExtension('md.blade.php', 'blade-markdown', function() use ($app) {
			$cache = $app['path.storage'].'/views';
			$compiler = new BladeMarkdownCompiler($app['files'], $cache, $app['markdown']);
			return new CompilerEngine($compiler);
		});

	}

}
