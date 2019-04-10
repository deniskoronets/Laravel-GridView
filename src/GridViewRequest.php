<?php

namespace Woo\GridView;

use Illuminate\Support\Facades\Request;
use Woo\GridView\Traits\Configurable;

class GridViewRequest
{
    use Configurable;

    public $page;

    public $sortColumn;

    public $sortOrder;

    public $filters = [];

    private function __construct($config)
    {
        $this->loadConfig($config);
    }

    /**
     * Allows to parse request information and making request instance
     * @param int $gridId
     * @return GridViewRequest
     */
    public static function parse(int $gridId)
    {
        $request = Request::instance();

        return new GridViewRequest([
            'page' => (int)$request->input($gridId == 0 ? 'page' : 'grid.' . $gridId . '.page', 1),
            'sortColumn' => $request->input($gridId == 0 ? 'sort' : 'grid.' . $gridId . '.sort'),
            'sortOrder' => $request->input($gridId == 0 ? 'order' : 'grid.' . $gridId . '.order'),
            'filters' => $request->input($gridId == 0 ? 'filters' : 'grid.' . $gridId . '.filters', []),
        ]);
    }

    public function getFilterValue(string $name)
    {
        return $this->filters[$name] ?? '';
    }

    /**
     * Should specify tests
     * @return array
     */
    protected function configTests(): array
    {
        return [];
    }
}