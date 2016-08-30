<?php

namespace Woo\GridView;

class View
{
	protected $params;

	public function __construct($params)
	{
		//
	}

	public static function make($params)
	{
		return new self($params);
	}

	public function draw()
	{
		//
	}
}