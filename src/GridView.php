<?php

namespace Woo\GridView;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Woo\GridView\Columns\AttributeColumn;
use Woo\GridView\Columns\BaseColumn;
use Woo\GridView\Columns\CallbackColumn;
use Woo\GridView\DataProviders\BaseDataProvider;
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
     * @var BaseDataProvider
     */
    public $dataProvider;

    /**
     * Columns config. You may specify array or GridColumn instance
     * @var BaseColumn[]
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
     * Indicate if filters will be shown or not
     * @var bool
     */
    public $showFilters = true;

    /**
     * Flags allow to change standalone vue to. If false, GridView component should be included in your root Vue instance
     * @var bool
     */
    public $standaloneVue = true;

    /**
     * List of additinal params which'll be added to filter requests
     * @var array
     */
    public $additionalRequestParams = [];

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
            $this->renderer = new $className(array_merge(
                $this->rendererOptions, [
                    'gridView' => $this,
                ]
            ));
        }

        /**
         * Build columns from config
         */
        $this->buildColumns();

        $this->request = GridViewRequest::parse($this->id);
        $this->request->perPage = $this->rowsPerPage;

        $this->pagination = new LengthAwarePaginator(
            $this->dataProvider->getData($this->request),
            $this->dataProvider->getCount($this->request),
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
            'dataProvider' => BaseDataProvider::class,
            'columns' => 'array',
            'renderer' => BaseRenderer::class,
            'rowsPerPage' => 'int',
            'tableHtmlOptions' => 'array',
            'showFilters' => 'boolean',
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
            if (is_string($columnOptions['value']) && strpos($columnOptions['value'], 'view:') === 0) {
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

    /**
     * @return LengthAwarePaginator|Paginator
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @return GridViewRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function compileTableHtmlOptions() : string
    {
        return GridViewHelper::htmlOptionsToString($this->tableHtmlOptions);
    }
}
