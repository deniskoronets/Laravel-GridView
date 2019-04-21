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

    public $perPage;

    public $filters = [];

    private function __construct($config)
    {
        $this->loadConfig($config);
    }

    private static function gridField(int $gridId, string $field)
    {
        return $gridId == 0 ? $field : 'grid.' . $gridId . '.' . $field;
    }

    /**
     * Allows to parse request information and making request instance
     * @param int $gridId
     * @return GridViewRequest
     */
    public static function parse(int $gridId)
    {
        $request = Request::instance();

        $page = $request->input(self::gridField($gridId, 'page'), 1);
        $sortColumn = $request->input(self::gridField($gridId, 'sort'), '');
        $sortOrder = $request->input(self::gridField($gridId, 'order'), 'DESC');
        $filters = $request->input(self::gridField($gridId, 'filters'), []);

        if ($page <= 0) {
            $page = 1;
        }

        if (!is_string($sortColumn)) {
            $sortColumn = '';
        }

        if (!in_array($sortOrder, ['ASC', 'DESC'])) {
            $sortOrder = 'DESC';
        }

        if (!is_array($filters)) {
            $filters = [];
        }

        return new GridViewRequest([
            'page' => $page,
            'sortColumn' => $sortColumn,
            'sortOrder' => $sortOrder,
            'filters' => $filters,
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