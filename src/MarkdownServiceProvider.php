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

		$resolver = $view->getEngineResolver();

		$resolver->register('md.blade', function() use ($app)
		{
			$cache = $app['path.storage'].'/views';

			// The Compiler engine requires an instance of the CompilerInterface, which in
			// this case will be the Blade compiler, so we'll first create the compiler
			// instance to pass into the engine so it can compile the views properly.
			$compiler = new BladeMarkdownCompiler($app['files'], $cache);

			return new CompilerEngine($compiler, $app['files']);
		});

		$app->singleton('markdown', 'dflydev\markdown\MarkdownParser');

		$view->addExtension('md', 'markdown', function() use ($app) {
			return new MarkdownEngine($app['markdown']);
		});

		$view->addExtension('md.php', 'php-markdown', function() use ($app) {
			return new PhpMarkdownEngine($app['markdown']);
		});

		$view->addExtension('md.blade.php', 'blade-markdown', function() use ($app, $view) {
			$resolver = $view->getEngineResolver();
			$compiler = $resolver->resolve('md.blade')->getCompiler();
			return new BladeMarkdownEngine($compiler, $app['markdown']);
		});

	}

}
