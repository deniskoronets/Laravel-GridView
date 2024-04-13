<?php

namespace Woo\GridView\Formatters;

class NumberFormatter implements IFormatter
{
    public function format($value): string
    {
        return number_format($value);
    }
}
