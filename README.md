# Laravel-GridView

[![Code Climate](https://codeclimate.com/github/deniskoronets/Laravel-GridView/badges/gpa.svg)](https://codeclimate.com/github/deniskoronets/Laravel-GridView) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/09b254fbd7ab42379daf9e428fbc4be5)](https://www.codacy.com/app/deniskoronets/Laravel-GridView?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=deniskoronets/Laravel-GridView&amp;utm_campaign=Badge_Grade) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/badges/build.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/build-status/master)

This package is analog for yii's gridview component.
Implemented for laravel, it provides a simple interface to print data in table view.

https://packagist.org/packages/woo/laravel-grid-view

## Installation
Simply run `composer require woo/laravel-grid-view`
or add to your composer.json: `"woo/laravel-grid-view": "@dev"` and run composer update.

After that, add `Woo\GridView\GridViewServiceProvider::class,` into `config/app.php`, providers section.

## Usage
GridView requires data to be passed through DataProvider wrapper. You can use eloquent queries, wrapped with eloquent data provider in your controller:

```php
use \Woo\GridView\DataProviders\EloquentDataProvider;

return view('users.index', [
    'dataProvider' => new EloquentDataProvider(User::query())
]);
```

sample usage in a view file:
```blade
{!! grid([
    'dataProvider' => $dataProvider,
    'rowsPerPage' => 20,
    'columns' => [
        'id',
        'email',
        'address',
        'phone',
        [
            'class' => 'raw',
            'title' => 'Status',
            'contentHtmlOptions' => [
                'data-id' => function($model) {
                    return $model->id;
                }
            ],
            'value' => function($model) {

                if ($model->status == 'rejected') {
                    return '<b color="red">' . $model->status . '</b>';
                }

                return '<b>' . $model->status . '</b>';
            }
        ],
        [
            'class' => 'actions',
            'value' => '{show} {update}',
            'actionsUrls' => function($model) {
                return [
                    'show' => url('users/' . $model->id),
                    'update' => url('users/' . $model->id . '/update'),
                ];
            }
        ]
    ]
])->render() !!}
```

## Documentation

<p>A list if GridView object options:</p>

| Property          | Description                                                           |
| ----------------- | --------------------------------------------------------------------- |
| dataProvider      | Should be an object, implement DataProviderInterface                  |
| columns           | A list of columns. In compiling, columns are                          |
| columnOptions     | A list of basic options for all collumns                              |
| renderer          | Should be a class path. Could be used in order to override renderer   |
| rendererOptions   | A list of options for renderer                                        |
| rowsPerPage       | Amount of rows to be shown per page (0 for table without pagination)  |
| tableHtmlOptions  | Allows to set options for table element                               |

<p>A list of Column options:</p>

| Property              | Description                                                             |
| --------------------- | ----------------------------------------------------------------------- |
| class                 | Could be used in order to override type of column (aliases allowed)     |
| title                 | Allows to set column title                                              |
| value                 | Depends on column class, could be string or Closure                     |
| headerHtmlOptions     | A list of html options for `table thead th`                             |
| contentHtmlOptions    | A list of options for `table tbody td`                                  |
| contentFormat         | Post-processing for value. Could be: raw, text, url, email, image (url) |

<p>A list of Renderer options:</p>

| Property              | Description                                                             |
| --------------------- | ----------------------------------------------------------------------- |
| id                    | Id of container element                                                 |

*Available columns classes:*
- ActionsColumn
- AttributeColumn
- RawColumn

*Available rendereds:*
- DefaultRenderer

*Available data providers:*
- EloquentDataProvider
- ArrayDataProvider

*Available class aliases:*

| Alias       | Context       | Real class                                                              |
| ----------- | ------------- | ----------------------------------------------------------------------- |
| attribute   | column        | Woo\GridView\Columns\AttributeColumn                                    |
| raw         | column        | Woo\GridView\Columns\RawColumn                                          |
| actions     | column        | Woo\GridView\Columns\ActionsColumn                                      |
| default     | renderer      | Woo\GridView\Renderers\DefaultRenderer                                  |

## Update log

### v1.2
- Added ArrayDataProvider

### v.1.1
- Added suppport for infinite tables (no per page limit)

### dev -> v.1.0
- Added GridView $columnOptions to make able setting basic properties for all columns
- Added GridView $rendererOptions, renderer options support (currently only wrapper element ID could be set)
- Added dynamic htmlOption calculation, just set value to id
- Added aliases support - instead of passing real class value, just pass alias
