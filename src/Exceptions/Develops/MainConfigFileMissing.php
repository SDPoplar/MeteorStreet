<?php
namespace Mxs\Exceptions\Develops;

class MainConfigFileMissing extends MxsDevelop
{
    protected static function buildMessage(string $msg) : string
    {
        return "config file missing, please sure {$msg} exists";
    }
}

