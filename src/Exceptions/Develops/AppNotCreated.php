<?php
namespace Mxs\Exceptions\Develops;

class AppNotCreated extends MxsDevelop
{
    public function __construct()
    {
        parent::__construct(
            'mxs app not created',
            'create new '.\Mxs\App::class.' in your entry file(like index.php) first'
        );
    }
}
