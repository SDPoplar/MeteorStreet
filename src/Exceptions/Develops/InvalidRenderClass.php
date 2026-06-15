<?php
namespace Mxs\Exceptions\Develops;

class InvalidRenderClass extends MxsDevelop
{
    public function __construct(string $given)
    {
        parent::__construct(
            "Invalid render class",
            "class [{$given}] should be instance or sub-class of " . \Mxs\Frame\Render::class
        );
    }
}
