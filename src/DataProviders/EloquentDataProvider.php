<?php

namespace Woo\GridView\DataProviders;

use Illuminate\Database\Eloquent\Builder;
use Woo\GridView\GridViewRequest;

class EloquentDataProvider extends BaseDataProvider
{
    protected $query;

    /**
     * EloquentDataProvider constructor.
     * @param Builder $query
     */
    public function __construct(Builder $query)
    {
        $this->query = clone $query;
    }


    /**
     * @param GridViewRequest $request
     * @return Builder
     */
    protected function baseQuery(GridViewRequest $request)
    {
        $query = clone $this->query;

        foreach ($request->filters as $field => $value) {
            $query->where($field, 'LIKE', '%' . $value . '%');
        }

        if ($request->sortColumn) {
            $query->orderBy($request->sortColumn, $request->sortOrder);
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function getCount(GridViewRequest $request) : int
    {
        return $this->baseQuery($request)->count();
    }

    /**
     * @inheritdoc
     */
    public function getData(GridViewRequest $request)
    {
        $query = $this->baseQuery($request);

        if ($request->perPage == 0) {
            return $query->get();
        }

        return $query->offset(($request->page - 1) * $request->perPage)
            ->limit($request->perPage)
            ->get();
    }
}
