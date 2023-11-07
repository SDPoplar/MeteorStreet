<?php
namespace Mxs\Exceptions\Develops;

class CoreAlreadyCreated extends MxsDevelop
{
    protected function getDescribe(): string
    {
        return 'Mxs core already exists';
    }

    protected function makeProposal(): string
    {
        return @'Mxs is a singleton instance, use \Mxs\Core::get() to get it, instead of *new* one';
    }
}
