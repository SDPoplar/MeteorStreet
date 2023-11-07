<?php
namespace Mxs\Modes;

abstract class Base
{
    public function __construct(
        public readonly string $root_input_type,
        public readonly string $route_manager_type,
    ) {}

    public function initRootInput(): \Mxs\Inputs\RootInputInterface
    {
        return new ($this->root_input_type)();
    }

    public function despatch(\Mxs\Inputs\RootInputInterface $in)
    {
        ($this->route_manager ??= new $this->route_manager_type);
    }

    abstract public function process(): void;

    protected $route_manager;
}
