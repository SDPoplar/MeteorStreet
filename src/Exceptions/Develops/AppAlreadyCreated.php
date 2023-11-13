<?php
namespace Mxs\Exceptions\Develops;

class AppAlreadyCreated extends MxsDevelop
{
    public function __construct()
    {
        parent::__construct(
            'mxs app already exists',
            'app has already created, use '.self::class.'::get() to get it, instead of *new* one'
        );
    }
}
