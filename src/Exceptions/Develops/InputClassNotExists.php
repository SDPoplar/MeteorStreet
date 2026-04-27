<?php
namespace Mxs\Exceptions\Develops;

class InputClassNotExists extends MxsDevelop
{
    public function __construct(string $class_name, string $controller_name, string $method_name)
    {
        parent::__construct(
            "input class {$class_name} not exists",
            "Please check the method definition of {$controller_name}::{$method_name}"
        );
    }
}
