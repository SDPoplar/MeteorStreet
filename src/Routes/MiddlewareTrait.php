<?php
namespace Mxs\Routes;

trait MiddlewareTrait
{
    public function &middware(string ...$middleware_types): self
    {
        $this->middlewares = array_unique(array_merge($this->middlewares, $middleware_types));
        return $this;
    }

    public function checkMiddleware(): void
    {
        foreach ($this->middlewares as $cls_name) {
            $ii = class_implements($cls_name);
            if (($ii === false) or !array_key_exists(\Mxs\Routes\MiddlewareInterface::class, $ii)) {
                throw new \Mxs\Exceptions\Develops\InvalidMiddleware($cls_name);
            }
        }
    }
    
    protected array $middlewares = [];
}
