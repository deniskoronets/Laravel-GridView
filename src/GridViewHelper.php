<?php

namespace Woo\GridView;

use Illuminate\Support\Arr;
use Woo\GridView\Columns\Actions\Action;
use Woo\GridView\Columns\Actions\DeleteAction;
use Woo\GridView\Columns\Actions\EditAction;
use Woo\GridView\Columns\Actions\ShowAction;
use Woo\GridView\Columns\ActionsColumn;
use Woo\GridView\Columns\AttributeColumn;
use Woo\GridView\Columns\BladeColumn;
use Woo\GridView\Columns\CallbackColumn;
use Woo\GridView\Columns\ViewColumn;
use Woo\GridView\Filters\DropdownFilter;
use Woo\GridView\Filters\TextFilter;
use Woo\GridView\Formatters\EmailFormatter;
use Woo\GridView\Formatters\ImageFormatter;
use Woo\GridView\Formatters\RawFormatter;
use Woo\GridView\Formatters\TextFormatter;
use Woo\GridView\Formatters\UrlFormatter;
use Woo\GridView\Formatters\CurrencyFormatter;
use Woo\GridView\Formatters\NumberFormatter;
use Woo\GridView\Renderers\DefaultRenderer;

class GridViewHelper
{
    /**
     * A list of grid aliases
     * @var array
     */
    private static $aliases = [
        'column' => [
            'attribute' => AttributeColumn::class,
            'raw' => CallbackColumn::class,
            'callback' => CallbackColumn::class,
            'actions' => ActionsColumn::class,
            'view' => ViewColumn::class,
        ],
        'formatter' => [
            'email' => EmailFormatter::class,
            'image' => ImageFormatter::class,
            'text' => TextFormatter::class,
            'url' => UrlFormatter::class,
            'raw' => RawFormatter::class,
            'currency' => CurrencyFormatter::class,
            'number' => NumberFormatter::class,
        ],
        'filter' => [
            'text' => TextFilter::class,
            'dropdown' => DropdownFilter::class,
        ],
        'renderer' => [
            'default' => DefaultRenderer::class,
        ],
        'action' => [
            'delete' => DeleteAction::class,
            'update' => EditAction::class,
            'edit' => EditAction::class,
            'show' => ShowAction::class,
            'view' => ShowAction::class,
            'action' => Action::class,
        ]
    ];

    private function __construct() {}

    /**
     * Useful in case you want to register a new alias for your project
     * @param string $context
     * @param string $alias
     * @param string $aliasTo
     */
    public static function registerAlias(string $context, string $alias, string $aliasTo)
    {
        self::$aliases[$context][$alias] = $aliasTo;
    }

    /**
     * Allows to resolve class name by its alias
     * @param string $context
     * @param string $alias
     * @return mixed
     */
    public static function resolveAlias(string $context, string $alias)
    {
        return self::$aliases[$context][$alias] ?? $alias;
    }

    /**
     * Allows to convert options array to html string
     * @param array $htmlOptions
     * @param array $context - context is variables, which are allowed to use when property value calculated dynamically
     * @return string
     */
    public static function htmlOptionsToString(array $htmlOptions, array $context = []) : string
    {
        if (empty($htmlOptions)) {
            return '';
        }

        $out = [];

        foreach ($htmlOptions as $k => $v) {

            if ($v instanceof \Closure) {
                $v = call_user_func_array($v, $context);
            }

            $out[] = htmlentities($k) . '="' . htmlentities($v, ENT_COMPAT) . '"';
        }

        return implode(' ', $out);
    }

    /**
     * Allows to make column title by it key or attribute name
     * @param string|int $key
     * @return string
     */
    public static function columnTitle($key) : string
    {
        if (is_numeric($key)) {
            return 'Column';
        }

        return ucwords(
            trim(
                preg_replace_callback(
                    '/([A-Z]|_|\.)/',
                    function($word) {
                        $word = $word[0];

                        if ($word == '_' || $word == '.') {
                            return ' ';
                        }

                        return ' ' . strtolower($word);
                    },
                    $key
                )
            )
        );
    }

    /**
     * Helper for internal purposes
     * @param $id
     * @param $component
     * @return string
     */
    public static function gridIdFormatter($id, $component)
    {
        if ($id == 0) {
            return $component;
        }

        return 'grid[' . $id . '][' . $component . ']';
    }

    /**
     * Generates page url with all requested params from request
     * @param $gridId
     * @param $page
     */
    public static function pageUrl($gridId, $page)
    {
        return url()->current() . '?' . Arr::query([\Woo\GridView\GridViewHelper::gridIdFormatter($gridId, 'page') => $page] + request()->query());
    }
}
