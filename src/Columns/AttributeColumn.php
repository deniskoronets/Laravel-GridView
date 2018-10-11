<?php

namespace Woo\GridView\Columns;

use Woo\GridView\Exceptions\ColumnRenderException;

class AttributeColumn extends BaseColumn
{
    public function __construct($config)
    {
        if (is_string($config)) {
            $this->title = ucfirst(str_replace('_', ' ', $config));
            $this->value = $config;
        }

        parent::__construct([]);
    }

    /**
     * @inheritdoc
     * @throws ColumnRenderException
     */
    public function renderValue($row)
    {
        if (is_array($row)) {

            if (!isset($row[$this->value])) {
                return null;
            }

            return $row[$this->value];
        }

        if (!isset($row->{$this->value})) {
            return null;
        }

        return $row->{$this->value};
    }
}