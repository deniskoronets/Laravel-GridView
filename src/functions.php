<?php

/**
 * Make a grid instance
 * @param array $config
 * @return \Woo\GridView\GridView
 * @throws \Woo\GridView\Exceptions\GridViewConfigException
 */
function grid(array $config) {
    return new \Woo\GridView\GridView($config);
}