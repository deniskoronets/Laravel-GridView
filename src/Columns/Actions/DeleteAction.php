<?php

namespace Woo\GridView\Columns\Actions;

class DeleteAction extends Action
{
    public function __construct(string $url, string $content = '<i class="fa fa-trash-alt"></i>')
    {
        parent::__construct($url, $content, 'DELETE');
    }
}