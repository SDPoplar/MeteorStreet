<?php
namespace Mxs\Routes;

class RuleGroup
{
    use MiddlewareTrait;

    public function __construct(
        protected \Closure $regist_func
    ) {}
    
    public function getRegistedMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function compile(): void
    {
        $func = $this->regist_func;
        $func();
    }
}
