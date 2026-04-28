<?php
namespace Mxs\Modes;

readonly class Http extends \Mxs\Frame\AppMode
{
    public function __construct(
        string $root_input_type = \Mxs\Inputs\HttpRequest::class,
        string $render_type = \Mxs\Renders\HttpApi::class,
    ) {
        parent::__construct($root_input_type, $render_type);
    }
}
