<?php

namespace Woo\GridView\DataProviders;

use Illuminate\Database\Eloquent\Builder;
use Woo\GridView\Exceptions\GridViewConfigException;
use Woo\GridView\GridViewRequest;
use Illuminate\Support\Facades\Schema;

class EloquentDataProvider extends BaseDataProvider
{
    protected $filters = true;
    protected $ordering = true;

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
     * Applies filter to a column
     * @param \Closure| $filter
     * @param string $fieldName
     * @param Builder $query
     * @param mixed $value
     * @return void
     */
    private function applyFilter($filter, string $fieldName, Builder $query, $value)
    {
        if (is_callable($filter)) {
           $filter($query, $value);
           return;
        }

        switch ($filter) {
            case '=':
                $query->where($fieldName, '=', $value);
                break;

            case 'like':
                $query->where($fieldName, 'LIKE', '%' . $value . '%');
                break;

            default:
                throw new GridViewConfigException('Unknown filter type: ' . $filter);
        }
    }

    /**
     * @param GridViewRequest $request
     * @return Builder
     */
    protected function baseQuery(GridViewRequest $request)
    {
        $query = clone $this->query;

        if ($this->filters !== false) {
            foreach ($request->filters as $field => $value) {
                if ($this->filters === true || in_array($field, $this->filters)) {
                    // Check if the $field is a real column in the table
                    if (Schema::hasColumn($query->from, $field)) {
                        // $field exists in the table, apply a WHERE clause
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    } else {
                        // $field does not exist in the table, it must be an alias, apply a HAVING clause
                        $query->having($field, 'LIKE', '%' . $value . '%');
                    }
                } elseif (!empty($this->filters[$field])) {
                    $this->applyFilter($this->filters[$field], $field, $query, $value);
                }
            }
        }

        if ($request->sortColumn && ($this->ordering === true || in_array($request->sortColumn, $this->ordering))) {
            $query->reorder($request->sortColumn, $request->sortOrder);
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function getCount(GridViewRequest $request) : int
    {
        $query = $this->baseQuery($request);
        $query->reorder(null);

        return $query->count();
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
