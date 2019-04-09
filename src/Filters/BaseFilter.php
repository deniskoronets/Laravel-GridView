<?php

namespace Woo\GridView\Filters;

abstract class BaseFilter
{
    abstract public function render() : string;
}