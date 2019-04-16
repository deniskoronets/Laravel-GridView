<?php

namespace Woo\GridView\Columns\Actions;

use Closure;

class Action
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $method;

    /**
     * Action constructor.
     * @param string|Closure $url
     * @param string $content
     * @param string $method
     */
    public function __construct($url, string $content, string $method = 'GET')
    {
        $this->url = $url;

        $this->content = $content;

        $this->method = $method;
    }

    protected function buildUrl($row)
    {
        if ($this->url instanceof Closure) {
            return call_user_func($this->url, $row);
        }

        return preg_replace_callback('/\{([\w\_]+)\}/', function($match) use ($row) {

            $match = $match[1];

            if (isset($row->$match)) {
                return $row->$match;

            } elseif (isset($row[$match])) {
                return $row[$match];
            }

            return '';
        }, $this->url);
    }

    public function render($row)
    {
        return view('woo_gridview::columns.action', [
            'url' => $this->buildUrl($row),
            'content' => $this->content,
            'method' => $this->method,
        ])->render();
    }
}