<?php
namespace Mxs\Frame;

abstract class AppMode
{
    public function __construct(
        public readonly string $root_input_type,
        public readonly string $route_manager_type,
        string|Render $use_render
    ) {
        $this->render = is_string($use_render) ? new $use_render : $use_render;
    }

    public function initRootInput(): \Mxs\Inputs\RootInputInterface
    {
        return new ($this->root_input_type)();
    }

    public function route(\Mxs\Inputs\RootInputInterface $in): \Mxs\Route\Item
    {
        return ($this->route_manager ??= new $this->route_manager_type)->dispatch($in);
    }

    public function canRenderResponse(): bool
    {
        return $this->render instanceof ResponseRenderable;
    }

    public readonly Render $render;
    protected \Mxs\Route\Dispatcher $route_manager;
}
