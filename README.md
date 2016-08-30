# Laravel-GridView

This package is analog for yii's gridview component.
Implemented for laravel, it provides a simple interface to print data in table view.

install:
` composer require woo/laravel-grid-view

usage in your view:
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
