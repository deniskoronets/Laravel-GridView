<?php

namespace Woo\GridView\Columns;

use Woo\GridView\GridViewHelper;

class RawColumn extends BaseColumn
{
    /**
     * RawColumn constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        GridViewHelper::testConfig($this, [
            'value' => 'closure',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function renderValue($row)
    {
        return call_user_func($this->value, $row);
    }
}