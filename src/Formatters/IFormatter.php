<?php

namespace Woo\GridView\Formatters;

interface IFormatter
{
    public function format($value) : string;
}