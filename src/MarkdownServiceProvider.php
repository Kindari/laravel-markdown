<?php namespace Kindari\LaravelMarkdown;

use Illuminate\Support\ServiceProvider;

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

		$view->addExtension('md.blade.php', 'blade-markdown', function() use ($app, $view) {
			$resolver = $view->getEngineResolver();
			$compiler = $resolver->resolve('blade')->getCompiler();
			return new BladeMarkdownEngine($compiler, $app['markdown']);
		});

	}

}
