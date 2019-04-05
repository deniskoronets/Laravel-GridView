<?php

namespace Woo\GridView;

use Woo\GridView\Columns\AttributeColumn;
use Woo\GridView\Columns\BaseColumn;
use Woo\GridView\Columns\RawColumn;
use Woo\GridView\DataProviders\DataProviderInterface;
use Woo\GridView\Renderers\DefaultRenderer;
use Woo\GridView\Renderers\BaseRenderer;
use Woo\GridView\Traits\Configurable;

class GridView
{
    use Configurable;

    /**
     * DataProvider provides gridview with the data for representation
     * @var DataProviderInterface
     */
    public $dataProvider;

    /**
     * Columns config. You may specify array or GridColumn instance
     * @var array
     */
    public $columns = [];

    /**
     * Common options for all columns, will be appended to all columns configs
     * @var array
     */
    public $columnOptions = [
        'class' => AttributeColumn::class,
    ];

    /**
     * Renders the final UI
     * @var string|BaseRenderer
     */
    public $renderer = DefaultRenderer::class;

    /**
     * Allows to pass some options into renderer/customize rendered behavior
     * @var array
     */
    public $rendererOptions = [];

    /**
     * Controls amount of data per page
     * @var int
     */
    public $rowsPerPage = 25;

    /**
     * Allows to tune the <table> tag with html options
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
        foreach ($this->columns as $key => &$columnOptions) {

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

            if ($columnOptions instanceof \Closure) {
                $columnOptions = [
                    'class' => RawColumn::class,
                    'value' => $columnOptions,
                    'title' => GridViewHelper::columnTitle($key),
                ];
            }

            /**
             * Inline column declaration detector
             */
            if (strpos($columnOptions['value'], 'view:') === 0) {
                $columnOptions['class'] = 'view';
                $columnOptions['value'] = str_replace('view:', '', $columnOptions['value']);
            }

            if (strpos($columnOptions['value'], 'blade:') === 0) {
                $columnOptions['class'] = 'blade';
                $columnOptions['value'] = str_replace('blade:', '', $columnOptions['value']);
            }

            $columnOptions = array_merge($this->columnOptions, $columnOptions);

            $className = GridViewHelper::resolveAlias('column', $columnOptions['class']);
            $columnOptions = new $className($columnOptions);
        }
    }

    /**
     * Draws widget and return html code
     * @return string
     */
    public function render()
    {
        /**
         * Making renderer
         */
        if (!is_object($this->renderer)) {
            $className = GridViewHelper::resolveAlias('renderer', $this->renderer);
            $this->renderer = new $className($this->rendererOptions);
        }

        /**
         * Build columns from config
         */
        $this->buildColumns();

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