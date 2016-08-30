<?php

namespace Woo\GridView;

use \Exception as PhpException;

class ConfigException extends PhpException
{
	public function __toString()
	{
		return 'GridView broken config: ' . parent::__toString();
	}
}