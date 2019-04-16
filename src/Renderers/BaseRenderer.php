<?php

namespace Woo\GridView\Renderers;

use Illuminate\Pagination\Paginator;
use Woo\GridView\Exceptions\GridViewConfigException;
use Woo\GridView\GridView;
use Woo\GridView\Traits\Configurable;

abstract class BaseRenderer
{
    use Configurable;

    /**
     * @var GridView
     */
    public $gridView;

    /**
     * BaseRenderer constructor.
     * @param $config
     * @throws GridViewConfigException
     */
    public function __construct($config)
    {
        $this->loadConfig($config);
    }

    /**
     * @return array
     */
    protected function configTests(): array
    {
        return [
            'gridView' => GridView::class,
        ];
    }

    public abstract function render() : string;
}