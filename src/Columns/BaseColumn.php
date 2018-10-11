<?php

namespace Woo\GridView\Columns;

use Woo\GridView\GridViewHelper;

abstract class BaseColumn
{
    public $title = '';

    public $value = '';

    public $headerHtmlOptions = [];

    public $contentHtmlOptions = [];

    public function __construct(array $config)
    {
        GridViewHelper::loadConfig($this, $config);

        GridViewHelper::testConfig($this, [
            'title' => 'string',
            'value' => 'any',
            'headerHtmlOptions' => 'array',
            'contentHtmlOptions' => 'array',
        ]);
    }

    /**
     * Formatted header html options
     * @return string
     */
    public function headerHtmlOptions() : string
    {
        return GridViewHelper::htmlOptionsToString($this->headerHtmlOptions);
    }

    /**
     * Formatted content html options
     * @return string
     */
    public function contentHtmlOptions() : string
    {
        return GridViewHelper::htmlOptionsToString($this->contentHtmlOptions);
    }

    /**
     * Render column value for row
     * @param array|object $row
     * @return string|mixed
     */
    public abstract function renderValue($row);
}