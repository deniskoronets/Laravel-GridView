<?php

namespace Woo\GridView\Renderers;

use Woo\GridView\GridView;
use Woo\GridView\GridViewHelper;

class DefaultRenderer extends BaseRenderer
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        $filters = [];
        foreach ($this->gridView->columns as $column) {
            if ($column->filter) {
                $filters[$column->filter->name] = $this->gridView->getRequest()->getFilterValue($column->filter->name);
            }
        }

        return view('woo_gridview::renderers.default', [
            'grid' => $this->gridView,
            'filters' => $filters,
        ])->render();
    }
}