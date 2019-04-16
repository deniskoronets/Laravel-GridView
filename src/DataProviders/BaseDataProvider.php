<?php

namespace Woo\GridView\DataProviders;

abstract class BaseDataProvider
{
    /**
     * Should return total amount of rows
     * @return int
     */
    abstract public function getCount() : int;

    /**
     * Should return a list of data for current page
     * @param array $filters
     * @param string $orderBy
     * @param string $orderSort
     * @param int $page
     * @param int $perPage - amount of records per page
     * @return mixed
     */
    abstract public function getData(array $filters, string $orderBy, string $orderSort, int $page, int $perPage);

    /**
     * Allows to get amount of found pages
     */
    public function getTotalPages(int $perPage): int
    {
        if ($perPage == 0) {
            return 1;
        }

        return ceil($this->getCount() / $perPage);
    }

}