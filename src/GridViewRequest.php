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
            'page' => $request->get($gridId == 0 ? 'page' : 'g' . $gridId . '.page', 1),
            'sortColumn' => $request->get($gridId == 0 ? 'sort' : 'g' . $gridId . '.sort'),
            'sortOrder' => $request->get($gridId == 0 ? 'order' : 'g' . $gridId . '.order'),
            'filters' => $request->get($gridId == 0 ? 'filters' : 'g' . $gridId . '.filters', []),
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