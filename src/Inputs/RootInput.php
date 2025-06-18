<?php
namespace Mxs\Inputs;

abstract readonly class RootInput
{
    public function __construct(
        public string $route_method,
        public string $route,
    ) {}
    
    abstract public function input(string $column, $def_val = null);
}
