<?php

namespace Woo\GridView\Renderers;

use Woo\GridView\GridView;
use Woo\GridView\GridViewHelper;

class DefaultRenderer extends BaseRenderer
{
    /**
     * @param GridView $view
     * @return string
     * @throws \Throwable
     */
    public function render(GridView $view): string
    {
        $page = intval($_GET['page'] ?? 1);

        return view('woo_gridview::render-default', [
            'columns' => $view->columns,
            'data' => $view->dataProvider->getData($page, $view->rowsPerPage),
            'tableHtmlOptions' => GridViewHelper::htmlOptionsToString($view->tableHtmlOptions),
            'dataProvider' => $view->dataProvider,
            'perPage' => $view->rowsPerPage,
            'currentPage' => $page,
            'containerId' => $this->id,
        ])->render();
    }
}