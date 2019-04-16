<?php


namespace Woo\GridView\Columns\Actions;


class ShowAction extends Action
{
    public function __construct(string $url, string $content = '<i class="fa fa-eye"></i>')
    {
        parent::__construct($url, $content, 'GET');
    }
}