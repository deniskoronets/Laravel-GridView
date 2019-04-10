<?php

namespace Woo\GridView\DataProviders;

class ArrayDataProvider implements DataProviderInterface
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
     * Should return total amount of rows
     * @return int
     */
    public function getCount() : int
    {
        return count($this->data);
    }

    /**
     * Should return amount of pages
     * @param int $perPage - amount of records per page
     * @return int
     */
    public function getTotalPages(int $perPage) : int
    {
        return ceil($this->getCount() / $perPage);
    }

    /**
     * @inheritdoc
     */
    public function getData(array $filters, string $orderBy, string $orderSort, int $page, int $perPage)
    {
        return array_splice($this->data, ($page -1) * $perPage, $perPage);
    }
}