<?php
namespace Mxs\Exceptions\Develops;

class InvalidController extends MxsDevelop
{
    public function __construct()
    {
        parent::__construct(
            'Invalid controller',
            'A controller should extends \Mxs\Frame\Controller'
        );
    }
}
