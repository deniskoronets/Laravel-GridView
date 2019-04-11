<?php

namespace Woo\GridView\DataProviders;

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
     * Should return total amount of rows
     * @return int
     */
    public function getCount() : int
    {
        return count($this->data);
    }

    /**
     * @inheritdoc
     */
    public function getData(array $filters, string $orderBy, string $orderSort, int $page, int $perPage)
    {
        return array_splice($this->data, ($page -1) * $perPage, $perPage);
    }
}