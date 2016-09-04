# Laravel-GridView

[![Code Climate](https://codeclimate.com/github/deniskoronets/Laravel-GridView/badges/gpa.svg)](https://codeclimate.com/github/deniskoronets/Laravel-GridView) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/09b254fbd7ab42379daf9e428fbc4be5)](https://www.codacy.com/app/deniskoronets/Laravel-GridView?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=deniskoronets/Laravel-GridView&amp;utm_campaign=Badge_Grade) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/badges/build.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/Laravel-GridView/build-status/master)

 Please notice that this package is still in development (v1.0)

This package is analog for yii's gridview component.
Implemented for laravel, it provides a simple interface to print data in table view.

install:
`composer require woo/laravel-grid-view`

usage in your view:
```
{!! \Woo\GridView\View::make([
    'dataProvider' => \App\User::getQuery(),
    'columns' => [
      'name',
      'email',
      [
        'label' => 'Callback value',
        'value' => function ($model) {
          return '<b>' . $model->email . '</b>';
        },
        'type' => 'html',
      ],
      new Woo\GridView\Actions(function ($model) {
        return [
          'update' => route('users/' . $model->id . '/update'),
          'delete' => route('users/' . $model->id . '/delete'),
          'view' => route('users/' . $model->id . '/view'),
        ];
      }),
    ],
]) !!}
```

# Features
- easy theme customizing
- ability to add filters, sorting and pagination
- flexible 
