<?php

namespace Woo\GridView\Columns;

use Woo\GridView\Exceptions\ColumnRenderException;
use Woo\GridView\Exceptions\GridViewConfigException;

class AttributeColumn extends BaseColumn
{
    /**
     * @var string - allowed: url, email, text, image
     */
    public $contentFormat = 'text';

    public function __construct($config)
    {
        if (is_string($config)) {
            $config = [
                'value' => $config,
            ];
        }

        parent::__construct($config);

        if (empty($this->title)) {
            $this->title = ucfirst(str_replace('_', ' ', $this->value));
        }
    }

    /**
     * @inheritdoc
     * @throws ColumnRenderException
     * @throws GridViewConfigException
     */
    public function renderValue($row)
    {
        $value = '';

        if (is_array($row)) {

            if (isset($row[$this->value])) {
                $value = $row[$this->value];
            }
        } elseif (isset($row->{$this->value})) {
            $value = $row->{$this->value};
        }

        switch ($this->contentFormat) {
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