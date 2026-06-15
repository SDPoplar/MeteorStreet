<?php
namespace Mxs\Frame;

abstract readonly class AppMode
{
    abstract public function run(bool $debug): void;
    abstract public function getOutputRender(): Render;

    public function __construct(
        string|LogRender $log_render
    ) {
        $this->log_render = is_string($log_render) ? new ($log_render)() : $log_render;
    }

    public readonly LogRender $log_render;
}
