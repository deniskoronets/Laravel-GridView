<?php

namespace Woo\GridView;

use Woo\GridView\Columns\ActionsColumn;
use Woo\GridView\Columns\AttributeColumn;
use Woo\GridView\Columns\RawColumn;
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
            'raw' => RawColumn::class,
            'actions' => ActionsColumn::class,
        ],
        'renderer' => [
            'default' => DefaultRenderer::class,
        ]
    ];

    private function __construct() {}

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
}