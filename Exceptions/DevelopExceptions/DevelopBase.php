<?php
namespace Mxs\Exceptions\DevelopExceptions;

abstract class DevelopBase extends \Mxs\Exceptions\MxsException
{
    public static function throm( string $msg ) : bool {
        $typeName = static::class;
        throw new $typeName( -1, $msg );
        return true;
    }
}

