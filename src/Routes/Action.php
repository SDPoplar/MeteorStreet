<?php
namespace Mxs\Routes;

readonly class Action
{
    public function __construct(
        public string $controller_class,
        public string $method_name,
        public string $cast_input_class,
    ) {}

    public function execute(\Mxs\Inputs\RootInput $input)
    {
        $castedInput = is_a($input, $this->cast_input_class) ? $input
            : new ($this->cast_input_class)($input);
        $ctrl_ins = new ($this->controller_class)();
        $m = $this->method_name;
        return $ctrl_ins->$m($castedInput);
    }
}
