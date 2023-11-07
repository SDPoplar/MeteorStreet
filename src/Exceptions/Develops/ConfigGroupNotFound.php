<?php
namespace Mxs\Exceptions\Develops;

class ConfigGroupNotFound extends MxsDevelop
{
    protected static function buildMessage(string $msg) : string
    {
        return "Config group not found, sure {$msg} exists";
    }
}

