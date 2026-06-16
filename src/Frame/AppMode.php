<?php
namespace Mxs\Frame;

abstract readonly class AppMode
{
    abstract public function getRequestMethod(): string;
    abstract public function getRequestPath(): string;
    abstract public function run(bool $debug, \Mxs\Routes\Action $action, array $route_params);

    public function __construct(
        string|LogRender $log_render,
        public private(set) Render $output_render
    ) {
        $this->log_render = is_string($log_render) ? new ($log_render)() : $log_render;
    }

    public readonly LogRender $log_render;
}
