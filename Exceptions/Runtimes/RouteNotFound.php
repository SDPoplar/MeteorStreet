<?php
namespace Mxs\Exceptions\Runtimes;

class RouteNotFound extends \RuntimeException
{
    use \Mxs\Exceptions\OccurTrait;
    
    public function __construct(string $method, string $url)
    {
        parent::__construct("route {$method}:{$url} not found", 404);
    }
}
