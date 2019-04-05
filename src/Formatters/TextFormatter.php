<?php

namespace Woo\GridView\Formatters;

class TextFormatter implements IFormatter
{
    public function format($value): string
    {
        return htmlentities($value);
    }
}