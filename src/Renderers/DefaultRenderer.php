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
        return view('woo_gridview::render-default', [
            'grid' => $this->gridView
        ])->render();
    }
}