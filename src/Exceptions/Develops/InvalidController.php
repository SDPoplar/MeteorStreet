<?php
namespace Mxs\Exceptions\Develops;

class InvalidController extends MxsDevelop
{
    public function __construct()
    {
        parent::__construct('Invalid controller');
    }
    
    protected function makeProposal(): string
    {
        return 'A controller should extends \Mxs\Frame\Controller';
    }
}
