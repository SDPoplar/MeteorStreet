<?php
namespace Mxs\Exceptions;

trait OccurTrait
{
    public function occur(): bool
    {
        throw $this;
        return true;
    }
}
