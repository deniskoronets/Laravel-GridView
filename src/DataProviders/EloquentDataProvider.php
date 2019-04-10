<?php

namespace Woo\GridView\DataProviders;

use Illuminate\Database\Eloquent\Builder;

class EloquentDataProvider implements DataProviderInterface
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
    public function getTotalPages(int $perPage): int
    {
        if ($perPage == 0) {
            return 1;
        }

        return ceil($this->getCount() / $perPage);
    }

    /**
     * @inheritdoc
     */
    public function getData(array $filters, string $orderBy, string $orderSort, int $page, int $perPage)
    {
        foreach ($filters as $field => $value) {
            $this->query->where($field, 'LIKE', '%' . $value . '%');
        }

        if ($orderBy) {
            $this->query->orderBy($orderBy, $orderSort);
        }

        if ($perPage == 0) {
            return $this->query->get();
        }

        return $this->query->offset(($page - 1) * $perPage)->limit($perPage)->get();
    }
}