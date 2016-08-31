<?php

namespace Woo\GridView;

use Illuminate\Database\Query\Builder;

class View
{
	protected $params = [];
	protected $dataSource;

	public function __construct($params)
	{
		$this->load($params);
	}

	/**
	 * Load params into the current view instance
	 * @param array $params
	 * @return $this
	 */
	public function load($params)
	{
		$this->params = array_merge($this->params, $params);

		return $this;
	}

	/**
	 * Makes an instance of GridView component
	 * @param array $params
	 * @see View::__construct()
	 */
	public static function make($params)
	{
		return new self($params);
	}

	/**
	 * Will check passed params for integrity
	 */
	private function checkParams()
	{
		if (empty($this->params['dataProvider'])
	     || !($this->params['dataProvider'] instanceof Builder)
		) {
			throw new ConfigException(
				'Invalid dataProvider. It must be an instance of Laravel\'s builder'
			);
		}

		if (!empty($this->params['columns']) && !is_array($this->params['columns'])) {
			throw new ConfigException(
				'Columns param must be an array'
			);
		}

		foreach ($this->params['columns'] as &$column) {
			// @todo: implement check for column config integrity
		}
	}

	/**
	 * Compile the data to an array
	 * @return array
	 */
	private function collectData()
	{
		$result = [];

		foreach ($this->dataSource->all() as $rowData) {
			$row = [];
			foreach ($this->params['columns'] as $id => $column) {

				if (is_string($column)) {

					$row[$id] = $rowData->{$column};

				} elseif (is_array($column)) {

					if (is_callable($column['value'])) {
						$row[$id] = $column['value']($rowData);
					}
				}
			}

			$result[] = $row;
			$row = [];
		}

		return $array;
	}

	/**
	 * Compile columns list
	 * @return array
	 */
	public function getColumnsList()
	{
		$items = [];
		foreach ($this->params['columns'] as $id => $column) {
			$items[$id] = $column['label'];
		}

		return $items;
	}

	/**
	 * Draws widget and return html code
	 * @return string
	 */
	public function draw()
	{
		$this->checkParams();

		return view('gridview::list', [
			'columns' => $this->getColumnsList(),
			'data' => $this->collectData()
		]);
	}

	/**
	 * Wrapper for draw method
	 * @see View::draw()
	 */
	public function __toString()
	{
		echo $this->draw();
	}
}