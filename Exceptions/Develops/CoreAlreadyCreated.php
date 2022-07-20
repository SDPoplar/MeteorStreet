<?php
namespace Mxs\Exceptions\Develops;

class CoreAlreadyCreated extends Base
{
    protected function getDescribe(): string
    {
        return 'Mxs core already exists';
    }

    protected function getProposal(): string
    {
        return @'Mxs is a singleton instance, use \Mxs\Core::get() to get it, instead of *new* one';
    }
}
