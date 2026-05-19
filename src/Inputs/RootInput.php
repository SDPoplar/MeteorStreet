<?php
namespace Mxs\Inputs;

abstract class RootInput
{
    public function __construct(
        public readonly string $route_method,
        public readonly string $route,
    ) {}
    
    abstract public function input(string $column, mixed $def_val = null);

    public function route(string $column, mixed $def_val = null)
    {
        return $this->route_params[$column] ?? $def_val;
    }

    public function &setRouteParams(array $params): static
    {
        $this->route_params = $params;
        return $this;
    }

    public function &appendMid(string $name, mixed $value): static
    {
        $this->from_mid[$name] = $value;
        return $this;
    }

    public function mid(string $name, mixed $def = null): mixed
    {
        return $from_mid[$name] ?? $def;
    }

    protected array $route_params = [];
    protected array $from_mid = [];
}
