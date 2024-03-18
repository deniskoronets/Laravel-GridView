# Laravel GridView Formatters

Formatters allows to format column's rendered value. It applies AFTER rendering which means that you can apply it to any class of column.

```php
[
    // grid config
    'columns' => [
        [
            'title' => 'Simple column',
            'value' => 'user_email',
            'formatters' => ['email'],
        ]
    ],
];
```

A list of current formatters:
- raw - simply renders html as html
- email - formats as clickable email address (not compatible with `text` formatter)
- image - formats as image (not compatible with `text` formatter)
- text (sanitize html and renders safe text)
- url - formats as clickable url (not compatible with `text` formatter)
- boolean - formats value as boolean (replaces true to "Yes", false to "No")
- currency - formats value as currency (1,000.00 as ex)
