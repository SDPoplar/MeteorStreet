<?php
namespace Mxs\Exceptions\Develops;

class InvalidAppMode extends MxsDevelop
{
    /**
     * construct a 'InvalidAppMode' exception
     * @param string $given_type: invalid app mode type name 
     */
    public function __construct(string $given_type)
    {
        parent::__construct(
            'Invalid app mode, subclass of '.\Mxs\Frame\AppMode::class.' wanted, '.$given_type.' given',
            'give valid app mode instead, or make class '.$given_type.' extends '.\Mxs\Frame\AppMode::class
        );
    }
}
