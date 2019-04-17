# Columns

Columns are the basic item of GridView. You may set column by a bunch of ways:

- `attribute_name` - you may specify column as string with column name, AttributeColumn will be picked as column class.
- `view:pah.to.view` - you may pick view by prefix `view:`, in this case each column will be rendered from view. Variables-attributes of data row are available inside it.
- `[...config...]` - for better tuning, you configuring options for each config. See available options below.

## Available column options
| Option            | Type                      | Description                             |
| ----------------- | ------------------------- | --------------------------------------- |
| title             | string                    | Column title (in thead)                 |
| value             | mixed                     | Value is column-type-specific, please dig into particular column class for reference |
| filter            | BaseFilter,null,[],string | Either configuration array, null or string with filter alias/class are valid |
| sortable          | bool                      | Mark column as sortable (works mainly for attribute column) |
| headerHtmlOptions | []                        | A (k => v) list of options for `th`. Closure is valid as a value |
| contentHtmlOptions| []                        | A (k => v) list of options for `td`, Closure is valid with a single argument (current row) |
| formatters        | []                        | A list of formatters to apply to current column (applied sequently) |
| emptyValue        | string                    | Value which replaces empty column values |

