<?php
namespace Mxs\Frame;

abstract readonly class AppMode
{
    public function __construct(
        public string $root_input_type,
        public array $route_files = [],
        string|Render $use_render
    ) {
        $this->render = is_string($use_render) ? new $use_render() : $use_render;
        $this->router = new \Mxs\Frame\Router($route_files);
    }

    public function initRootInput(): \Mxs\Inputs\RootInput
    {
        return new ($this->root_input_type)();
    }

    public readonly Render $render;
    public readonly \Mxs\Frame\Router $router;
}
