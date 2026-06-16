<?php
namespace Mxs\Modes;

use Mxs\Inputs\RootInput;
use Mxs\Frame\{
    Render,
    LogRender
};
use Mxs\Exceptions\Develops\{
    InvalidInputClass,
    InvalidRenderClass,
};
use Override;

readonly class Console extends \Mxs\Frame\AppMode
{
    final public const string METHOD = 'console';

    public function __construct(
        string|RootInput $input = \Mxs\Inputs\Console::class,
        string|LogRender $log_render = LogRender::class,
        string|Render $output_render = \Mxs\Renders\Console::class,
    ) {
        is_subclass_of($input, RootInput::class) or throw new InvalidInputClass(
            is_string($input) ? $input : $input::class
        );
        $this->input = is_string($input) ? new $input() : $input;

        is_subclass_of($output_render, Render::class) or throw new InvalidRenderClass(
            is_string($output_render) ? $output_render : $output_render::class
        );
        parent::__construct($log_render, is_string($output_render) ? new $output_render() : $output_render);
    }

    #[Override]
    public function run(bool $debug, \Mxs\Routes\Action $action, array $route_params): void
    {
        //  var_dump('???', $this->input->allInputs()); exit;
        $action->execute($this->input);
    }

    #[Override]
    public function getRequestMethod(): string
    {
        return self::METHOD;
    }

    #[Override]
    public function getRequestPath(): string
    {
        return $this->input->route;
    }

    protected \Mxs\Inputs\Console $input;
}

