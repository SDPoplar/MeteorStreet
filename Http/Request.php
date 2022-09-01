<?php
namespace Mxs\Http;

class Request
{
    public function __construct(?self $copy = null)
    {
        $this->remote_addr = $copy ? $copy->remote_addr : $_SERVER['REMOTE_ADDR'];
        $this->request_scheme = $copy ? $copy->request_scheme : $_SERVER['REQUEST_SCHEME'];
        $this->url = $copy ? $copy->url : $_SERVER['REQUEST_URI'];
        $this->method = $copy ? $copy->method : strtolower($_SERVER['REQUEST_METHOD']);
        //  var_dump($_SERVER); exit;
    }

    public function cast(string $children_type): static
    {
        return (get_class($this) === $children_type) ? $this : new $children_type($this);
    }

    public readonly string $method;
    public readonly string $url;
    public readonly string $remote_addr;
    public readonly string $request_scheme;
}
