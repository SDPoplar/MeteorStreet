<?php
namespace Mxs\RouteTools;

final class RouteGroup
{
    use \Mxs\Routes\DecorationTrait;

    public function append(RouteRule $rule): void
    {
        $this->rules[] = $rule;
    }

    protected array $rules = [];
}
