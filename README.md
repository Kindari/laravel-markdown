# Laravel Markdown

Laravel Markdown is a wrapper of dflydev/markdown which integrates it into Laravel's View engine. It supports markdown parsing, php preprocessing of markdown files, and blade preprocessing.

## Installation

Add `kindari/laravel-markdown` to `composer.json`.

    "kindari/laravel-markdown": "1.0.*"
    
Run `composer update` to pull down the latest version of Laravel Markdown. Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
		'Kindari\LaravelMarkdown\MarkdownServiceProvider',
    )

## Usage

Create a view file named foobar.md, foobar.md.php or foobar.md.blade.php then use it like normal:

    return View::make('foobar');