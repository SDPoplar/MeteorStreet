<?php
namespace Mxs\Exceptions\Develops;

class AppRootNotDefined extends MxsDevelop
{
    protected function getDescribe(): string
    {
        return 'APP_ROOT not defined';
    }

    protected function makeProposal(): string
    {
        return "Define 'APP_ROOT' with dirname(__DIR__) in public/index.php may works";
    }
}

