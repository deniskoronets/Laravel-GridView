<?php

namespace Woo\GridView\Columns;

use Woo\GridView\Exceptions\GridViewConfigException;
use Woo\GridView\GridViewHelper;
use Woo\GridView\Traits\Configurable;

abstract class BaseColumn
{
    use Configurable;

    /**
     * @var string
     */
    public $title = '';

    /**
     * @var string|mixed
     */
    public $value = '';

    /**
     * @var array
     */
    public $headerHtmlOptions = [];

    /**
     * @var array
     */
    public $contentHtmlOptions = [];

    /**
     * @var string - allowed: raw, url, email, text, image
     */
    public $contentFormat = 'text';

    /**
     * Value when
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
            'contentFormat' => 'string',
            'emptyValue' => 'string',
        ];
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
     * @param array $context
     * @return string
     */
    public function contentHtmlOptions(array $context) : string
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
     * @throws GridViewConfigException
     */
    public function renderValue($row)
    {
        $value = $this->_renderValue($row);

        switch ($this->contentFormat) {
            case 'raw':
                return $value;

            case 'text':
                return htmlentities($value);

            case 'url':
                return '<a href="' . htmlspecialchars($value, ENT_QUOTES) . '">' . htmlentities($value) . '</a>';

            case 'email':
                return '<a href="mailto:' . htmlspecialchars($value, ENT_QUOTES) . '">' . htmlentities($value) . '</a>';

            case 'image':
                return '<img src="' . htmlspecialchars($value, ENT_QUOTES) . '">';

            default:
                throw new GridViewConfigException('Invalid content format for attribute collumn: ' . $this->value);
        }
    }

}