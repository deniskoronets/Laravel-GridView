<?php

namespace Woo\GridView\Columns;

use Woo\GridView\GridViewHelper;

class ActionsColumn extends BaseColumn
{
    /**
     * By default is empty for this column
     * @var string
     */
    public $title = '';

    /**
     * Value contains short codes for actions
     * @var string
     */
    public $value = '{show} {edit} {delete}';

    /**
     * Additional actions could be added, key is short-code and value is callback
     * @var array
     */
    public $additionalActions = [];

    /**
     * @var \Closure|null
     */
    public $actionsUrls;

    public function __construct(array $config)
    {
        parent::__construct($config);

        GridViewHelper::testConfig($this, [
            'value' => 'string',
            'additionalActions' => 'array',
            'actionsUrls' => 'any',
        ]);
    }

    public function basicActions()
    {
        return [
            'show' => function($model) {
                return '<a href="' . call_user_func($this->actionsUrls, $model)['show'] . '">Show</a>';
            },
            'edit' => function($model) {
                return '<a href="' . call_user_func($this->actionsUrls, $model)['edit'] . '">Edit</a>';
            },
            'delete' => function($model) {
                return '<a href="' . call_user_func($this->actionsUrls, $model)['delete'] . '">Remove</a>';
            },
        ];
    }

    public function renderValue($row)
    {
        $result = $this->value;

        $actions = array_merge($this->basicActions(), $this->additionalActions);

        foreach ($actions as $key => $action) {
            if (strpos($result, '{' . $key . '}') === false) {
                continue;
            }

            $result = str_replace('{' . $key . '}', $action($row), $result);
        }

        return $result;
    }
}