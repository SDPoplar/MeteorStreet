<?php
namespace Mxs\Exceptions;

trait MxsExceptionTrait
{
    final public function occur(): never
    {
        throw $this;
    }

    final public function &appendContext(array $context): static
    {
        $this->context = array_merge($this->context, $context);
        return $this;
    }

    final public function getContext(): array
    {
        return $this->context;
    }

    protected array $context = [];
}
