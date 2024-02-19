# GridView v2

<p align="center">
    <img src="./screen.png">
</p>

Cool and fully charged data table rendered for laravel 5+.

## Versions Policy
By looking on experience from v.1.x I decided to make minor versions backwardly compatible, 
which means that v.2.0 could be replaced with 2.3 or 2.5 with no breaks. 
But the same doesnt work for major versions, for example changing 2.1 to 3.1 doesn't work and there's no guarantee that it'll work.
Please be careful in picking right version in your composer.json. Do not specify wildcard (*) or ^ because it'll break your tables at some point.  

## Installation
```
composer require woo/laravel-grid-view "2.*"
``` 

or add into `composer.json`:
```
"woo/laravel-grid-view": "2.*"
```

In case you use Laravel 5.4 or lower, please add 
`Woo\GridView\GridViewServiceProvider::class` into `config/app.php`

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
- **<!> Achtung! No complete backward compatibility with v1. Please update with your own risk! In general, Action column api is totally different now - it was totally rebuild.**

# Our sponsors list:
<a href="https://mobicard.com.ua/"><img src="https://mobicard.com.ua/favicon.svg" width="32"></a> 
<a href="https://busyb.com.ua/"><img src="https://busyb.com.ua/favicon.svg" width="32"></a>
<a href="https://woo.zp.ua/"><img src="https://woo.zp.ua/wp-content/uploads/2024/02/cropped-Woo-192x192.png" width="32"></a>
<a href="https://pc-info.com.ua/"><img src="https://pc-info.com.ua/favicon.svg" width="32"></a>
<a href="https://linktrust.com.ua/"><img src="https://linktrust.com.ua/linktrust.svg" width="32"></a>
