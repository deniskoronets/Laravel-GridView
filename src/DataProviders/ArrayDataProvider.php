<?php

namespace Woo\GridView\DataProviders;

use Woo\GridView\GridViewRequest;

class ArrayDataProvider extends BaseDataProvider
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param GridViewRequest $request
     * @return array
     */
    protected function processData(GridViewRequest $request) : array
    {
        if (empty($this->data)) {
            return [];
        }

        $tmp = collect($this->data);

        if (!empty($request->filters)) {
            $tmp = $tmp->filter(function($item) use ($request) {
                foreach ($request->filters as $filterKey => $filterValue) {

                    if (!isset($item[$filterKey])) {
                        return false;
                    }

                    if (strpos($item[$filterKey], $filterValue) === false) {
                        return false;
                    }
                }

                return true;
            });
        }

        if (!empty($request->sortColumn)) {
            $tmp = $tmp->sortBy(
                $request->sortColumn,
                SORT_REGULAR,
                $request->sortOrder == 'DESC'
            );
        }

        return $tmp->values()->all();
    }

    /**
     * @inheritdoc
     */
    public function getCount(GridViewRequest $request) : int
    {
        return count($this->processData($request));
    }

    /**
     * @inheritdoc
     */
    public function getData(GridViewRequest $request)
    {
        $tmp = $this->processData($request);

        return array_splice(
            $tmp,
            ($request->page -1) * $request->perPage, $request->perPage
        );
    }
}