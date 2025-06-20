<?php
namespace Mxs\Routes;

class Rule
{
    public function __construct(
        public readonly string $method,
        public readonly string $path,
    ) {}

    public function &bindMethod(string $controllerClass, string $method_name): static
    {
        return $this;
    }

    public function buildAction(): Action
    {
        return new Action();
    }
}