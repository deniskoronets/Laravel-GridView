<?php

namespace Woo\GridView\Renderers;

use Woo\GridView\GridView;

interface RendererInterface
{
    public function render(GridView $view) : string;
}