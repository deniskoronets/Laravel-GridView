<?php

namespace Woo\GridView;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Woo\GridView\Columns\AttributeColumn;
use Woo\GridView\Columns\BaseColumn;
use Woo\GridView\Columns\CallbackColumn;
use Woo\GridView\DataProviders\DataProviderInterface;
use Woo\GridView\Renderers\DefaultRenderer;
use Woo\GridView\Renderers\BaseRenderer;
use Woo\GridView\Traits\Configurable;

class GridView
{
    use Configurable;

    /**
     * Counter for ids
     * @var int
     */
    private static $counter = 0;

    /**
     * Grid id (used for request handling, for
     * @var int
     */
    private $id;

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
     * @var Paginator
     */
    protected $pagination;

    /**
     * @var GridViewRequest
     */
    protected $request;

    /**
     * GridView constructor.
     * @param array $config
     * @throws Exceptions\GridViewConfigException
     */
    public function __construct(array $config)
    {
        $this->id = self::$counter++;

        $this->loadConfig($config);

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

        $this->request = GridViewRequest::parse($this->id);

        $this->pagination = new LengthAwarePaginator(
            $this->dataProvider->getData($this->request->page, $this->rowsPerPage),
            $this->dataProvider->getCount(),
            $this->rowsPerPage,
            $this->request->page
        );
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

            if ($columnOptions instanceof Closure) {
                $columnOptions = [
                    'class' => CallbackColumn::class,
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
        return $this->renderer->render($this);
    }

    public function getPagination()
    {
        return $this->pagination;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getId()
    {
        return $this->id;
    }
}