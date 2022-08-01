<?php
namespace Mxs\Exceptions\Develops;

abstract class Base extends \LogicException
{
    use \Mxs\Exceptions\OccurTrait;

    abstract protected function makeProposal(): string;

    public function __construct(string $message)
    {
        $this->proposal = $this->makeProposal();
        parent::__construct($message);
    }

    public readonly string $proposal;
}
