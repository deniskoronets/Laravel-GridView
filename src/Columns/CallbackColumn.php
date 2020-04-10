<?php

namespace Woo\GridView\Columns;

class CallbackColumn extends BaseColumn
{
    /**
     * @var string
     */
    public $formatters = ['raw'];

    /**
     * @var bool
     */
    public $sortable = false;

    /**
     * @return array
     */
    protected function configTests(): array
    {
        return array_merge(parent::configTests(), [
            'value' => 'closure',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function _renderValue($row)
    {
        return call_user_func($this->value, $row);
    }
}