# Getting Started

Once you've completed with installation, you need to do 2 things: 
- Make data provider in your controller: ```$dataProvider = new EloquentDataProvider(Model::query())```
- Use @grid construction in your view:

```blade
@grid([
    'dataProvider' => $provider, // see info about DataProviders
    'rowsPerPage' => 20,
    'columnOptions' => [ // you may specify options common for all columns in your grid
        'class' => 'attribute',
        'formatters' => 'text', 
    ],
    'columns' => [
        'assigned.id', // dots notation is allowed
        'username', // passing a string by default casts to AttributeCollumn
        [
            // class will be copied from GridView's columnOptions property
            'value' => 'avatar',
            'formatters' => ['image'], // formatters are available for all column types.
        ],
        'view:columns.some-dummy-view', // path to blade template
        [
            'value' => 'is_active',
            'filter' => [ // by default, TextFilter is used, but you may override with any other
                'class' => 'dropdown',
                'items' => [
                    'Y' => 'Yes',
                    'N' => 'No',
                ]
            ]
        ],
        [
            'class' => 'callback', // its recommended to use view instead of passing a callback, but still its available
            'value' => function($row) { 
                return $row->status; 
            }
        ],
        [
            'class' => 'actions', // class option allows to change column class
            'value' => [
                'edit:/path/to/{id}', // {id} - will be replaced with an attribute from row
                'view:/path/{id}',
                'delete:/path/to/{id}',
                new \Woo\GridView\Columns\Actions\Action('copy/{id}', '<i class="fa fa-copy"></i>'),
            ]
        ]
    ],
])
```

or

```blade
{!! grid([
    ...
]) !!}
```

In this example, you can see data provider is passed to GridView with some extra configuration.
You can see the whole configuration by <a href="grid-view-configuring">link</a>.

Columns represents a list of rendered columns in the table. By default, sorting is enabled, 
but you may disable it by configuring grid view with an extra option: 
```
'columnOptions' => [
    'class' => 'attribute',
    'sortable' => false, 
]
```

Also, in case you want to disable filters, configure GridView with such option:
```
'showFilters' => false,
```

Column by default is AttributeColumn which renders an attribute from object/array. 
Dots notation (key.subkey) is also available.

In class section you may specify alias (see <a href="aliases">Aliases</a> reference).

