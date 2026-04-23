<?php
namespace Mxs\Routes;

class Rule
{
    use MiddlewareTrait;

    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly string $controller_class,
        public readonly string $method_name,
    ) {}

    public function buildAction(): Action
    {
        $method_param = new \ReflectionParameter([$this->controller_class, $this->method_name], 0);
        var_dump($method_param->getType());exit;
        //  TODO: check controller and method exists, parse method argument type
        return new Action(
            $this->controller_class,
            $this->method_name,
            $method_param->getClass(),
        );
    }
}