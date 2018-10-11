<?php

namespace Woo\GridView;

use Woo\GridView\Columns\AttributeColumn;
use Woo\GridView\Columns\BaseColumn;
use Woo\GridView\DataProviders\DataProviderInterface;
use Woo\GridView\Renderers\DefaultRenderer;
use Woo\GridView\Renderers\RendererInterface;

class GridView
{
    /**
     * @var DataProviderInterface
     */
    public $dataProvider;

    /**
     * @var array
     */
    public $columns = [];

    /**
     * @var string
     */
    public $columnClass = AttributeColumn::class;

    /**
     * @var string|RendererInterface
     */
    public $renderer = DefaultRenderer::class;

    /**
     * @var int
     */
    public $rowsPerPage = 25;

    /**
     * @var array
     */
    public $tableHtmlOptions = [
        'class' => 'table table-bordered gridview-table',
    ];

    /**
     * GridView constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        GridViewHelper::loadConfig($this, $config);

        GridViewHelper::testConfig($this, [
            'dataProvider' => DataProviderInterface::class,
            'columns' => 'array',
            'columnClass' => BaseColumn::class,
            'renderer' => RendererInterface::class,
            'rowsPerPage' => 'int',
            'tableHtmlOptions' => 'array',
        ]);

        $this->buildColumns();
    }

    /**
     * Build columns into objects
     */
    protected function buildColumns()
    {
        foreach ($this->columns as &$column) {

            if (is_object($column)) {
                continue;
            }

            $className = $column['class'] ?? $this->columnClass;
            $column = new $className($column);
        }
    }

    /**
     * Makes an instance
     * @param $params
     * @return GridView
     */
    public static function make($params)
    {
        return new self($params);
    }

    /**
     * Draws widget and return html code
     * @return string
     */
    public function render()
    {
        if (!is_object($this->renderer)) {
            $this->renderer = new $this->renderer;
        }

        return $this->renderer->render($this);
    }

    /**
     * Wrapper for draw method
     * @see View::draw()
     */
    public function __toString()
    {
        return $this->render();
    }
}