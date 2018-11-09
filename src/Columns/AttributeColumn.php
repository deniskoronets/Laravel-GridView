<?php

namespace Woo\GridView\Columns;

use Woo\GridView\Exceptions\ColumnRenderException;
use Woo\GridView\Exceptions\GridViewConfigException;

class AttributeColumn extends BaseColumn
{
    /**
     * AttributeColumn constructor.
     * @param $config
     * @throws GridViewConfigException
     */
    public function __construct($config)
    {
        parent::__construct($config);

        if (empty($this->title)) {
            $this->title = ucfirst(str_replace('_', ' ', $this->value));
        }
    }

    /**
     * @return array
     */
    protected function configTests(): array
    {
        return array_merge(parent::configTests(), [
            'value' => 'string',
        ]);
    }

    /**
     * @inheritdoc
     * @throws ColumnRenderException
     * @throws GridViewConfigException
     */
    public function _renderValue($row)
    {
        if (is_array($row)) {

            if (isset($row[$this->value]) && $row[$this->value] !== null) {
                return $row[$this->value];
            }

        } elseif (isset($row->{$this->value}) && $row->{$this->value} !== null) {
            return $row->{$this->value};
        }

        return $this->emptyValue;
    }
}