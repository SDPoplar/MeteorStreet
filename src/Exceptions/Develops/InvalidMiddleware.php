<?php
namespace Mxs\Exceptions\Develops;

class InvalidMiddleware extends MxsDevelop
{
    public function __construct(string $middlewareClass)
    {
        parent::__construct(
            "invalid middleware {$middlewareClass}",
            "a middleware class should implements " . \Mxs\Routes\MiddlewareInterface::class
        );
    }
}
