<?php

namespace Woo\GridView\Formatters;

class ImageFormatter implements IFormatter
{
    public function format($value): string
    {
        return '<img src="' . htmlspecialchars($value, ENT_QUOTES) . '">';
    }
}