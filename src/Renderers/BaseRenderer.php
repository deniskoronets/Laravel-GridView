<?php

namespace Woo\GridView\Renderers;

use Woo\GridView\GridView;
use Woo\GridView\Traits\Configurable;

abstract class BaseRenderer
{
    use Configurable;

    /**
     * HTML ID of container
     * @var string
     */
    public $id = '';

    /**
     * BaseRenderer constructor.
     * @param $config
     * @throws \Woo\GridView\Exceptions\GridViewConfigException
     */
    public function __construct($config)
    {
        $this->loadConfig($config);

        if (empty($this->id)) {
            $this->id = 'grid_' . uniqid();
        }
    }

    /**
     * @return array
     */
    protected function configTests(): array
    {
        return [
            'id' => 'string',
        ];
    }

    public abstract function render(GridView $view) : string;
}