<?php
namespace Mxs\Routes;

trait MiddlewareTrait
{
    public function &middware(string ...$middleware_types): self
    {
        $this->middlewares = array_unique(array_merge($this->middlewares, $middleware_types));
        return $this;
    }
    
    protected array $middlewares = [];
}
