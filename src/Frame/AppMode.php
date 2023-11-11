<?php
namespace Mxs\Frame;

abstract class AppMode
{
    public function __construct(
        public readonly string $root_input_type,
        public readonly string $route_manager_type,
    ) {}

    public function initRootInput(): \Mxs\Inputs\RootInputInterface
    {
        return new ($this->root_input_type)();
    }

    public function route(\Mxs\Inputs\RootInputInterface $in): \Mxs\Route\Item
    {
        return ($this->route_manager ??= new $this->route_manager_type)->dispatch($in);
    }

    abstract public function process(): void;

    protected \Mxs\Route\Dispatcher $route_manager;
}