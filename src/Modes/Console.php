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
    public function __construct(
        string|RootInput $input = \Mxs\Inputs\Console::class,
        string|LogRender $log_render = LogRender::class,
        string|Render $output_render = \Mxs\Console\Render::class,
    ) {
        parent::__construct($log_render);
        is_subclass_of($input, RootInput::class) or throw new InvalidInputClass(
            is_string($input) ? $input : $input::class
        );
        $this->input = is_string($input) ? new $input() : $input;

        is_subclass_of($output_render, Render::class) or throw new InvalidRenderClass(
            is_string($output_render) ? $output_render : $output_render::class
        );
        $this->output_render = is_string($output_render) ? new $output_render() : $output_render;
    }

    #[Override]
    public function run(bool $debug): void
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function getOutputRender(): Render
    {
        return $this->output_render;
    }

    protected \Mxs\Inputs\Console $input;
    public readonly Render $output_render;
}

