<?php
namespace Mxs\Exceptions\DevelopExceptions;

class ConfigGroupNotFound extends DevelopBase
{
    protected static function buildMessage(string $msg) : string
    {
        return "Config group not found, sure {$msg} exists";
    }
}

