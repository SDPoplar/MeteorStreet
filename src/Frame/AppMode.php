<?php
namespace Mxs\Frame;

use Mxs\Inputs\RootInput;
use Mxs\Routes\Manager as RouteManager;

abstract readonly class AppMode
{
    public function __construct(
        protected readonly string $root_input_type,
        string|Render $use_render
    ) {
        if (is_string($use_render)) {
            $this->render_type = $use_render;
        } else {
            $this->render_type = $use_render::class;
            $this->render = $use_render;
        }
        $this->router = new RouteManager();
    }

    public function getRootInputInstance(): RootInput
    {
        return $this->input_instance ??= new ($this->root_input_type)();
    }

    public function getRenderInstance(): Render
    {
        return $this->render ??= new ($this->render_type)($this->getRootInputInstance());
    }

    protected readonly RootInput $input_instance;
    protected readonly string $render_type;
    protected readonly Render $render;
    public readonly RouteManager $router;
}
