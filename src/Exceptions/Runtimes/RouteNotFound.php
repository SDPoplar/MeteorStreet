<?php
namespace Mxs\Exceptions\Runtimes;

class RouteNotFound extends MxsRuntime
{
    public function __construct(string $method, string $url)
    {
        parent::__construct(
            \SeaDrip\Http\Status::NotFound,
            InnerCode::RouteNotFound,
            "route {$method}:{$url} not found"
        );
    }
}
