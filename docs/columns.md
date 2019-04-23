# Columns

Columns are the basic item of GridView. You may set column by a bunch of ways:

- `attribute_name` - you may specify column as string with column name, AttributeColumn will be picked as column class.
- `view:pah.to.view` - you may pick view by prefix `view:`, in this case each column will be rendered from view. Variables-attributes of data row are available inside it.
- `[...config...]` - for better tuning, you configuring options for each config. See available options below.

## Available column options

| Option            | Type                      | Description                             |
| ----------------- | ------------------------- | --------------------------------------- |
| class             | string                    | Class or alias |
| title             | string                    | Column title (in thead)                 |
| value             | mixed                     | Value is column-type-specific, please dig into particular column class for reference |
| filter            | BaseFilter,null,[],string | Either configuration array, null or string with filter alias/class are valid |
| sortable          | bool                      | Mark column as sortable (works mainly for attribute column) |
| headerHtmlOptions | []                        | A (k => v) list of options for `th`. Closure is valid as a value |
| contentHtmlOptions| []                        | A (k => v) list of options for `td`, Closure is valid with a single argument (current row) |
| formatters        | []                        | A list of formatters to apply to current column (applied sequently) |
| emptyValue        | string                    | Value which replaces empty column values |


## Columns
Here is a list of available columns for usage:
- ActionsColumn (alias: `actions`)
- AttributeColumn (is used by default, alias: `attribute`)
- CallbackColumn (alias: `callback`)
- ViewColumn (alias: `view`)

In case of `CallbackColumn` usage, instead of value pass `\Closure` 
which has a single argument - `$model` or `$row` to get access to current item.

In case of `AttributeColumn`, you may specify string value which'll be column name 
(you are allowed to use dot notation: `attr.sub.sub2`)

`ViewColumn` could render content from blade view. 
Simply describe column as a string with `view:[path]` and it'll be parsed as view column.

## Action column

This column allows you to build actions list for each entity. 
Here is a sample of action column:
```php
[
    'class' => 'actions',
    'value' => [
        'edit:/path/to/{Host}',
        'view:/path/{Host}',
        'delete:/path/to/{Host}',
        new \Woo\GridView\Columns\Actions\Action('copy/{Host}', '<i class="fa fa-copy"></i>'),
    ]
]
```

Action could be described both as string with a mask: `[alias]:[url]`, or as an object by passing an instance which extends `Action` class.
Additionally you can use any attribute from current row in brackets, for ex `{Host}` - this will be replaced with `$row->Host`. 
For more reference about actions, please review <a href="https://github.com/deniskoronets/Laravel-GridView/tree/master/src/Columns/Actions">Actions list</a>.
