<?php
namespace Mxs\Exceptions\Develops;

class InvalidRoute extends MxsDevelop
{
    public function __construct(string $from_file, string $method, string $path, string|\ReflectionException $prev_or_msg)
    {
        parent::__construct(
            is_string($prev_or_msg) ? $prev_or_msg : $prev_or_msg->getMessage(),
            "This route is declared in {$from_file}, please check the route definition of {$method}:{$path}",
            prev: is_string($prev_or_msg) ? null : $prev_or_msg
        );
    }
}
