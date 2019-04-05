<?php

namespace Woo\GridView\Columns;

use Woo\GridView\Exceptions\ColumnRenderException;
use Woo\GridView\Exceptions\GridViewConfigException;
use Woo\GridView\GridViewHelper;

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
            $this->title = GridViewHelper::columnTitle($this->value);
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
     */
    public function _renderValue($row)
    {
        $path = $row;
        $exp = explode('.', $this->value);

        /**
         * Extract dots notation (column.sub.sub)
         */
        foreach ($exp as $part) {
            if (isset($path[$part])) {
                $path = $path[$part];

            } elseif (isset($path->$part)) {
                $path = $path[$part];
            }

            return $this->emptyValue;
        }

        return $path;
    }
}