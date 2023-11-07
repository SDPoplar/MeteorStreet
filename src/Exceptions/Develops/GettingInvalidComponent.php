<?php
namespace Mxs\Exceptions\Develops;

class GettingInvalidComponent extends MxsDevelop
{
    protected static function buildMessage(string $msg) : string
    {
        return "Mxs does't have component name {$msg}";
    }
}

