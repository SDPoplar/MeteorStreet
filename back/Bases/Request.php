<?php
namespace Mxs\Bases;

class Request
{
    public function __construct()
    {
        $this->request_method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->request_uri = $_SERVER['REQUEST_URI'];
    }

    public function getMethod() : string
    {
        return $this->request_method;
    }

    public function getUrl() : string
    {
        return $this->request_uri;
    }

    private string $request_method;
    private string $request_uri;
}

