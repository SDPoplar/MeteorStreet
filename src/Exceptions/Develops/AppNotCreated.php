<?php
namespace Mxs\Exceptions\Develops;

class AppNotCreated extends MxsDevelop
{
    public function __construct()
    {
        parent::__construct(
            'mxs app not created',
            'create new '.self::class.' in your entry file(like index.php) first'
        );
    }
}
