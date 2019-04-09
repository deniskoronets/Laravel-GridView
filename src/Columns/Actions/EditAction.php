<?php


namespace Woo\GridView\Columns\Actions;


class EditAction extends Action
{
    public function __construct(string $url)
    {
        parent::__construct($url, '<i class="fa fa-"', $method);
    }
}