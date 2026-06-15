<?php
namespace Mxs\Routes;

use Mxs\Inputs\RootInput;
use Mxs\Routes\MiddlewareInterface as IMid;

readonly class Action
{
    public function __construct(
        public string $controller_class,
        public string $method_name,
        public string $cast_input_class,
        public array $middlewares = [],
    ) {}

    public function execute(RootInput $input)
    {
        $next = $this->buildCoreCloure();
        foreach ($this->middlewares as $mid) {
            $mid_ins = (fn(string $mid_cls): IMid => new $mid_cls())($mid);
            $cur = function(RootInput $ri) use ($mid_ins, $next) {
                return $mid_ins->handle($ri, $next);
            };
            $next = $cur;
        }
        return $next($input);
    }

    private function buildCoreCloure(): \Closure
    {
        $cast_in_cls = $this->cast_input_class;
        $ctrl_cls = $this->controller_class;
        $method_name = $this->method_name;
        if (empty($cast_in_cls)) {
            return function(RootInput $input) use ($ctrl_cls, $method_name) {
                return new $ctrl_cls()->$method_name();
            };
        } else {
            return function(RootInput $input) use ($cast_in_cls, $ctrl_cls, $method_name) {
                $castedInput = is_a($input, $cast_in_cls) ? $input
                    : new $cast_in_cls($input);
                return new $ctrl_cls()->$method_name($castedInput);
            };
        }
    }
}
