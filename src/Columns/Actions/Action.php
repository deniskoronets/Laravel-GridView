<?php


namespace Woo\GridView\Columns\Actions;


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

    public function __construct(string $url, string $content, string $method = 'GET')
    {
        $this->url = $url;

        $this->content = $content;

        $this->method = $method;
    }

    public function render()
    {
        return view('woo_gridview::action', [
            'url' => $this->url,
            'content' => $this->content,
            'method' => $this->method,
        ])->render();
    }
}