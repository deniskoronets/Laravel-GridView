# Getting Started

Once you've completed with installation, you need to do 2 things: 
- Make data provider in your controller: ```$dataProvider = new EloquentDataProvider(Model::query())```
- Use @grid construction in your view:

```blade
@grid([
    'dataProvider' => $provider,
    'columns' => [
        'Host',
        'User',
        [
            'value' => 'Execute_priv',
            'filter' => [
                'class' => 'dropdown',
                'items' => [
                    'Y' => 'Yes',
                    'N' => 'No',
                ]
            ]
        ],
        [
            'class' => 'actions',
            'value' => [
                'edit:/path/to/{Host}',
                'view:/path/{Host}',
                'delete:/path/to/{Host}',
            ]
        ]
    ],
])
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

