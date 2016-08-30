# Laravel-GridView

[![Code Climate](https://codeclimate.com/github/deniskoronets/Laravel-GridView/badges/gpa.svg)](https://codeclimate.com/github/deniskoronets/Laravel-GridView) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/09b254fbd7ab42379daf9e428fbc4be5)](https://www.codacy.com/app/deniskoronets/Laravel-GridView?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=deniskoronets/Laravel-GridView&amp;utm_campaign=Badge_Grade)

This package is analog for yii's gridview component.
Implemented for laravel, it provides a simple interface to print data in table view.

install:
`composer require woo/laravel-grid-view`

usage in your view:
```
{{ Woo\GridView\View::make([
    'dataProvider' => Users::all(),
    'columns' => [
      'username',
      'email',
      [
        'label' => 'Comments',
        'value' => function ($model) {
          return '<b>' . $model->comments->count() . '</b>';
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
]) }}
```
