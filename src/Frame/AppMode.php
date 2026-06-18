<?php
namespace Mxs\Frame;

abstract readonly class AppMode
{
    abstract public function getInputInstance(): \Mxs\Gate\Input;

    public function __construct(
        string|LogRender $log_render,
        public private(set) \Mxs\Gate\Render $output_render
    ) {
        $this->log_render = is_string($log_render) ? new ($log_render)() : $log_render;
    }

    public readonly LogRender $log_render;
}
