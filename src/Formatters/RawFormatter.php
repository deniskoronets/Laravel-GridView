<?php

namespace Woo\GridView\Formatters;

class RawFormatter implements IFormatter
{
    public function format($value): string
    {
        return $value;
    }
}