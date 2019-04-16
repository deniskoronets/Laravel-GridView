<?php

namespace Woo\GridView\Formatters;

class UrlFormatter implements IFormatter
{
    public function format($value): string
    {
        return '<a href="' . htmlspecialchars($value, ENT_QUOTES) . '">' . htmlentities($value) . '</a>';
    }
}