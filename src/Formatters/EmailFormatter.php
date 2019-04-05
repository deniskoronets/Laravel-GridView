<?php

namespace Woo\GridView\Formatters;

class EmailFormatter implements IFormatter
{
    public function format($value): string
    {
        return '<a href="mailto:' . htmlspecialchars($value, ENT_QUOTES) . '">' . htmlentities($value) . '</a>';
    }
}