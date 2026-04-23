<?php
namespace Mxs\Routes;

class RuleGroup
{
    public function append(Rule & $rule)
    {
        $this->rules[] =& $rule;
    }

    public function compile(): array
    {
        //  TODO: inject group attr to rules
        return $this->rules;
    }

    private array $rules = [];
}
