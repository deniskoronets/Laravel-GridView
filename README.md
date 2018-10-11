# Laravel-GridView

[![Code Climate](https://codeclimate.com/github/deniskoronets/Laravel-GridView/badges/gpa.svg)](https://codeclimate.com/github/deniskoronets/Laravel-GridView) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/09b254fbd7ab42379daf9e428fbc4be5)](https://www.codacy.com/app/deniskoronets/Laravel-GridView?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=deniskoronets/Laravel-GridView&amp;utm_campaign=Badge_Grade) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/badges/build.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/build-status/master)

 Please notice that this package is still in development (v1.0)

This package is analog for yii's gridview component.
Implemented for laravel, it provides a simple interface to print data in table view.

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
            'class' => \Woo\GridView\Columns\RawColumn::class,
            'title' => 'Status',
            'value' => function($model) {
                
                if ($model->status == 'rejected') {
                    return '<b color="red">' . $model->status . '</b>';
                }
            
                return '<b>' . $model->status . '</b>';
            }
        ],
        [
            'class' => \Woo\GridView\Columns\ActionsColumn::class,
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

| Property          | Description                                           |
| dataProvider      | Should be an object, implement DataProviderInterface  |
| columns           | A list of columns. In compiling, columns are          |
| columnClass       | Default column-renderer class (if column's class is not specified) |
| renderer          | Should be a class path. Could be used in order to override renderer |
| rowsPerPage       | Amount of rows to be shown per page                   |
| tableHtmlOptions  | Allows to set options for table element               |

<p>A list of Column options:</p>

| Property              | Description                                           |
| class                 | Could be used in order to override type of column     |
| title                 | Allows to set column title                            |
| value                 | Depends on column class, could be string or Closure   |
| headerHtmlOptions     | A list of html options for `table thead th`           |
| contentHtmlOptions    | A list of options for `table tbody td`                |

*Available columns classes:*
- ActionsColumn
- AttributeColumn
- RawColumn 

*Available rendereds:*
- DefaultRenderer