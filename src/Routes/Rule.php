<?php
namespace Mxs\Routes;

use Mxs\Exceptions\Develops\{
    InputClassNotExists as ErrInputClassNotExists,
    InvalidRoute as ErrInvalidRoute,
};

class Rule
{
    use MiddlewareTrait;

    public function __construct(
        public readonly string $from_file,
        public readonly string $method,
        public readonly string $path,
        public readonly string $controller_class,
        public readonly string $method_name,
    ) {}

    public function buildAction(): Action
    {
        try {
            $method_param = new \ReflectionParameter([$this->controller_class, $this->method_name], 0);
            $in_type_name = ''.$method_param->getType();
            class_exists($in_type_name) or throw new ErrInputClassNotExists(
                $in_type_name,
                $this->controller_class,
                $this->method_name
            );
        } catch(\ReflectionException $e) {
            $in_type_name = '';
            //  throw new ErrInvalidRoute($this->from_file, $this->method, $this->path, $e);
            method_exists($this->controller_class, $this->method_name)
                or throw new ErrInvalidRoute($this->from_file, $this->method, $this->path, $e);
        }
        return new Action(
            $this->controller_class,
            $this->method_name,
            $in_type_name,
            array_reverse($this->middlewares),
        );
    }
}