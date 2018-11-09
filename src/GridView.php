<?php

namespace Woo\GridView;

use Woo\GridView\Columns\AttributeColumn;
use Woo\GridView\Columns\BaseColumn;
use Woo\GridView\DataProviders\DataProviderInterface;
use Woo\GridView\Renderers\DefaultRenderer;
use Woo\GridView\Renderers\BaseRenderer;
use Woo\GridView\Traits\Configurable;

class GridView
{
    use Configurable;

    /**
     * @var DataProviderInterface
     */
    public $dataProvider;

    /**
     * @var array
     */
    public $columns = [];

    /**
     * @var array
     */
    public $columnOptions = [
        'class' => AttributeColumn::class,
    ];

    /**
     * @var string|BaseRenderer
     */
    public $renderer = DefaultRenderer::class;

    /**
     * @var array
     */
    public $rendererOptions = [];

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
     * @throws Exceptions\GridViewConfigException
     */
    public function __construct(array $config)
    {
        $this->loadConfig($config);
        $this->buildColumns();
    }

    /**
     * @return array
     */
    protected function configTests(): array
    {
        return [
            'dataProvider' => DataProviderInterface::class,
            'columns' => 'array',
            'renderer' => BaseRenderer::class,
            'rowsPerPage' => 'int',
            'tableHtmlOptions' => 'array',
        ];
    }

    /**
     * Build columns into objects
     */
    protected function buildColumns()
    {
        foreach ($this->columns as &$columnOptions) {

            /**
             * In case of when column is already build
             */
            if (is_object($columnOptions)) {
                continue;
            }

            /**
             * When only attribute name/value passed
             */
            if (is_string($columnOptions)) {
                $columnOptions = [
                    'value' => $columnOptions,
                ];
            }

            $columnOptions = array_merge($this->columnOptions, $columnOptions);

            $className = GridViewHelper::resolveAlias('column', $columnOptions['class']);
            $columnOptions = new $className($columnOptions);
        }
    }

    /**
     * Makes an instance
     * @param $params
     * @return GridView
     * @throws Exceptions\GridViewConfigException
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

            $className = GridViewHelper::resolveAlias('renderer', $this->renderer);

            $this->renderer = new $className($this->rendererOptions);
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