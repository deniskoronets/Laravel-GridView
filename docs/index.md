# GridView v2

<p align="center">
    <img src="./screen.png" width="500">
</p>

Completely reused, rebuild and refactored gridview for laravel!

## Installation
```
composer require woo/laravel-grid-view ^2.0
``` 

or add into `composer.json`:
```
"woo/laravel-grid-view": "^2.0"
```

*In case you use Laravel 5.4 or lower, please add:*
1) `Woo\GridView\GridViewServiceProvider::class` into `config/app.php`
2) Run `php artisan vendor:publish --tag=public --force`

Otherwise, Laravel autodiscover will load all needed stuff after composer install the package.

## Bugs
Please report bugs into <a href="https://github.com/deniskoronets/Laravel-GridView/issues">issues</a> section of the repo.

## Documentation
- <a href="getting-started">Getting Started</a>
- <a href="grid-view-configuring">GridView Configuring</a>
- <a href="columns">Columns</a>
- <a href="data-providers">Data Providers</a>
- <a href="filters">Filters</a>
- <a href="formatters">Formatters</a>
- <a href="renderers">Renderers</a>
- <a href="recipes">Cool recipes</a>

# What's new?
In second version I almost rebuild everything.
New features are:
- Sort (for attributes columns)
- Filters are introduced
- Formatters are detouched into classes so now you can make your own formatters
- GridViewHelper is now open for adding extra aliases on app boot (you can make it through )
- <!> Achtung! No complete backward compatibility with v1. Please update with your own risk! In general, Action column api is totally different now - it was totally rebuild.

<b>Made with ❤ by <a href="https://woo.zp.ua">denis</b>