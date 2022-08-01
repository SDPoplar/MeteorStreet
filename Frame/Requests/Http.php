<?php
namespace Mxs\Frame\Requests;

class Http
{
    public function __construct()
    {
        $this->remote_addr = $_SERVER['REMOTE_ADDR'];
        $this->request_scheme = $_SERVER['REQUEST_SCHEME'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        //  var_dump($_SERVER); exit;
    }

    public readonly string $method;
    public readonly string $url;
    public readonly string $remote_addr;
    public readonly string $request_scheme;
}
