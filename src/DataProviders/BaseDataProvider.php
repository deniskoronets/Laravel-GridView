<?php

namespace Woo\GridView\DataProviders;

use Woo\GridView\GridViewRequest;

abstract class BaseDataProvider
{
    /**
     * true means that all request filters are accepted, checks by default comparing (like)
     * false means that filtering is not enabled in this dataprovider
     * array should contain array of fields, available for filtering.
     *      if key not specified, value should be a name of field, otherwise key - field name,
     *      value - comparing type (=, like) or a callable function
     * @var bool|array
     */
    protected $filters = false;

    /**
     * true means that all request sortings are accepted, checks by default sorting
     * false means that ordering is not enabled in this dataprovider
     * array should contain array of fields, available for filtering.
     *      value should be a string
     * @var bool|array
     */
    protected $ordering = false;

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

    /**
     * Allows to set a list of fields, available for filtering
     * @param array|boolean $filters
     * @return $this
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Allows to set a list of ordering fields
     * @param array|boolean $ordering
     * @return $this
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;
        return $this;
    }
}
