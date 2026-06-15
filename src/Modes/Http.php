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
        parent::__construct($log_render);
        $this->router = new RouteManager();
        $this->input_instance = new ($root_input_type)();
        $this->output_render = is_string($output_render) ? new ($output_render)($this->input_instance) : $output_render;
    }

    #[Override]
    public function run(bool $debug): void
    {
        $root_input = $this->input_instance;
        if ($debug) {
            $this->router->cache();
        }
        $route_item = $this->router->dispatch($root_input);
        $result = $route_item->execute($root_input);
        if (!is_null($result)) {
            $this->getOutputRender()->onSuccess($result);
        }
    }

    #[Override]
    public function getOutputRender(): Render
    {
        return $this->output_render;
    }

    protected readonly HttpRequest $input_instance;
    public readonly RouteManager $router;
    public readonly Render $output_render;
}
