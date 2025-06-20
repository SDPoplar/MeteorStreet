<?php
namespace Mxs\RouteTools;

class RouteRule
{
    use \Mxs\Routes\DecorationTrait;

    public function __construct(
        protected string $patten,
        public readonly string $method,
    ) {
        //  init route action node
    }

    public function getFinalPatten(): string
    {
        return $this->patten_prefix.$this->patten;
    }

    public function &castInput(string $input_class): self
    {
        $this->cast_input_class = $input_class;
        return $this;
    }

    protected string $cast_input_class = '';
}
