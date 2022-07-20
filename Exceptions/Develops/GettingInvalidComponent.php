<?php
namespace Mxs\Exceptions\DevelopExceptions;

class GettingInvalidComponent extends DevelopBase
{
    protected static function buildMessage(string $msg) : string
    {
        return "Mxs does't have component name {$msg}";
    }
}

