<?php

namespace Woo\GridView\Formatters;

class BooleanFormatter implements IFormatter
{
    public function format($value): string
    {
        return $value ? 'Yes' : 'No';
    }
}