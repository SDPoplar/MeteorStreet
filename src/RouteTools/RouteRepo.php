<?php
namespace Mxs\RouteTools;

class RouteRepo
{
    public function append(RouteRule|RouteGroup $items): void
    {}

    protected function appendGroup(RouteGroup $group): void
    {
        $trans = new class($group) extends RouteGroup {
            public function __construct(RouteGroup $group)
            {
                $this->rules = $group->rules;
                $this->middlewares = $group->middlewares;
                $this->patten_prefix = $group->patten_prefix;
            }

            public function &apply(): self
            {
                foreach ($this->rules as &$r) {
                    $r->prefix($this->patten_prefix);
                    $r->middleware(...$this->middlewares);
                }
                return $this;
            }

            public function getRules(): array
            {
                return $this->rules;
            }
        };
        foreach ($trans->apply()->getRules() as $r) {
            $this->appendRule($r);
        }
    }

    protected function appendRule(RouteRule $rule): void
    {
    }

    protected array $rules = [];
}
