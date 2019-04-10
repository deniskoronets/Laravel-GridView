<?php

namespace Woo\GridView\Columns;

use Closure;
use Woo\GridView\Exceptions\GridViewConfigException;
use Woo\GridView\Filters\TextFilter;
use Woo\GridView\GridViewHelper;

class AttributeColumn extends BaseColumn
{
    public $formatters = ['text'];

    public $filter = TextFilter::class;

    /**
     * AttributeColumn constructor.
     * @param $config
     * @throws GridViewConfigException
     */
    public function __construct($config)
    {
        parent::__construct($config);

        $this->buildFilter();

        if (empty($this->title)) {
            $this->title = GridViewHelper::columnTitle($this->value);
        }
    }

    protected function buildFilter()
    {
        if (is_null($this->filter) || is_object($this->filter)) {
            return;
        }

        if (is_string($this->filter)) {
            $this->filter = [
                'class' => $this->filter,
                'name' => $this->value,
            ];
        }

        $className = GridViewHelper::resolveAlias('filter', $this->filter['class']);
        $this->filter = new $className($this->filter);
    }

    /**
     * @return array
     */
    protected function configTests(): array
    {
        return array_merge(parent::configTests(), [
            'value' => 'string',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function _renderValue($row)
    {
        $path = $row;
        $exp = explode('.', $this->value);

        /**
         * Extract dots notation (column.sub.sub)
         */
        foreach ($exp as $part) {

            if (isset($path[$part])) {
                $path = $path[$part];

            } elseif (isset($path->$part)) {
                $path = $path[$part];
            } else {
                return $this->emptyValue;
            }
        }

        return $path;
    }
}