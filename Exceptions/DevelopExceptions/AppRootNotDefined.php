<?php
namespace Mxs\Exceptions\DevelopExceptions;

class AppRootNotDefined extends DevelopBase
{
    protected static function buildMessage(string $msg) : string
    {
        return 'APP_ROOT should be defined at index.php';
    }
}

