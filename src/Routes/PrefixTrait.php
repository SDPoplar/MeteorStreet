<?php
namespace Mxs\Routes;

trait PrefixTrait
{
    public function &prefix(string $prefix): self
    {
        $this->patten_prefix = $prefix;
        return $this;
    }

    protected string $patten_prefix = '';
}
