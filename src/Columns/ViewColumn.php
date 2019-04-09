<?php

namespace Woo\GridView\Columns;

use Illuminate\View\Factory;

class ViewColumn extends BaseColumn
{
    public $formatters = [];

    /**
     * Render column value for row
     * @param array|object $row
     * @return string|mixed
     * @throws \Throwable
     */
    protected function _renderValue($row)
    {
        return view($this->value, $row)->render();
    }
}