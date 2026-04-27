<?php
namespace Mxs\Exceptions\Develops;

class InvalidRoute extends MxsDevelop
{
    public function __construct(string $from_file, string $method, string $path, \ReflectionException $prev)
    {
        parent::__construct(
            $prev->getMessage(),
            "This route is declared in {$from_file}, please check the route definition of {$method}:{$path}",
            prev: $prev
        );
    }
}
