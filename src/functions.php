<?php

/**
 * Make a grid instance
 * @param array $config
 * @return string
 * @throws \Woo\GridView\Exceptions\GridViewConfigException
 */
function grid(array $config) {
    return (new \Woo\GridView\GridView($config))->render();
}