<?php
namespace Mxs\Modes;

class Http extends Base
{
    public function process(): void
    {
        $request = new \Mxs\Frame\Requests\Http();
        $route = \Mxs\Frame\Route\Compiled::load($request->method)->search($request->url);
        $route->dispatch($request);
    }
}
