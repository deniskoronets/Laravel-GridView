<?php

use Woo\GridView\Exceptions\GridViewConfigException;
use Woo\GridView\GridView;

/**
 * Make a grid instance
 *
 * @param array $config
 *
 * @return string
 * @throws GridViewConfigException
 */
function grid(array $config): string
{
    return (new GridView($config))->render();
}