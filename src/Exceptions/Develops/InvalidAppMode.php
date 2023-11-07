<?php
namespace Mxs\Exceptions\Develops;

class InvalidAppMode extends MxsDevelop
{
    public function __construct(string $given_type)
    {
        parent::__construct(
            'Invalid app mode, subclass of '.\Mxs\Modes\Base::class.' wanted, '.$given_type.' given',
            'give valid app mode instead, or make class '.$given_type.' extends '.\Mxs\Modes\Base::class
        );
    }
}
