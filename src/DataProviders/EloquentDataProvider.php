<?php

namespace Woo\GridView\DataProviders;

use Illuminate\Database\Eloquent\Builder;

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
     * @inheritdoc
     */
    public function getCount(): int
    {
        return $this->query->count();
    }

    /**
     * @inheritdoc
     */
    public function getData(array $filters, string $orderBy, string $orderSort, int $page, int $perPage)
    {
        $query = clone $this->query;

        foreach ($filters as $field => $value) {
            $query->where($field, 'LIKE', '%' . $value . '%');
        }

        if ($orderBy) {
            $query->orderBy($orderBy, $orderSort);
        }

        if ($perPage == 0) {
            return $query->get();
        }

        return $query->offset(($page - 1) * $perPage)->limit($perPage)->get();
    }
}