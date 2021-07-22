<?php
namespace Mxs\Exceptions\DevelopExceptions;

abstract class DevelopBase extends \Mxs\Exceptions\MxsException
{
    abstract protected static function buildMessage(string $msg) : string;

    final public static function throm(string $msg = '') : bool
    {
        $typeName = static::class;
        throw new $typeName(-1, static::buildMessage($msg));
        return true;
    }
}

trait DefBuildMessageTrait
{
    protected static function buildMessage(string $msg) : string
    {
        return $msg;
    }
}

