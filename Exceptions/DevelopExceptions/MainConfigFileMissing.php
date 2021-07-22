<?php
namespace Mxs\Exceptions\DevelopExceptions;

class MainConfigFileMissing extends DevelopBase
{
    protected static function buildMessage(string $msg) : string
    {
        return "config file missing, please sure {$msg} exists";
    }
}

