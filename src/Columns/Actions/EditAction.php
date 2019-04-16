<?php


namespace Woo\GridView\Columns\Actions;


class EditAction extends Action
{
    public function __construct(string $url, string $content = '<i class="fa fa-edit"></i>')
    {
        parent::__construct($url,  $content, 'GET');
    }
}