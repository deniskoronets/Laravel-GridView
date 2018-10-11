<?php

/**
 * Make a grid instance
 * @param array $config
 * @return \Woo\GridView\GridView
 */
function grid(array $config) {
    return \Woo\GridView\GridView::make($config);
}