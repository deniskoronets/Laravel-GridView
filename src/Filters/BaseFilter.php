<?php

namespace Woo\GridView\Filters;

use Woo\GridView\GridView;
use Woo\GridView\Traits\Configurable;

abstract class BaseFilter
{
    use Configurable;

    public $name;

    public function __construct(array $config)
    {
        $this->loadConfig($config);
    }

    protected function configTests(): array
    {
        return [
            'name' => 'string',
        ];
    }

    abstract public function render(GridView $grid) : string;
}