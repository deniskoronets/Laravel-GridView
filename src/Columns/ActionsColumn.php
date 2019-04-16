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
     * @var array
     */
    public $value = [];

    /**
     * @var bool
     */
    public $sortable = false;

    /**
     * @var string
     */
    public $formatters = [];

    /**
     * @var string
     */
    public $delimiter = ' ';

    /**
     * @var null
     */
    public $filter = null;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->buildActions();
    }

    protected function buildActions()
    {
        foreach ($this->value as &$action) {
            if (is_object($action)) {
                continue;
            }

            if (is_string($action)) {
                $tmp = explode(':', $action);

                $action = [
                    'class' => array_shift($tmp),
                    'args' => $tmp,
                ];
            }

            $className = GridViewHelper::resolveAlias('action', $action['class']);
            $action = new $className(...$action['args']);
        }
    }

    /**
     * @return array
     */
    protected function configTests(): array
    {
        return array_merge(parent::configTests(), [
            'value' => 'array',
            'delimiter' => 'string',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function _renderValue($row)
    {
        $result = [];

        foreach ($this->value as $action) {
            $result[] = $action->render($row);
        }

        return implode($this->delimiter, $result);
    }
}