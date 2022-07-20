<?php
namespace Mxs\Exceptions\Develops;

abstract class Base extends \LogicException
{
    abstract protected function getDescribe(): string;
    abstract protected function getProposal(): string;

    public static function Occur(): bool
    {
        throw new static();
        return true;
    }

    public function __construct()
    {
        $this->proposal = $this->getProposal();
        parent::__construct($this->getDescribe());
    }

    public readonly string $proposal;
}
