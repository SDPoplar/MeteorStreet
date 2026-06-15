<?php
namespace Mxs\Exceptions\Develops;

class InvalidInputClass extends MxsDevelop
{
    public function __construct(string $given)
    {
        parent::__construct(
            "Invalid input class",
            "class [{$given}] should be instance or sub-class of " . \Mxs\Inputs\RootInput::class
        );
    }
}
