<?php

namespace Woo\GridView\Columns;

use Woo\GridView\Filters\BaseFilter;
use Woo\GridView\Filters\TextFilter;
use Woo\GridView\GridViewHelper;
use Woo\GridView\Traits\Configurable;

abstract class BaseColumn
{
    use Configurable;

    /**
     * Column title
     * @var string
     */
    public $title = '';

    /**
     * Column value. Could be an attribute,
     * @var string|mixed
     */
    public $value = '';

    /**
     * @var BaseFilter
     */
    public $filter;

    /**
     * @var array
     */
    public $headerHtmlOptions = [];

    /**
     * @var array
     */
    public $contentHtmlOptions = [];

    /**
     * @var array - allowed: raw, url, email, text, image
     */
    public $formatters = [];

    /**
     * Value when column is empty
     * @var string
     */
    public $emptyValue = '-';

    /**
     * BaseColumn constructor.
     * @param array $config
     * @throws \Woo\GridView\Exceptions\GridViewConfigException
     */
    public function __construct(array $config)
    {
        $this->loadConfig($config);

        $this->buildFilter();
    }

    protected function buildFilter()
    {
        if (is_null($this->filter) || is_object($this->filter)) {
            return;
        }

        if (is_string($this->filter)) {
            $this->filter = [
                'class' => $this->filter,
                'name' => $this->value,
            ];
        }

        if (empty($this->filter['class'])) {
            $this->filter['class'] = TextFilter::class;
        }

        if (empty($this->filter['name'])) {
            $this->filter['name'] = $this->value;
        }

        $className = GridViewHelper::resolveAlias('filter', $this->filter['class']);
        $this->filter = new $className($this->filter);
    }

    /**
     * @return array
     */
    protected function configTests(): array
    {
        return [
            'title' => 'string',
            'value' => 'any',
            'headerHtmlOptions' => 'array',
            'contentHtmlOptions' => 'array',
            'formatters' => 'array',
            'emptyValue' => 'string',
            'filter' => BaseFilter::class . '|null',
        ];
    }

    /**
     * Formatted header html options
     * @return string
     */
    public function compileHeaderHtmlOptions() : string
    {
        return GridViewHelper::htmlOptionsToString($this->headerHtmlOptions);
    }

    /**
     * Formatted content html options
     * @param array $context
     * @return string
     */
    public function compileContentHtmlOptions(array $context) : string
    {
        return GridViewHelper::htmlOptionsToString($this->contentHtmlOptions, $context);
    }

    /**
     * Render column value for row
     * @param array|object $row
     * @return string|mixed
     */
    protected abstract function _renderValue($row);

    /**
     * Renders column content
     * @param $row
     * @return string
     */
    public function renderValue($row)
    {
        $value = $this->_renderValue($row);

        foreach ($this->formatters as $formatter) {
            $className = GridViewHelper::resolveAlias('formatter', $formatter);
            $value = (new $className)->format($value);
        }

        return $value;
    }

}