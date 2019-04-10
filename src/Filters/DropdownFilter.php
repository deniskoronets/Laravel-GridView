<?php

namespace Woo\GridView\Filters;

use Woo\GridView\GridView;

class DropdownFilter extends BaseFilter
{
    /**
     * @var array
     */
    public $items;

    protected function configTests(): array
    {
        return array_merge(parent::configTests(), [
            'items' => 'array',
        ]);
    }

    public function render(GridView $grid): string
    {
        return view('woo_gridview::filters.dropdown-filter', [
            'name' => $this->name,
            'value' => $grid->getRequest()->filters[$this->name] ?? '',
            'items' => $this->items,
        ]);
    }
}