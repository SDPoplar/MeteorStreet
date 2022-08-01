<?php
namespace Mxs\Exceptions;

trait OccurTrait
{
    public function occur(): never
    {
        throw $this;
    }
}
