<?php
namespace Mxs\Modes;

class Http extends Base
{
    public function process(): void
    {
        $request = new \Mxs\Frame\Requests\Http();
        $method = $request->method;
        $route = \Mxs\Frame\Route\Compiled::$method()->search($request->url);
        $route or (new \Mxs\Exceptions\Runtimes\RouteNotFound($method, $request->url))->occur();
        $route->dispatch();
        var_dump($route);
    }
}
