<?php

namespace Woo\GridView\DataProviders;

use Woo\GridView\GridViewRequest;

abstract class BaseDataProvider
{
    /**
     * Should return total amount of rows
     * @param GridViewRequest $request
     * @return int
     */
    abstract public function getCount(GridViewRequest $request) : int;

    /**
     * Should return a list of data for current page
     * @param GridViewRequest $request
     * @return mixed
     */
    abstract public function getData(GridViewRequest $request);
}