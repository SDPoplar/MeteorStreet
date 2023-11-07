<?php
namespace Mxs\Http\Routes;

class RegisterItem
{
    public function __construct(public string $group, string $url)
    {
        $this->route_id = "{$group}:{$url}";
        if (preg_match_all('/\{([^\}]+)\}/', $url, $matches)) {
            $this->is_pattern = true;
            $this->route_params = $matches[1];
        } else {
            $this->is_pattern = false;
            $this->route_params = [];
        }
    }

    public function &middleware(array $middleware_types): self
    {
        $this->middlewares = $middleware_types;
        return $this;
    }

    public function useRequest(string $request_type): self
    {
        $this->request_type = $request_type;
        return $this;
    }

    public function dispatch(string $controller, string $method): self
    {
        $this->controller_name = $controller;
        $this->controller_method = $method;
        return $this;
    }

    public readonly bool $is_pattern;
    public readonly array $route_params;
    public readonly string $route_id;
    protected array $middlewares = [];
    protected string $request_type = \Mxs\Http\Request::class;
    protected string $controller_name;
    protected string $controller_method;
}