<?php
namespace Mxs\Modes;

use Mxs\Gate\{
    Input,
    Render,
};
use Mxs\Frame\LogRender;
use Mxs\Exceptions\Develops\{
    InvalidInputClass,
    InvalidRenderClass,
};
use Override;

readonly class Console extends \Mxs\Frame\AppMode
{
    final public const string METHOD = 'console';

    public function __construct(
        string|Input $input = \Mxs\Inputs\Console::class,
        string|LogRender $log_render = LogRender::class,
        string|Render $output_render = \Mxs\Renders\Console::class,
    ) {
        is_subclass_of($input, Input::class) or throw new InvalidInputClass(
            is_string($input) ? $input : $input::class
        );
        $this->input = is_string($input) ? new $input() : $input;

        is_subclass_of($output_render, Render::class) or throw new InvalidRenderClass(
            is_string($output_render) ? $output_render : $output_render::class
        );
        parent::__construct($log_render, is_string($output_render) ? new $output_render() : $output_render);
    }

    #[Override]
    public function getInputInstance(): Input
    {
        return $this->input;
    }

    protected \Mxs\Inputs\Console $input;
}

