<?php

namespace Woo\GridView\Formatters;

class CurrencyFormatter implements IFormatter
{
    public function format($value): string
    {
        return number_format($value, 2);
    }
}
