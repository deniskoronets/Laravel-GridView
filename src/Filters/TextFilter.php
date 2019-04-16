<?php

namespace Woo\GridView\Filters;

use Woo\GridView\GridView;

class TextFilter extends BaseFilter
{
    public function render(GridView $grid): string
    {
        return view('woo_gridview::filters.text-filter', [
            'name' => $this->name,
            'value' => $grid->getRequest()->filters[$this->name] ?? '',
        ]);
    }
}