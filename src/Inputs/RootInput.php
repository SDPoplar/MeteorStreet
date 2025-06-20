<?php
namespace Mxs\Inputs;

abstract class RootInput
{
    public function __construct(
        public readonly string $route_method,
        public readonly string $route,
    ) {}
    
    abstract public function input(string $column, $def_val = null);

    public function route(string $column, $def_val = null)
    {
        return $this->route_params[$column] ?? $def_val;
    }

    public function &setRouteParams(array $params): static
    {
        $this->route_params = $params;
        return $this;
    }

    protected array $route_params = [];
}
