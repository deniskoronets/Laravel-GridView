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
        $this->query = $query;
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
    public function getData(int $page, int $perPage)
    {
        if ($perPage == 0) {
            return $this->query->get();
        }

        return (clone $this->query)->paginate($perPage, ['*'], 'page', $page);
    }
}