<?php
namespace Mxs\Modes;

use Mxs\Frame\Render;
use Mxs\Routes\Manager as RouteManager;
use Mxs\Inputs\HttpRequest;
use Override;

readonly class Http extends \Mxs\Frame\AppMode
{
    public function __construct(
        string|Render $log_render = \Mxs\Frame\LogRender::class,
        string $root_input_type = \Mxs\Inputs\HttpRequest::class,
        string|Render $output_render = \Mxs\Renders\HttpApi::class,
    ) {
        $this->router = new RouteManager();
        $this->input_instance = new ($root_input_type)();
        $output_render = is_string($output_render) ? new ($output_render)($this->input_instance) : $output_render;
        parent::__construct($log_render, $output_render);
    }

    #[Override]
    public function getRequestMethod(): string
    {
        return $this->input_instance->route_method;
    }

    #[Override]
    public function getRequestPath(): string
    {
        return $this->input_instance->route;
    }

    #[Override]
    public function run(bool $debug, \Mxs\Routes\Action $action, array $route_params): void
    {
        if (!empty($route_params)) {
            $this->input_instance->setRouteParams($route_params);
        }
        $result = $action->execute($this->input_instance);
        if (!is_null($result)) {
            $this->output_render->onSuccess($result);
        }
    }

    protected readonly HttpRequest $input_instance;
    public readonly RouteManager $router;
}
