<?php
namespace Mxs\Exceptions\Develops;

class InvalidRoute extends MxsDevelop
{
    public static function noControllerSetted(string $route_id): self
    {
        return new self($route_id, 'no controller setted');
    }

    public static function noMethodSetted(string $route_id): self
    {
        return new self($route_id, 'no method setted');
    }

    public static function noMethodInController(string $route_id): self
    {
        return new self($route_id, 'method not found in given controller');
    }

    public function __construct(string $route_id, string $problem)
    {
        $this->route_id = $route_id;
        $this->problem = $problem;
        parent::__construct(
            "{$this->problem} in route {$this->route_id}",
            "Please find your registor of {$this->route_id} and then set an controller with ->dispatch(controller::class, method_name) method"
        );
    }

    public readonly string $problem;
    public readonly string $route_id;
}
